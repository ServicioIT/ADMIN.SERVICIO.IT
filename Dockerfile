# =====================================================================
# ADMIN.SERVICIO.IT — Dockerfile custom (extiende imagen oficial Billmora)
# =====================================================================
# Hereda la imagen pre-compilada de Billmora y agrega los módulos custom
# de SERVICIO IT sin modificar el core ni recompilar assets.
#
# La imagen base ya contiene:
#   - Laravel 12 + PHP 8.3 FPM + Nginx (serversideup/php)
#   - Dependencias Composer instaladas
#   - Assets Vite compilados (admin, client, portal themes)
#   - Entrypoint que genera APP_KEY si no existe
#
# Build:  docker build -t admin-servicio-it:custom .
# Deploy: Dokploy usa este Dockerfile automáticamente (build: .)
# =====================================================================

FROM ghcr.io/billmora/billmora:1.0.0

USER root

# Copiar traducciones español (es_CO = es_ES del repo, con flag Colombia)
COPY lang/es_CO/ /var/www/html/lang/es_CO/

# Copiar módulos custom de SERVICIO IT
COPY plugin/Modules/ServicioITSystem/ /var/www/html/plugin/Modules/ServicioITSystem/

# Copiar providers custom (archivo nuevo — no existe upstream)
COPY bootstrap/custom-providers.php /var/www/html/bootstrap/custom-providers.php

# Copiar providers.php modificado (agrega include de custom-providers.php)
COPY bootstrap/providers.php /var/www/html/bootstrap/providers.php

# Asegurar permisos
RUN chown -R www-data:www-data /var/www/html/lang/es_CO/ \
    && chown -R www-data:www-data /var/www/html/plugin/Modules/ServicioITSystem/ \
    && chmod -R 755 /var/www/html/lang/es_CO/ \
    && chmod -R 755 /var/www/html/plugin/Modules/ServicioITSystem/

# Puerto ya expuesto por la imagen base (8080)
# Entrypoint y CMD se heredan de la imagen oficial
