<?php

namespace Database\Seeders\pkg_competences;

use App\Models\pkg_competences\CategorieTechnologie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CategorieTechnologiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CategorieTechnologie::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_competences/CategorieTechnologie.csv"), "r");
        $firstline = true;
        $i = 0;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                CategorieTechnologie::create([
                    "nom" => $data['0'],
                    "description" => $data['1'],
                ]);
            }
            $firstline = false;
        }

        $FormateurRole = Role::where('name', User::FORMATEUR)->first();
        $ApprenantRole = Role::where('name', User::APPRENANT)->first();

        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_competences/CategorieTechnologiePermissions.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                Permission::create([
                    "name" => $data['0'],
                    "guard_name" => $data['1'],
                ]);

                if ($FormateurRole) {
                    // If the role exists, update its permissions
                    $FormateurRole->givePermissionTo($data['0']);
                } else {
                    // If the role doesn't exist, create it and give permissions
                    Role::create([
                        'name' => User::FORMATEUR,
                        'guard_name' => 'web',
                    ])->givePermissionTo($data['0']);
                }

                
                if ($ApprenantRole) {
                    // If the role exists, update its permissions
                    if (in_array($data['0'], ['index-CategorieTechnologieController', 'show-CategorieTechnologieController', 'export-CategorieTechnologieController','import-CategorieTechnologieController'] )) {
                        $ApprenantRole->givePermissionTo($data['0']);
                    }
                } else {
                    // If the role doesn't exist, create it and give permissions
                    Role::create([
                        'name' => User::APPRENANT,
                        'guard_name' => 'web',
                    ])->givePermissionTo($data['0']);
                }
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}

