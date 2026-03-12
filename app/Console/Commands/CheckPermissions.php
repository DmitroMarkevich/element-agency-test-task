<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CheckPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates admin permissions and assigns them to SuperAdmin';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $adminPermissions = config('admin-permissions');
        $mainRole = Role::findOrCreate('SuperAdmin', 'web');

        foreach ($adminPermissions as $permissions) {
            foreach ($permissions as $permission => $config) {
                Permission::updateOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }
            $mainRole->givePermissionTo(array_keys($permissions));
        }

        $this->info('Permissions updated successfully.');
    }
}
