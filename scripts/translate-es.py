#!/usr/bin/env python3
"""
Billmora Spanish Translation Generator
=======================================
Traduce todos los archivos PHP de lang/en_US/ → lang/es_CO/ usando Z.AI API.
Preserva placeholders Laravel (:attribute, :name, etc.) y estructura de arrays.
"""

import os
import re
import json
import sys
import time
import urllib.request
import urllib.error

# === CONFIG ===
SOURCE_DIR = os.path.join(os.path.dirname(__file__), '..', 'lang', 'en_US')
TARGET_DIR = os.path.join(os.path.dirname(__file__), '..', 'plugin', 'Modules', 'ServicioITSystem', 'lang', 'es_CO')

ZAI_API_KEY = os.environ.get('ZAI_API_KEY', '')
ZAI_API_URL = 'https://api.z.ai/api/paas/v4/chat/completions'
MODEL = 'glm-4-flash'  # fast & cheap for translation

BATCH_SIZE = 15  # strings per API call
SLEEP_BETWEEN_BATCHES = 1.5  # seconds

# === PLACEHOLDER PROTECTION ===
PLACEHOLDER_RE = re.compile(r':[a-z_]+')  # :attribute, :name, :count, etc.

def mask_placeholders(text):
    """Replace :placeholders with {{0}}, {{1}}, etc. for safe translation."""
    placeholders = PLACEHOLDER_RE.findall(text)
    masked = text
    for i, ph in enumerate(placeholders):
        masked = masked.replace(ph, f'{{{{PH{i}}}}}', 1)
    return masked, placeholders

def unmask_placeholders(text, placeholders):
    """Restore :placeholders from masked form."""
    for i, ph in enumerate(placeholders):
        text = text.replace(f'{{{{PH{i}}}}}', ph)
    return text


# === PHP PARSER ===
def parse_php_array(filepath):
    """Parse a PHP file that returns an array into a Python dict."""
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Extract the array between 'return [' and the final '];'
    match = re.search(r'return\s*\[(.*)\];', content, re.DOTALL)
    if not match:
        print(f"  SKIP: could not parse {filepath}")
        return {}
    
    array_str = match.group(1)
    return _parse_nested_array(array_str)

def _parse_nested_array(text, depth=0):
    """Recursively parse a PHP nested array string into Python dict."""
    result = {}
    # Simple key-value regex: 'key' => value, or 'key' => [ ... ],
    # This is a simplified parser that handles Billmora's format
    i = 0
    text = text.strip()
    
    while i < len(text):
        # Find next key
        key_match = re.match(r'\s*[\'"](\w+)[\'"]\s*=>\s*', text[i:])
        if not key_match:
            break
        
        key = key_match.group(1)
        i += key_match.end()
        
        # Value can be: string, number, or nested array
        rest = text[i:].strip()
        
        if rest.startswith('['):
            # Nested array - find matching ]
            nested, consumed = _extract_bracket_content(text[i:])
            result[key] = _parse_nested_array(nested, depth + 1)
            i += consumed
        elif rest.startswith("'") or rest.startswith('"'):
            # String value
            quote = rest[0]
            str_match = re.match(rf'{quote}((?:[^{quote}\\]|\\.)*){quote}', rest)
            if str_match:
                val = str_match.group(1)
                # Unescape
                val = val.replace("\\'", "'").replace('\\"', '"').replace('\\\\', '\\')
                result[key] = val
                i += str_match.end()
            else:
                i += 1
        else:
            # Number or other value
            val_match = re.match(r'([^,\]]+)', rest)
            if val_match:
                val = val_match.group(1).strip()
                try:
                    result[key] = int(val)
                except ValueError:
                    result[key] = val
                i += val_match.end()
        
        # Skip comma and spaces
        comma_match = re.match(r'\s*,?\s*', text[i:])
        if comma_match:
            i += comma_match.end()
    
    return result

def _extract_bracket_content(text):
    """Extract content inside brackets, handling nesting."""
    if not text.startswith('['):
        return '', 0
    depth = 0
    i = 0
    while i < len(text):
        if text[i] == '[':
            depth += 1
        elif text[i] == ']':
            depth -= 1
            if depth == 0:
                return text[1:i], i + 1
        i += 1
    return text[1:], len(text)


# === ARRAY FLATTENING ===
def flatten_array(arr, prefix=''):
    """Flatten nested dict to dot-notation leaf key-values."""
    result = {}
    for k, v in arr.items():
        full_key = f"{prefix}.{k}" if prefix else k
        if isinstance(v, dict):
            result.update(flatten_array(v, full_key))
        elif isinstance(v, str) and len(v) > 0:
            result[full_key] = v
    return result

def unflatten_array(flat):
    """Convert flat dot-notation dict back to nested dict."""
    result = {}
    for key, value in flat.items():
        parts = key.split('.')
        current = result
        for part in parts[:-1]:
            if part not in current:
                current[part] = {}
            current = current[part]
        current[parts[-1]] = value
    return result


# === PHP WRITER ===
def write_php_array(data, filepath):
    """Write a Python dict as a PHP array file."""
    content = "<?php\n\nreturn " + _dict_to_php(data, 0) + ";\n"
    os.makedirs(os.path.dirname(filepath), exist_ok=True)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

