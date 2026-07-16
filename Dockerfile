# =====================================================================
# ADMIN.SERVICIO.IT — Dockerfile multi-stage
# =====================================================================
# Stage 1: Compila assets del tema SERVICIO IT (Node.js + Vite)
# Stage 2: Imagen final (hereda Billmora oficial + módulos + tema custom)
# =====================================================================

# ---- Stage 1: Build SERVICIO IT Theme Assets ----
FROM node:22-alpine AS theme-builder
WORKDIR /app

COPY package*.json ./
RUN npm ci

# Copy theme source files (CSS + JS + views para build)
# ⚠️ Tailwind 4 usa @source para escanear vistas en busca de clases.
# Sin las vistas, el CSS sale sin utilidades (.flex, .grid, etc.)
COPY resources/themes/admin/servicioit/ resources/themes/admin/servicioit/
COPY resources/themes/client/servicioit/ resources/themes/client/servicioit/
COPY resources/themes/portal/servicioit/ resources/themes/portal/servicioit/

# Copy plugin views (requeridas por @source en app.css)
# NOTA: vendor/ no existe en el repo (gitignored). Las vistas de vendor
# usan el CSS del tema moraine de Billmora, no afectan al tema servicioit.
COPY plugin/ plugin/

# Build each theme
RUN npx vite build --config=resources/themes/admin/servicioit/vite.config.js && \
    npx vite build --config=resources/themes/client/servicioit/vite.config.js && \
    npx vite build --config=resources/themes/portal/servicioit/vite.config.js

# ---- Stage 2: Production Image ----
FROM ghcr.io/billmora/billmora:1.0.0

USER root

# Copy compiled theme assets
COPY --from=theme-builder /app/public/themes/admin/servicioit/ /var/www/html/public/themes/admin/servicioit/
COPY --from=theme-builder /app/public/themes/client/servicioit/ /var/www/html/public/themes/client/servicioit/
COPY --from=theme-builder /app/public/themes/portal/servicioit/ /var/www/html/public/themes/portal/servicioit/

# Copy theme source (theme.json + views)
COPY resources/themes/admin/servicioit/theme.json /var/www/html/resources/themes/admin/servicioit/theme.json
COPY resources/themes/admin/servicioit/views/ /var/www/html/resources/themes/admin/servicioit/views/
COPY resources/themes/client/servicioit/theme.json /var/www/html/resources/themes/client/servicioit/theme.json
COPY resources/themes/client/servicioit/views/ /var/www/html/resources/themes/client/servicioit/views/
COPY resources/themes/portal/servicioit/theme.json /var/www/html/resources/themes/portal/servicioit/theme.json
COPY resources/themes/portal/servicioit/views/ /var/www/html/resources/themes/portal/servicioit/views/

# Copy traducciones español
COPY lang/es_CO/ /var/www/html/lang/es_CO/

# Copy módulos custom SERVICIO IT
COPY plugin/Modules/ServicioITSystem/ /var/www/html/plugin/Modules/ServicioITSystem/

# Copy registrar plugins
COPY plugin/Registrars/ /var/www/html/plugin/Registrars/

# Copy providers custom
COPY bootstrap/custom-providers.php /var/www/html/bootstrap/custom-providers.php
COPY bootstrap/providers.php /var/www/html/bootstrap/providers.php

# Copy restore script
COPY scripts/restore-after-update.sh /var/www/html/scripts/restore-after-update.sh

# === COPIAR CSS COMPILADO: Moraine → servicioit + rosa ===
RUN for type in admin client portal; do \
      mkdir -p /var/www/html/public/themes/${type}/servicioit/css \
               /var/www/html/public/themes/${type}/servicioit/js; \
      cp /var/www/html/public/themes/${type}/moraine/css/style.css \
         /var/www/html/public/themes/${type}/servicioit/css/ 2>/dev/null || true; \
      cp /var/www/html/public/themes/${type}/moraine/js/app.js \
         /var/www/html/public/themes/${type}/servicioit/js/ 2>/dev/null || true; \
      sed -i \
        -e 's/#f0f0ff/#fdf2f7/g' -e 's/#e0e0ff/#fce7f0/g' \
        -e 's/#c2c2ff/#f9c5df/g' -e 's/#9494ff/#f595c4/g' \
        -e 's/#7b71f9/#f060a3/g' -e 's/#7267ef/#e3167a/g' \
        -e 's/#6659e0/#c41469/g' -e 's/#5345cc/#991152/g' \
        -e 's/#4338a8/#6e0c3b/g' -e 's/#383087/#440724/g' \
        /var/www/html/public/themes/${type}/servicioit/css/style.css 2>/dev/null || true; \
    done

# Crear symlink storage para logo
RUN php artisan storage:link

# Permisos
RUN chown -R www-data:www-data /var/www/html/public/themes/admin/servicioit/ \
    /var/www/html/public/themes/client/servicioit/ \
    /var/www/html/public/themes/portal/servicioit/ \
    /var/www/html/resources/themes/admin/servicioit/ \
    /var/www/html/resources/themes/client/servicioit/ \
    /var/www/html/resources/themes/portal/servicioit/ \
    /var/www/html/lang/es_CO/ \
    /var/www/html/plugin/Modules/ServicioITSystem/ \
    /var/www/html/plugin/Registrars/ \
    && chmod -R 755 /var/www/html/public/themes/ \
    /var/www/html/resources/themes/ \
    /var/www/html/lang/es_CO/ \
    /var/www/html/plugin/Modules/ServicioITSystem/ \
    /var/www/html/plugin/Registrars/

# Crear symlink storage para logo (se pierde en cada deploy)
RUN php artisan storage:link

EXPOSE 8080
