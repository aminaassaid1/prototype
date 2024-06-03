<?php

namespace Database\Seeders\pkg_rh;

use App\Models\pkg_rh\Personne;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PersonneSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = User::ADMIN;

        Schema::disableForeignKeyConstraints();
        Personne::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFilePath = base_path("database/data/pkg_rh/Personnes.csv");
        $csvFile = fopen($csvFilePath, "r");

        if (!$csvFile) {
            throw new \Exception("Failed to open CSV file: $csvFilePath");
        }

        $firstLine = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            if ($firstLine) {
                $firstLine = false;
                continue; // Skip the header row
            }

            // Validate data
            if (count($data) < 4) {
                continue; 
            }


            // Map CSV data to database fields
            $user_id = $data[2] == 'apprenant' ? 1 : 2;
            $personneData = [
                "nom" => $data[0],
                "prenom" => $data[1],
                "type" => $data[2],
                "groupe_id" => $data[3],
                'user_id' => $user_id
            ];

            // Check if Personne already exists
            $existingPersonne = Personne::where($personneData)->first();
            if (!$existingPersonne) {
                // Create new Personne if not exists
                Personne::create($personneData);
            }
        }

        fclose($csvFile);

        // Seed permissions
        $permissions = $this->readPermissionsFromCSV();
        foreach ($permissions as $permissionName) {
            $existingPermission = Permission::where('name', $permissionName)->first();
            if (!$existingPermission) {
                Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }

        $admin = Role::where('name', $adminRole)->first();
        if ($admin) {
            $admin->givePermissionTo($permissions);
        }
    }

    private function readPermissionsFromCSV(): array
    {
        $permissionsArray = [];

        $csvFilePath = base_path("database/data/pkg_rh/Permissions.csv");
        $csvFilePermissions = fopen($csvFilePath, "r");

        if (!$csvFilePermissions) {
            throw new \Exception("Failed to open CSV file: $csvFilePath");
        }

        fgetcsv($csvFilePermissions); // Skip the header row

        while (($data = fgetcsv($csvFilePermissions)) !== false) {
            $permissionsArray[] = $data[0];
        }

        fclose($csvFilePermissions);

        return $permissionsArray;
    }
}