def _dict_to_php(data, indent=0):
    """Convert Python dict/nested to PHP array string."""
    if isinstance(data, dict):
        if not data:
            return '[]'
        prefix = '    ' * indent
        inner_prefix = '    ' * (indent + 1)
        lines = ['[']
        items = list(data.items())
        for idx, (k, v) in enumerate(items):
            comma = ',' if idx < len(items) - 1 else ''
            if isinstance(v, dict):
                lines.append(f"{inner_prefix}'{k}' => {_dict_to_php(v, indent + 1)}{comma}")
            elif isinstance(v, str):
                escaped = v.replace('\\', '\\\\').replace("'", "\\'")
                lines.append(f"{inner_prefix}'{k}' => '{escaped}'{comma}")
            else:
                lines.append(f"{inner_prefix}'{k}' => {v}{comma}")
        lines.append(f"{prefix}]")
        return '\n'.join(lines)
    return str(data)


# === TRANSLATION ===
def translate_batch(texts):
    """Translate a list of English strings to Spanish using Z.AI."""
    prompt = (
        "Translate these English UI strings to Spanish (Latin American). "
        "These are for billing/admin software. Keep technical terms. "
        "IMPORTANT: preserve ALL {{PH0}}, {{PH1}} etc. placeholders exactly. "
        "Return valid JSON: {\"translations\": [\"str1\", \"str2\", ...]}\n\n"
        "Strings:\n"
    )
    for i, t in enumerate(texts):
        prompt += f"{i+1}. {t}\n"
    prompt += '\nReturn only the JSON object with key "translations".'

    payload = json.dumps({
        "model": MODEL,
        "messages": [
            {"role": "system", "content": "You translate UI strings to Spanish (Latin American). Return only JSON."},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.1,
        "max_tokens": 4000,
        "response_format": {"type": "json_object"}
    })

    req = urllib.request.Request(
        ZAI_API_URL,
        data=payload.encode('utf-8'),
        headers={
            'Authorization': f'Bearer {ZAI_API_KEY}',
            'Content-Type': 'application/json',
        }
    )

    try:
        with urllib.request.urlopen(req, timeout=60) as resp:
            data = json.loads(resp.read())
            content = data['choices'][0]['message']['content']
            result = json.loads(content)
            return result.get('translations', texts)
    except Exception as e:
        print(f"  Translation error: {e}")
        return texts


# === MAIN ===
def main():
    if not ZAI_API_KEY:
        print("ERROR: ZAI_API_KEY not set in environment")
        sys.exit(1)

    print(f"Source: {SOURCE_DIR}")
    print(f"Target: {TARGET_DIR}")
    print(f"Model: {MODEL}")

    # Collect all PHP files
    php_files = []
    for root, dirs, files in os.walk(SOURCE_DIR):
        for f in files:
            if f.endswith('.php'):
                php_files.append(os.path.join(root, f))

    print(f"Found {len(php_files)} PHP files to process\n")

    total_strings = 0
    total_translated = 0

    for filepath in sorted(php_files):
        rel_path = os.path.relpath(filepath, SOURCE_DIR)
        target_path = os.path.join(TARGET_DIR, rel_path)

        # Parse original
        data = parse_php_array(filepath)
        if not data:
            continue

        # Flatten to get all leaf strings
        flat = flatten_array(data)
        if not flat:
            print(f"  COPY (no strings): {rel_path}")
            write_php_array(data, target_path)
            continue

        # Check if all values are already translated (different from EN)
        # For now, translate everything
        
        keys = list(flat.keys())
        values = list(flat.values())

        # Mask placeholders for safe translation
        masked_values = []
        all_placeholders = []
        for v in values:
            masked, phs = mask_placeholders(v)
            masked_values.append(masked)
            all_placeholders.append(phs)

        # Translate in batches
        translated_values = []
        for batch_start in range(0, len(values), BATCH_SIZE):
            batch_end = min(batch_start + BATCH_SIZE, len(values))
            batch = masked_values[batch_start:batch_end]
            
            print(f"  Translating {rel_path}: strings {batch_start+1}-{batch_end}/{len(values)}")
            batch_translated = translate_batch(batch)
            
            if batch_translated and len(batch_translated) == len(batch):
                translated_values.extend(batch_translated)
            else:
                translated_values.extend(batch)  # fallback to original
            
            if batch_end < len(values):
                time.sleep(SLEEP_BETWEEN_BATCHES)

        # Unmask placeholders
        final_values = []
        for i, tv in enumerate(translated_values):
            final_values.append(unmask_placeholders(tv, all_placeholders[i]))

        # Rebuild flat dict with translated values
        new_flat = dict(zip(keys, final_values))
        
        # Unflatten back to nested dict
        new_data = unflatten_array(new_flat)

        # Write target file
        write_php_array(new_data, target_path)
        
        total_strings += len(values)
        total_translated += len(values)
        print(f"  DONE: {rel_path} ({len(values)} strings)\n")

    print(f"\n{'='*50}")
    print(f"TOTAL: {total_strings} strings translated")
    print(f"Files written to: {TARGET_DIR}")


if __name__ == '__main__':
    main()
