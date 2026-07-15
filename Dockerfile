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

# Copy theme source files (CSS + JS para build)
COPY resources/themes/admin/servicioit/css/ resources/themes/admin/servicioit/css/
COPY resources/themes/admin/servicioit/js/ resources/themes/admin/servicioit/js/
COPY resources/themes/admin/servicioit/vite.config.js resources/themes/admin/servicioit/vite.config.js
COPY resources/themes/client/servicioit/css/ resources/themes/client/servicioit/css/
COPY resources/themes/client/servicioit/js/ resources/themes/client/servicioit/js/
COPY resources/themes/client/servicioit/vite.config.js resources/themes/client/servicioit/vite.config.js
COPY resources/themes/portal/servicioit/css/ resources/themes/portal/servicioit/css/
COPY resources/themes/portal/servicioit/js/ resources/themes/portal/servicioit/js/
COPY resources/themes/portal/servicioit/vite.config.js resources/themes/portal/servicioit/vite.config.js

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

# Copy providers custom
COPY bootstrap/custom-providers.php /var/www/html/bootstrap/custom-providers.php
COPY bootstrap/providers.php /var/www/html/bootstrap/providers.php

# Permisos
RUN chown -R www-data:www-data /var/www/html/public/themes/admin/servicioit/ \
    /var/www/html/public/themes/client/servicioit/ \
    /var/www/html/public/themes/portal/servicioit/ \
    /var/www/html/resources/themes/admin/servicioit/ \
    /var/www/html/resources/themes/client/servicioit/ \
    /var/www/html/resources/themes/portal/servicioit/ \
    /var/www/html/lang/es_CO/ \
    /var/www/html/plugin/Modules/ServicioITSystem/ \
    && chmod -R 755 /var/www/html/public/themes/ \
    /var/www/html/resources/themes/ \
    /var/www/html/lang/es_CO/ \
    /var/www/html/plugin/Modules/ServicioITSystem/

EXPOSE 8080
