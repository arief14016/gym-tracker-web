<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    // ===== Trainer-Member Relations =====

    public function assignedMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_member', 'trainer_id', 'member_id')
            ->withTimestamps();
    }

    public function assignedTrainers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_member', 'member_id', 'trainer_id')
            ->withTimestamps();
    }

    // ===== Workout Plans =====

    public function workoutPlans(): HasMany
    {
        return $this->hasMany(WorkoutPlan::class);
    }

    public function createdWorkoutPlans(): HasMany
    {
        return $this->hasMany(WorkoutPlan::class, 'created_by');
    }

    // ===== Workout Sessions =====

    public function workoutSessions(): HasMany
    {
        return $this->hasMany(WorkoutSession::class);
    }

    // ===== Body Metrics =====

    public function bodyMetrics(): HasMany
    {
        return $this->hasMany(BodyMetric::class);
    }

    public function recordedBodyMetrics(): HasMany
    {
        return $this->hasMany(BodyMetric::class, 'recorded_by');
    }

    // ===== Personal Records =====

    public function personalRecords(): HasMany
    {
        return $this->hasMany(PersonalRecord::class);
    }

    // ===== Role Helpers =====

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isTrainer(): bool
    {
        return $this->role === UserRole::Trainer;
    }

    public function isMember(): bool
    {
        return $this->role === UserRole::Member;
    }

    public function isTrainerOf(User $user): bool
    {
        return $this->assignedMembers()->where('member_id', $user->id)->exists();
    }

    // ===== Filament Panel Access =====

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => in_array($this->role, [UserRole::Admin, UserRole::Trainer]),
            'app' => $this->role === UserRole::Member,
            default => false,
        };
    }
}
