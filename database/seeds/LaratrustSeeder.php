<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class LaratrustSeeder extends Seeder
{
    private function getDomain()
    {
        return parse_url(env('APP_URL'), PHP_URL_HOST);
    }

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        try {

            $this->command->info('Inicia el proceso para crear el usuario/roles/permisos para superadministrador a la DB.');

            if ($this->command->confirm('Do you want to confirm to create the super administrator user and their roles / permissions to the database? [yes|no]')) {
                if (env('RUN_SUPER_ADMIN')) {
                    $this->truncateLaratrustTables();

                    $config = config('laratrust_seeder.roles_structure');
                    $mapPermission = collect(config('laratrust_seeder.permissions_map'));

                    foreach ($config as $key => $modules) {

                        // Create a new role
                        $role = \App\Models\Admin\Role::firstOrCreate([
                            'name' => $key,
                            'display_name' => ucwords(str_replace('-', ' ', $key)),
                            'description' => ucwords(str_replace('-', ' ', $key))
                        ]);
                        $permissions = [];

                        $this->command->info('Creating Role ' . strtoupper($key));

                        // Reading role permission modules
                        foreach ($modules as $module => $value) {

                            foreach (explode(',', $value) as $p => $perm) {

                                $permissionValue = $mapPermission->get($perm);

                                $permissions[] = \App\Models\Admin\Permission::firstOrCreate([
                                    'name' => $permissionValue  . '-' . $module,
                                    'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                                    'description' => ucfirst($permissionValue) . ' ' . ucfirst($module)
                                ])->id;
                                $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                            }
                        }

                        // Attach all permissions to the role
                        $role->permissions()->sync($permissions);

                        if (Config::get('laratrust_seeder.create_users')) {
                            $this->command->info("Creating '{$key}' user");
                            // Create default user for each role
                            $user = \App\User::create([
                                'name' => ucwords(str_replace('-', ' ', $key)),
                                'email' => $key . '@' . $this->getDomain(),
                                'password' => '_' . $key,
                                'email_verified_at' => Carbon::now()
                            ]);
                            $user->attachRole($role);
                        }
                    }
                } else {
                    $this->command->info('Termina el proceso para crear el usuario/roles/permisos para superadministrador a la DB.');
                }
            } else {
                $this->command->info('RUN_SUPER_ADMIN: No esta habilitado para crear el usuario/roles/permisos para superadministrador a la DB.');
            }
        } catch (\Throwable $th) {
            $this->command->error('Something is really going wrong. ' . $th->getMessage());
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        if (Config::get('laratrust_seeder.truncate_tables')) {
            \App\Models\Admin\Role::truncate();
            \App\Models\Admin\Permission::truncate();
        }
        if (Config::get('laratrust_seeder.truncate_tables') && Config::get('laratrust_seeder.create_users')) {
            \App\User::truncate();
        }
        Schema::enableForeignKeyConstraints();
    }
}
