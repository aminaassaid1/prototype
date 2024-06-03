<?php

namespace Database\Seeders\pkg_notifications;

use App\Models\pkg_rh\Personne;
use Illuminate\Database\Seeder;
use App\Models\GestionProjets\Projet;
use Illuminate\Support\Facades\Schema;
use App\Models\pkg_notifications\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        Notification::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_notifications/notifications.csv"), "r");
        $firstline = true;
        $i = 0;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                $isVue = filter_var($data['2'], FILTER_VALIDATE_BOOLEAN);

                Notification::create([
                    "titre" => $data['0'],
                    "message" => $data['1'],
                    "isVue" => $isVue,
                    "apprenant_id" => $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

        $csvFilePath = base_path("database/data/pkg_notifications/notificationPermissions.csv");
        $csvFile = fopen($csvFilePath, "r");

        $firstline = true;
        $FormateurRole = Role::where('name', User::FORMATEUR)->first();
        $ApprenantRole = Role::where('name', User::APPRENANT)->first();

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Permission::create([
                    "name" => $data['0'],
                    "guard_name" => 'web',
                ]);

                if ($FormateurRole) {
                    // If the role exists, update its permissions
                    $FormateurRole->givePermissionTo($data['0']);
                    if (in_array($data['0'], ['index-notificationController', 'show-notificationController', 'export-notificationController'] )) {
                        $ApprenantRole->givePermissionTo($data['0']);
                    }
                } else {
                    // If the role doesn't exist, create it and give permissions
                    Role::create([
                        'name' => User::FORMATEUR,
                        'guard_name' => 'web',
                    ])->givePermissionTo($data['0']);
                }

                
                if ($ApprenantRole) {
                    if (in_array($data['0'], ['index-notificationController', 'show-notificationController', 'export-notificationController'] )) {
                        $ApprenantRole->givePermissionTo($data['0']);
                    }
                } else {
                    // If the role doesn't exist, create it and give permissions
                    if (in_array($data['0'], ['index-notificationController', 'show-notificationController', 'export-notificationController'] )) {
                        Role::create([
                            'name' => User::APPRENANT,
                            'guard_name' => 'web',
                        ])->givePermissionTo($data['0']);
                    }
                }
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}