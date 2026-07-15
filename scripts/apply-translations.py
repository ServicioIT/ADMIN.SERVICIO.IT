#!/usr/bin/env python3
"""
Reconstruct translated PHP files from translated JSON.
Reads /tmp/billmora-es.json (manually translated) and writes PHP files.
"""
import os, re, json

TARGET = os.path.join(os.path.dirname(__file__), '..', 'plugin', 'Modules', 'ServicioITSystem', 'lang', 'es_CO')

def unflatten_to_php(data, rel_path, strings):
    """Reconstruct nested PHP array from flat strings for a given relative path."""
    prefix = rel_path + '.'
    result = {}
    for k, v in strings.items():
        if k.startswith(prefix):
            parts = k[len(prefix):].split('.')
            current = result
            for part in parts[:-1]:
                if part not in current:
                    current[part] = {}
                current = current[part]
            current[parts[-1]] = v
    return result

def dict_to_php(d, indent=0):
    """Convert Python dict to PHP array string."""
    if not isinstance(d, dict) or not d:
        return '[]'
    prefix = '    ' * indent
    inner = '    ' * (indent + 1)
    lines = ['[']
    items = list(d.items())
    for i, (k, v) in enumerate(items):
        comma = ',' if i < len(items) - 1 else ''
        if isinstance(v, dict):
            lines.append(f"{inner}'{k}' => {dict_to_php(v, indent + 1)}{comma}")
        elif isinstance(v, str):
            escaped = v.replace('\\', '\\\\').replace("'", "\\'")
            lines.append(f"{inner}'{k}' => '{escaped}'{comma}")
        else:
            lines.append(f"{inner}'{k}' => {v}{comma}")
    lines.append(f"{prefix}]")
    return '\n'.join(lines)

def write_php_file(rel, data):
    filepath = os.path.join(TARGET, rel + '.php')
    os.makedirs(os.path.dirname(filepath), exist_ok=True)
    content = "<?php\n\nreturn " + dict_to_php(data) + ";\n"
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

def main():
    with open('/tmp/billmora-es.json', 'r', encoding='utf-8') as f:
        translated = json.load(f)
    
    # Get all unique file prefixes
    files = set()
    for k in translated:
        # k format: "admin/dashboard::title"
        parts = k.split('::')
        if len(parts) == 2:
            files.add(parts[0])
    
    for rel in sorted(files):
        data = unflatten_to_php(None, rel, translated)
        write_php_file(rel, data)
        # Count strings in this file
        count = sum(1 for k in translated if k.startswith(rel + '::'))
        print(f'  Wrote {rel}.php ({count} strings)')
    
    print(f'\nDone. {len(files)} files written to {TARGET}')

if __name__ == '__main__':
    main()
