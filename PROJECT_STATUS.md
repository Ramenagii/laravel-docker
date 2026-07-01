# TaskFlow — Project Status

## Repository
- **GitHub:** `https://github.com/Ramenagii/laravel-docker`
- **Local:** `~/laravel-docker` (WSL)
- **Stack:** Laravel 12, Livewire 3, Alpine.js, Tailwind CSS, MySQL 8, Docker

## Task Done

### Backend
- Laravel 12 scaffold with Docker Compose (nginx + php-fpm 8.2 + mysql 8.0 + phpMyAdmin)
- Custom PHP Dockerfile with pdo_mysql, mbstring, xml, curl, zip extensions
- Nginx config routing all requests to php-fpm:9000
- Models: Project, Task, Comment, Tag with relationships, foreign keys, and enum casts
- Migrations: 12 tables (users, projects, tasks, comments, tags, task_tag, permissions, roles, activity_log, etc.)
- String-backed Enums: ProjectStatus (active/completed/archived), TaskStatus (todo/in_progress/review/done/cancelled), TaskPriority (low/medium/high/urgent)
- Spatie Laravel Permission: 3 roles (admin/manager/member) with 14 granular permissions
- Spatie Laravel Activitylog: full audit trail on Project, Task, Comment models
- Seeder: 3 demo users, 2 projects, 10 tasks, 4 tags, 3 comments

### Frontend
- Laravel Breeze auth (Livewire Volt stack) — login, register, password reset
- 6 Livewire full-page components: Dashboard, Projects Index, Projects Show (Kanban), Tasks Show, Activity Index, Users Index
- Dark sidebar layout with responsive mobile menu
- Kanban board with 4 columns (To Do, In Progress, Review, Done) with colored column headers
- Alpine.js animations: counter effects, staggered card entries, page transitions, backdrop blur modals
- Button loading states with spinners on ALL actions (create task, save comment, delete, role save, logout, filters)
- `wire:navigate` for SPA-like navigation

### CI/CD
- GitHub Actions workflow: PHP syntax check, composer install, migrate

## Ongoing
- Nothing — app is fully functional

## Challenges / Blockers

### Resolved

| Challenge | Resolution |
|-----------|-----------|
| `bootstrap/cache` missing in CI | Added `mkdir -p bootstrap/cache` step and `.gitkeep` file + fixed `.gitignore` to not ignore the directory |
| `composer install` post-autoload-dump failed without `.env` | Added `cp .env.example .env` step before `composer install` in CI |
| Enum comparison in Blade (`$project->status === 'active'` failed) | Changed to `$project->status->value === 'active'` |
| Users had no roles assigned | Fixed RoleSeeder to assign admin/manager/member roles by email instead of only first user getting admin |
| Git author was `Developer <developer@example.com>` | Rewrote commits with correct git config (`Ramenagii <ramenroxaslorenzo15@gmail.com>`) |
| Port not accessible from Windows browser | Docker in WSL forwards to localhost automatically — just need to use Windows browser |
| `php artisan package:discover` needed writable cache dir | Added directory creation step in CI workflow |
