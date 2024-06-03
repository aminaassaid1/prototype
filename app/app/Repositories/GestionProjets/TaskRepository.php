<?php
namespace App\Repositories\GestionProjets;

use App\Models\GestionProjets\Task;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\GestionTasks\ProjectAlreadyExistException;

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
        'name'
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
        parent::__construct(new Task());
    }

    /**
     * Crée un nouveau task.
     *
     * @param array $data Données du task à créer.
     * @return mixed
     * @throws ProjectAlreadyExistException Si le task existe déjà.
     */
    public function create(array $data)
    {
        $nom = $data['nom'];

        $existingProject =  $this->model->where('nom', $nom)->exists();

        if ($existingProject) {
            throw ProjectAlreadyExistException::createProject();
        } else {
            return parent::create($data);
        }
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
