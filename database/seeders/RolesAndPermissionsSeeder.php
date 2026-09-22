<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Modules managed by the admin panel, each granted view/create/update/delete permissions.
     *
     * @var list<string>
     */
    private array $modules = [
        'casinos',
        'reviews',
        'blog',
        'comparison-tables',
        'seo',
        'media',
        'contact-messages',
        'settings',
        'users',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];

        foreach ($this->modules as $module) {
            foreach (['view', 'create', 'update', 'delete'] as $ability) {
                $permissions[] = "{$ability} {$module}";
            }
        }

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdmin = Role::findOrCreate('Super Admin');
        $superAdmin->syncPermissions($permissions);

        $admin = Role::findOrCreate('Admin');
        $admin->syncPermissions(
            collect($permissions)->reject(fn (string $permission) => str_ends_with($permission, 'users'))->all()
        );

        $editor = Role::findOrCreate('Editor');
        $editor->syncPermissions(
            collect($permissions)
                ->filter(fn (string $permission) => ! str_ends_with($permission, 'settings') && ! str_ends_with($permission, 'users'))
                ->reject(fn (string $permission) => str_starts_with($permission, 'delete'))
                ->all()
        );

        $support = Role::findOrCreate('Support');
        $support->syncPermissions([
            'view contact-messages',
            'update contact-messages',
            'delete contact-messages',
        ]);
    }
}
