#!/bin/bash
# =============================================================================
# restore-after-update.sh — Restaura personalizaciones SERVICIO IT
# tras un one-click update de Billmora que borra public/themes/ y storage link
# =============================================================================
# Ejecutar: docker exec <container> bash /var/www/html/scripts/restore-after-update.sh

set -e

echo "[SERVICIO IT] Restaurando assets del tema..."

# 1. Recrear CSS/JS de servicioit copiando de Moraine + aplicando rosa
for type in admin client portal; do
    SRC="/var/www/html/public/themes/${type}/moraine/css/style.css"
    DST="/var/www/html/public/themes/${type}/servicioit/css/style.css"
    if [ -f "$SRC" ]; then
        mkdir -p "$(dirname "$DST")"
        cp "$SRC" "$DST"
        sed -i \
            -e 's/#f0f0ff/#fdf2f7/g' -e 's/#e0e0ff/#fce7f0/g' \
            -e 's/#c2c2ff/#f9c5df/g' -e 's/#9494ff/#f595c4/g' \
            -e 's/#7b71f9/#f060a3/g' -e 's/#7267ef/#e3167a/g' \
            -e 's/#6659e0/#c41469/g' -e 's/#5345cc/#991152/g' \
            -e 's/#4338a8/#6e0c3b/g' -e 's/#383087/#440724/g' \
            "$DST"
        echo "  [OK] ${type} CSS: $(wc -c < "$DST") bytes"
    fi
    
    # JS
    JS_SRC="/var/www/html/public/themes/${type}/moraine/js/app.js"
    JS_DST="/var/www/html/public/themes/${type}/servicioit/js/app.js"
    if [ -f "$JS_SRC" ]; then
        mkdir -p "$(dirname "$JS_DST")"
        cp "$JS_SRC" "$JS_DST"
    fi
done

# 2. Recrear symlink storage
php artisan storage:link 2>/dev/null || true

# 3. Limpiar caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear

echo "[SERVICIO IT] Restauración completada."
