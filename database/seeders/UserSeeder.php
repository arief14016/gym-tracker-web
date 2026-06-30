<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        // Create Trainers
        $trainer1 = User::create([
            'name' => 'John Trainer',
            'email' => 'john.trainer@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Trainer,
            'email_verified_at' => now(),
        ]);

        $trainer2 = User::create([
            'name' => 'Sarah Trainer',
            'email' => 'sarah.trainer@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Trainer,
            'email_verified_at' => now(),
        ]);

        // Create Members
        $member1 = User::create([
            'name' => 'Mike Member',
            'email' => 'mike.member@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member2 = User::create([
            'name' => 'Emma Member',
            'email' => 'emma.member@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member3 = User::create([
            'name' => 'David Member',
            'email' => 'david.member@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        $member4 = User::create([
            'name' => 'Lisa Member',
            'email' => 'lisa.member@gymtracker.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Member,
            'email_verified_at' => now(),
        ]);

        // Assign members to trainers
        // Trainer 1 (John) manages: Mike, Emma
        $trainer1->assignedMembers()->attach([$member1->id, $member2->id]);

        // Trainer 2 (Sarah) manages: David, Lisa
        $trainer2->assignedMembers()->attach([$member3->id, $member4->id]);
    }
}
