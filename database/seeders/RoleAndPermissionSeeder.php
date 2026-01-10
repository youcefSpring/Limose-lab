<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'users.index',
            'users.show',
            'users.create',
            'users.update',
            'users.delete',
            'users.approve',
            'users.suspend',
            'users.ban',

            // Material management
            'materials.index',
            'materials.show',
            'materials.create',
            'materials.update',
            'materials.delete',

            // Category management
            'categories.manage',

            // Reservation management
            'reservations.index',
            'reservations.create',
            'reservations.show',
            'reservations.update',
            'reservations.delete',
            'reservations.approve',
            'reservations.reject',
            'reservations.cancel',

            // Project management
            'projects.index',
            'projects.show',
            'projects.create',
            'projects.update',
            'projects.delete',
            'projects.manage-members',

            // Experiment management
            'experiments.index',
            'experiments.show',
            'experiments.create',
            'experiments.update',
            'experiments.delete',
            'experiments.comment',

            // Event management
            'events.index',
            'events.show',
            'events.create',
            'events.update',
            'events.delete',
            'events.rsvp',

            // Maintenance management
            'maintenance.index',
            'maintenance.show',
            'maintenance.create',
            'maintenance.update',
            'maintenance.complete',

            // Report management
            'reports.view',
            'reports.export',

            // Settings management
            'settings.index',
            'settings.update',

            // Publications management
            'publications.index',
            'publications.show',
            'publications.create',
            'publications.update',
            'publications.delete',
            'publications.approve',
            'publications.reject',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // Admin - Full access
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        // Material Manager - Material and reservation management
        $materialManager = Role::create(['name' => 'material_manager', 'guard_name' => 'web']);
        $materialManager->givePermissionTo([
            'users.show',
            'materials.index', 'materials.show', 'materials.create', 'materials.update', 'materials.delete',
            'categories.manage',
            'reservations.index', 'reservations.show', 'reservations.approve', 'reservations.reject',
            'maintenance.index', 'maintenance.show', 'maintenance.create',
            'reports.view', 'reports.export',
        ]);

        // Researcher - Project and experiment management
        $researcher = Role::create(['name' => 'researcher', 'guard_name' => 'web']);
        $researcher->givePermissionTo([
            'users.show',
            'materials.index', 'materials.show',
            'reservations.index', 'reservations.create', 'reservations.show', 'reservations.cancel',
            'projects.index', 'projects.show', 'projects.create', 'projects.update', 'projects.manage-members',
            'experiments.index', 'experiments.show', 'experiments.create', 'experiments.update', 'experiments.comment',
            'events.index', 'events.show', 'events.rsvp',
            'publications.index', 'publications.show', 'publications.create', 'publications.update', 'publications.delete',
            'reports.view',
        ]);

        // PhD Student - Limited project participation
        $phdStudent = Role::create(['name' => 'phd_student', 'guard_name' => 'web']);
        $phdStudent->givePermissionTo([
            'users.show',
            'materials.index', 'materials.show',
            'reservations.index', 'reservations.create', 'reservations.show', 'reservations.cancel',
            'projects.index', 'projects.show',
            'experiments.index', 'experiments.show', 'experiments.create', 'experiments.comment',
            'events.index', 'events.show', 'events.rsvp',
            'publications.index', 'publications.show', 'publications.create', 'publications.update', 'publications.delete',
        ]);

        // Partial Researcher - Read-only research access
        $partialResearcher = Role::create(['name' => 'partial_researcher', 'guard_name' => 'web']);
        $partialResearcher->givePermissionTo([
            'users.show',
            'materials.index', 'materials.show',
            'projects.index', 'projects.show',
            'experiments.index', 'experiments.show', 'experiments.comment',
            'events.index', 'events.show', 'events.rsvp',
            'publications.index', 'publications.show', 'publications.create', 'publications.update', 'publications.delete',
        ]);

        // Technician - Equipment and maintenance focus
        $technician = Role::create(['name' => 'technician', 'guard_name' => 'web']);
        $technician->givePermissionTo([
            'users.show',
            'materials.index', 'materials.show', 'materials.create', 'materials.update',
            'reservations.index', 'reservations.create', 'reservations.show', 'reservations.cancel',
            'maintenance.index', 'maintenance.show', 'maintenance.create', 'maintenance.update', 'maintenance.complete',
            'events.index', 'events.show', 'events.rsvp',
        ]);

        // Guest - Read-only public access
        $guest = Role::create(['name' => 'guest', 'guard_name' => 'web']);
        $guest->givePermissionTo([
            'materials.index', 'materials.show',
            'projects.index', 'projects.show',
            'events.index', 'events.show',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
