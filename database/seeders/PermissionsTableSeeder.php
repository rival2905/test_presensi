<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard
        Permission::create(['name' => 'dashboard.index']);

        // Categories
        Permission::create(['name' => 'categories.index']);
        Permission::create(['name' => 'categories.create']);
        Permission::create(['name' => 'categories.edit']);
        Permission::create(['name' => 'categories.delete']);

        // Photos
        Permission::create(['name' => 'photos.index']);
        Permission::create(['name' => 'photos.create']);
        Permission::create(['name' => 'photos.edit']);
        Permission::create(['name' => 'photos.delete']);

        // Videos
        Permission::create(['name' => 'videos.index']);
        Permission::create(['name' => 'videos.create']);
        Permission::create(['name' => 'videos.edit']);
        Permission::create(['name' => 'videos.delete']);

        // Organizations
        Permission::create(['name' => 'organizations.index']);
        Permission::create(['name' => 'organizations.create']);
        Permission::create(['name' => 'organizations.edit']);
        Permission::create(['name' => 'organizations.delete']);

        // Groups
        Permission::create(['name' => 'groups.index']);
        Permission::create(['name' => 'groups.create']);
        Permission::create(['name' => 'groups.edit']);
        Permission::create(['name' => 'groups.delete']);

        // Affiliations
        Permission::create(['name' => 'affiliations.index']);
        Permission::create(['name' => 'affiliations.create']);
        Permission::create(['name' => 'affiliations.edit']);
        Permission::create(['name' => 'affiliations.delete']);

        // Activities
        Permission::create(['name' => 'activities.index']);
        Permission::create(['name' => 'activities.create']);
        Permission::create(['name' => 'activities.edit']);
        Permission::create(['name' => 'activities.delete']);

        // Attendances
        Permission::create(['name' => 'attendances.index']);
        Permission::create(['name' => 'attendances.create']);
        Permission::create(['name' => 'attendances.edit']);
        Permission::create(['name' => 'attendances.delete']);

        // Events
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);

        // Schedules
        Permission::create(['name' => 'schedules.index']);
        Permission::create(['name' => 'schedules.create']);
        Permission::create(['name' => 'schedules.edit']);
        Permission::create(['name' => 'schedules.delete']);

        // Registrations
        Permission::create(['name' => 'registrations.index']);
        Permission::create(['name' => 'registrations.create']);
        Permission::create(['name' => 'registrations.edit']);
        Permission::create(['name' => 'registrations.delete']);

        // Payments
        Permission::create(['name' => 'payments.index']);
        Permission::create(['name' => 'payments.create']);
        Permission::create(['name' => 'payments.edit']);
        Permission::create(['name' => 'payments.delete']);

        // Roles
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        // Permissions
        Permission::create(['name' => 'permissions.index']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.edit']);
        Permission::create(['name' => 'permissions.delete']);

        // Users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
    }
}
