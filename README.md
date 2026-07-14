# ADMIN.SERVICIO.IT — Fork de Billmora + Módulos SERVICIO IT

> **Fork de [Billmora/billmora](https://github.com/Billmora/billmora) con módulos custom de SERVICIO IT.**
> Desplegado en MONTREAL vía Dokploy: [admin.servicio.it](https://admin.servicio.it)

---

## ⚠️ Importante: Estrategia de desarrollo

Este es un **fork** del repositorio oficial de Billmora. Seguimos una estrategia
de **módulos independientes** para poder actualizar el core sin perder nuestras
personalizaciones:

| Capa | Ubicación | Se modifica |
|------|-----------|:-----------:|
| **Core Billmora** | `app/`, `config/`, `routes/`, `resources/` | ❌ Nunca |
| **Módulos custom** | `plugin/Modules/ServicioITSystem/` | ✅ Libremente |
| **Providers custom** | `bootstrap/custom-providers.php` | ✅ Libremente |
| **Dockerfile custom** | `Dockerfile` (extiende imagen oficial) | ✅ Libremente |
| **Docker Compose** | `docker-compose.yml` | ✅ Libremente |

### Workflow de actualización

```bash
# 1. Pull de upstream (nuevas versiones de Billmora)
git fetch upstream
git merge upstream/main
# → Cero conflictos porque nuestros archivos no existen upstream

# 2. Actualizar imagen base en Dockerfile
# Cambiar: FROM ghcr.io/billmora/billmora:1.0.0 → :1.0.1

# 3. Deploy
git push origin main
# → Dokploy auto-deploy
```

### Estructura del módulo SERVICIO IT

```
plugin/Modules/ServicioITSystem/
├── plugin.json                          # Manifiesto
├── ServicioITSystemModule.php           # Módulo principal (AbstractPlugin + ModuleInterface)
├── config/
│   └── servicioit.php                   # Overrides de configuración
├── database/
│   ├── migrations/                      # Migraciones propias
│   └── seeders/
│       └── SettingsSeeder.php           # Config inicial (idempotente)
├── resources/views/                     # Vistas custom (admin/client)
└── routes/                              # Rutas custom
```

### Comandos útiles

```bash
# Instalar módulo en BD (solo la primera vez)
docker exec <container> php artisan tinker --execute="
  \\App\\Models\\Plugin::create([
    'name' => 'ServicioIT System',
    'provider' => 'ServicioITSystem',
    'type' => 'module',
    'is_active' => true,
  ]);
"

# Ejecutar seeder de configuraciones
docker exec <container> php artisan db:seed --class="Plugins\\Modules\\ServicioITSystem\\Database\\Seeders\\SettingsSeeder"

# Ver logs
ssh MONTREAL "docker logs admin-servicio-it-5msqgx-billmora-1 --tail 50"
```

---

## Documentación original de Billmora

A continuación, el README original del proyecto base:

---

<p align="center">
  <a href="https://billmora.com">
    <img src="https://media.billmora.com/logo/main-bgnone.png" width="128px" alt="Billmora" style="border-radius: 15px;">
  </a>
</p>

<h1 align="center">Billmora</h1>

<p align="center">
  Run Your Hosting Business. Pay Nothing.<br>
  Open-source billing management with automated provisioning, recurring automation, and full control — forever free.
</p>

<p align="center">
  <img src="https://img.shields.io/github/downloads/Billmora/billmora/total?style=flat-square&color=blue&label=Downloads">
  <img src="https://img.shields.io/github/v/release/Billmora/billmora?style=flat-square&color=blue&label=Release">
  <img src="https://img.shields.io/discord/1334815648534102076?style=flat-square&color=blue&label=Discord&logo=Discord&logoColor=white">
</p>

## What is Billmora?

Billmora — short for **Billing Management, Operation, and Recurring Automation** —
is a free, open-source platform built for hosting providers and service businesses
that need full control over their billing infrastructure without paying recurring
licensing fees.

Built on Laravel, Billmora provides a complete ecosystem for managing clients,
automating invoices and renewals, handling support tickets, and provisioning server
environments across multiple control panels. It is designed to be self-hosted,
extensible, and community-driven.

![Billmora Dashboard Overview](https://media.billmora.com/image/admin-dashboard.png)

## Key Features

- **Plugin-Based Provisioning** — Extend and manage server provisioning through
  an isolated plugin system supporting DirectAdmin, cPanel, Pterodactyl, Proxmox,
  and more.
- **Billing, Invoicing & Orders** — Handle the full billing lifecycle from checkout
  and order creation to recurring invoices, credit wallet, and coupon support.
- **Automation Engine** — Automate renewals, suspensions, terminations, invoice
  reminders, and ticket closures on a fully scheduled engine.
- **Support Ticket System** — A built-in helpdesk with departments, email piping,
  file attachments, and auto-closure for inactive tickets.
- **Multi-Currency & Tax Management** — Support global operations with multi-currency
  pricing, region-based tax rates, and a client credit wallet.
- **Security, Roles & Audit Logs** — Granular role permissions, two-factor
  authentication, and comprehensive audit trails across all platform activity.
- **Task Queue & Monitoring** — Track, manage, and retry failed background
  operations from a centralized system task log.
- **Customizable Notifications** — Multi-language email templates for invoices,
  service updates, and support communications.

## Links

- [Website](https://billmora.com)
- [Documentation](https://billmora.com/docs/introduction)
- [Demo](https://demo.billmora.com)
- [Marketplace](https://market.billmora.com)
- [Discord Community](https://dsc.gg/billmora)

## Contributing

Contributions are welcome. Please read the contributing guidelines before
submitting a pull request. For major changes, open an issue first to discuss
what you would like to change.

## Sponsors

We would like to thank the following sponsors for supporting the development
of Billmora.

_(Become a sponsor to have your name or logo featured here.)_

## Repository Activity

![Repobeats Analytics](https://repobeats.axiom.co/api/embed/10dcae2b571138e9211b450237a32a4d9c3406c7.svg "Repobeats analytics image")

## License

Billmora is open-source software licensed under the
[MIT License](https://opensource.org/licenses/MIT).
