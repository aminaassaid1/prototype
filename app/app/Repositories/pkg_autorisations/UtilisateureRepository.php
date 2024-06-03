<?php

namespace App\Repositories\pkg_autorisations;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
/**
 * Class utilisateurnRepository that manages the persistence of utilisateurs in the database.
 */
class UtilisateureRepository extends BaseRepository
{
    /**
     * Searchable fields for utilisateurs.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'name'
    ];

    /**
     * Get searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldsSearchable;
    }

    /**
     * UtilisateurRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new User());
    }


    /**
     * Search utilisateurs based on specified criteria.
     *
     * @param mixed $searchableData Search data.
     * @param int $perPage Items per page.
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
