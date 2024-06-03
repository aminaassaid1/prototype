<?php

namespace Database\Seeders\pkg_projets;

use App\Models\pkg_projets\Tache;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Tache::truncate();
        Schema::enableForeignKeyConstraints();

        $csvFile = fopen(base_path("database/data/pkg_projets/taches.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if ($firstline) {
                $firstline = false;
                continue;
            }

            // Ensure that the row has at least 8 elements
            if (count($data) >= 8) {
                Tache::create([
                    "nom" => $data[0],
                    "description" => $data[1],
                    "priorité" => $data[2],
                    "dateDebut" => $this->formatDate($data[3]),
                    "dateEchéance" => $this->formatDate($data[4]),
                    "personne_id" => $data[5],
                    "projets_id" => $data[6],
                    "status_tache_id" => $data[7],
                ]);
            } else {
                \Log::warning("Incomplete data row: " . implode(",", $data));
            }
        }

        fclose($csvFile);
    }

    private function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
