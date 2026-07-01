# TaskFlow — Project Task Manager

A Kanban-style project management app built with **Laravel 12 + Livewire 3 + Tailwind CSS**.

## Features

- **Projects** — Create, search, filter, and manage projects
- **Kanban Board** — 4 columns (Todo / In Progress / Review / Done) with inline status updates
- **Tasks** — Create, assign, prioritize, tag, and comment on tasks
- **Activity Log** — Full audit trail of all changes with search and pagination
- **Role-Based Access** — Admin, Manager, and Member roles via Spatie Permissions
- **Auth** — Login, register, password reset via Breeze (Livewire Volt)

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Livewire 3, Alpine.js, Tailwind CSS, Vite |
| Database | MySQL 8.0 (Docker) |
| Auth | Laravel Breeze (Livewire Volt) |
| Permissions | Spatie Laravel Permission |
| Logging | Spatie Laravel Activitylog |
| Infrastructure | Docker Compose (nginx + php-fpm + mysql + phpMyAdmin) |

## Quick Start

```bash
# Start Docker containers
docker compose up -d

# Install PHP dependencies
docker compose exec php-fpm composer install

# Run migrations and seed demo data
docker compose exec php-fpm php artisan migrate --seed

# Install & build frontend
npm install && npm run build
```

Visit **http://localhost:8080**

### phpMyAdmin
Visit **http://localhost:8081** (Server: `mysql`, User: `laravel`, Password: `secret`)

## Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Manager | manager@example.com | password |
| Member | member@example.com | password |

## Architecture

### Request Flow

Browser -> Nginx (port 8080) -> PHP-FPM -> Livewire Component -> Blade View —> MySQL (via Eloquent)

### Key Files

| File | Purpose |
|------|---------|
| app/Livewire/Projects/Index.php | Project list with search, filter, and create |
| app/Livewire/Projects/Show.php | Kanban board with 4 columns, task CRUD |
| app/Livewire/Tasks/Show.php | Task detail view with comment thread |
| app/Livewire/Dashboard.php | Stats overview and recent activity |
| app/Livewire/Activity/Index.php | Full activity log with search/pagination |
| app/Livewire/Users/Index.php | User role management (admin only) |
| app/Models/Project.php | Project model with status enum + LogsActivity |
| app/Models/Task.php | Task model with status/priority enums |
| app/Models/Comment.php | Comment model with activity logging |
| app/Models/Tag.php | Tag model with color, many-to-many with tasks |
| app/Enums/ProjectStatus.php | active, completed, archived |
| app/Enums/TaskStatus.php | todo, in_progress, review, done, cancelled |
| app/Enums/TaskPriority.php | low, medium, high, urgent |

## Design Decisions

1. **String-backed Enums** — Clean DB storage (VARCHAR) with PHP type safety
2. **Computed Properties** — Kanban columns use #[Computed] for per-request caching
3. **Server-side Authorization** — All mutations gated via `$this->authorize()`, not just Blade @can
4. **Enum ->value in Blade** — Enums dont match strings directly; use `$enum->value` in comparisons
5. **Alpine.js Animations** — Counter effects on stats, staggered card entries, page transitions

## Docker Services

| Service | Image | Port | Config File |
|---------|-------|------|-------------|
| nginx | nginx:alpine | 8080 | `docker/nginx/default.conf` |
| php-fpm | php:8.2-fpm (custom) | --- | `docker/php/Dockerfile` |
| mysql | mysql:8.0 | 3306 | `docker-compose.yml` |
| phpMyAdmin | phpmyadmin/phpmyadmin | 8081 | `docker-compose.yml` |

### Containerization Files

| File | What It Does |
|------|-------------|
| `docker-compose.yml` | Defines all 4 services, port mappings, volumes, and environment variables |
| `docker/php/Dockerfile` | Custom PHP 8.2 image with pdo_mysql, mbstring, xml, curl, zip extensions |
| `docker/nginx/default.conf` | Nginx config — routes all requests to `php-fpm:9000` |

### Useful Commands

```bash
docker compose ps              # List running containers
docker compose logs nginx      # View nginx logs
docker compose exec php-fpm bash  # SSH into PHP container
docker compose down            # Stop all containers
```

## How It Was Built (Step by Step)

1. **Laravel 12 scaffold** — `composer create-project laravel/laravel` then Docker Compose for nginx + php-fpm + mysql
2. **Breeze auth** — Installed Livewire Volt stack for login/register/password-reset
3. **Models + Migrations** — Created Project, Task, Comment, Tag models with relationships, foreign keys, and string-backed enum casts
4. **Spatie packages** — Installed laravel-permission for roles (admin/manager/member) and laravel-activitylog for audit trail
5. **Enums** — Custom string-backed enums for ProjectStatus, TaskStatus, TaskPriority
6. **Livewire components** — Full-page components for Dashboard, Projects Index/Show, Tasks Show, Activity Index, Users Index
7. **Seeder** — Seeds 3 roles, 9 permissions, 3 demo users, 2 projects, 10 tasks, 4 tags, comments
8. **Authorization gates** — Wired Spatie permissions into Laravel gates; all Livewire mutations use `$this->authorize()`
9. **UI polish** — Dark sidebar layout, gradients, responsive Kanban, Alpine.js animations
10. **Bug fixes** — Fixed enum comparison (`->value`), status filter naming, storage permissions
11. **CI fix** — Added `bootstrap/cache` directory creation + `.gitkeep` for GitHub Actions workflow
12. **Button loading states** — All buttons show spinners and disable during processing
13. **Page transitions** — Fade/slide animations on page navigation via `wire:transition`
14. **Modal animations** — Backdrop blur + scale transitions on all modals and dropdowns

## License

MIT
