<?php

namespace App\Imports\pkg_notifications;

use App\Models\pkg_notifications\notification;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use App\Models\pkg_competences\Technologie;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class notificationImport implements ToModel, WithHeadingRow
{
    // Implement the model() method to import notifications
    public function model(array $row)
    {

        // notification doesn't exist, proceed with importing it
        return new notification([
            'nom' => $row["nom"],
            'description' => $row["description"],
        ]);
    }

}