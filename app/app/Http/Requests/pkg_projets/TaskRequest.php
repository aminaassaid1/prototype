<?php

namespace App\Http\Requests\pkg_projets;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorité' => 'required|integer',
            'dateDebut' => 'required|date',
            'dateEchéance' => 'required|date',
            'personne_id' => 'required|exists:personnes,id',
            'projets_id' => 'required|exists:projets,id',
            'status_tache_id' => 'required|exists:statut_taches,id',
        ];
    }
}
