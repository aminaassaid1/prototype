<?php

namespace App\Repositories\pkg_projets;

use App\Exceptions\GestionProjets\TaskAlreadyExistException;
use App\Repositories\BaseRepository;
use App\Models\pkg_projets\Tache;

/**
 * Classe TaskRepository qui gère la persistance des tasks dans la base de données.
 */
class TaskRepository extends BaseRepository
{
    /**
     * Les champs de recherche disponibles pour les tasks.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'nom'
    ];

    /**
     * Renvoie les champs de recherche disponibles.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldsSearchable;
    }

    /**
     * Constructeur de la classe TaskRepository.
     */
    public function __construct()
    {
        parent::__construct(new Tache());
    }

    /**
     * Crée un nouveau task.
     *
     * @param array $data Données du task à créer.
     * @return mixed
     * @throws TaskAlreadyExistException Si le task existe déjà.
     */
    public function create(array $data)
    {
        $nom = $data['nom'];

        $existingProject =  $this->model->where('nom', $nom)->exists();

        if ($existingProject) {
            throw TaskAlreadyExistException::createTask();
        } else {
            return parent::create($data);
        }
    }


    public function find($project_id, $column = []) {
        return $this->model->where('projets_id', $project_id)->get();
    }

    /**
     * Recherche les tasks correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchData($searchableData, $perPage = 4)
    {
        return $this->model->where(function ($query) use ($searchableData) {
            $query->where('nom', 'like', '%' . $searchableData . '%')
                ->orWhere('description', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }
}
