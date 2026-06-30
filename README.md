# Gym Tracker Web

Aplikasi pelacak latihan gym berbasis web menggunakan Laravel 13, Filament 4, dan PostgreSQL.

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.3+)
- **Admin Panel**: Filament 4
- **Database**: PostgreSQL
- **Authentication**: Laravel default auth (manual login)
- **AI Assistance**: Laravel Boost

## Requirements

- PHP 8.3+
- Composer
- PostgreSQL
- Node.js 18+ (for Vite)

## Installation

```bash
# Clone repository
git clone https://github.com/arief14016/gym-tracker-web.git
cd gym-tracker-web

# Install dependencies
composer install

# Copy environment file
cp .env.example .env
# Edit .env with your database credentials

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Start development server
php artisan serve
```

## Panel URLs

| Panel | URL | Access |
|-------|-----|--------|
| Admin | `/cp-x7k9m2` | admin, trainer |
| Member App | `/app` | member |

> ⚠️ **Security**: Admin panel path (`cp-x7k9m2`) adalah custom path yang tidak standar. Ubah `FILAMENT_ADMIN_PATH` di `.env` sesuai kebutuhan.

## Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gymtracker.com | password |
| Trainer | john.trainer@gymtracker.com | password |
| Trainer | sarah.trainer@gymtracker.com | password |
| Member | mike.member@gymtracker.com | password |

## User Roles

- **Admin**: Akses penuh ke semua fitur admin panel
- **Trainer**: Dapat mengelola member yang ter-assign dan workout plans
- **Member**: Akses ke app panel untuk logging workout dan tracking progress

## Features

### Admin Panel (`/cp-x7k9m2`)

- **UserManagement** (Admin only): CRUD user, edit role, assign trainer ke member
- **User**: View member yang ter-assign (trainer) atau semua member (admin)
- **Exercise**: Library exercise dengan kategori muscle group
- **WorkoutPlan**: Buat dan assign workout plan ke member

### Member App (`/app`)

- **Dashboard**: Stats, PR terbaru, grafik progress
- **Body Metrics**: Track berat, tinggi, body fat percentage, foto progress
- **Workout Plans**: Lihat plan dari trainer atau buat sendiri
- **Workout Sessions**: Log sesi latihan dengan set/reps/weight

## Database Schema

```
users
├── role (admin, trainer, member)
└── trainer_member (pivot)

exercises
├── name, muscle_group, description
├── video_url, image
└── workout_plan_exercises

workout_plans
├── user_id (pemilik), created_by
├── name, description, is_active
└── workout_plan_days

workout_plan_days
├── workout_plan_id, day_order, name
└── workout_plan_exercises

workout_plan_exercises
├── workout_plan_day_id, exercise_id
├── target_sets, target_reps, target_weight
└── sort_order

workout_sessions
├── user_id, workout_plan_day_id (nullable)
├── date, duration, notes
└── workout_set_logs

workout_set_logs
├── workout_session_id, exercise_id
├── set_number, reps, weight, rpe
└── personal_records (auto-detect)

body_metrics
├── user_id, recorded_by
├── date, weight, height, body_fat_percentage
└── progress_photo

personal_records
├── user_id, exercise_id
├── weight, reps, achieved_at
└── (auto-generated dari workout_set_logs)
```

## Auto Personal Record Detection

Personal record dideteksi otomatis saat workout set baru di-log. Menggunakan formula `weight × reps` sebagai strength score untuk menentukan PR.

## Development

```bash
# Run all tests
php artisan test

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Publish Filament assets
php artisan filament:assets
```

## Security Features

- Custom admin panel path (bukan `/admin`)
- Role-based panel access via `canAccessPanel()` di User model
- Trainer hanya bisa lihat/kelola member yang ter-assign
- Member hanya bisa akses data sendiri

## License

MIT License
