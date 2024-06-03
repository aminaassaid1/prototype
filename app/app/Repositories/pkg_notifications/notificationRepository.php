<?php
namespace App\Repositories\pkg_notifications;

use App\Exceptions\pkg_notifications\notificationException;
use App\Models\pkg_notifications\notification;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class notificationRepository extends BaseRepository
{
        /**
     * Les champs de recherche disponibles pour les projets.
     *
     * @var array
     */
    protected $fieldsSearchable = [
        'titre',
        'description'
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
     * Constructeur de la classe ProjetRepository.
     */
    public function __construct()
    {
        parent::__construct(new notification());
    }

    public function create(array $data)
    {
        // $nom = $data['nom'];

        // $notificationExist =  $this->model->where('nom', $nom)->exists();

        // if ($notificationExist) {
        //     throw notificationException::AlreadyExistNotification();
        // } else {
        // }
        return parent::create($data);
    }

    public function update($id, array $data)
    {
        // $nom = $data['nom'];

        // $notificationExist =  $this->model->where('nom', $nom)->where('id', '!=', $id)->exists();

        // if ($notificationExist) {
        //     throw notificationException::AlreadyExistNotification();
        // } else {
        // }
        return parent::update($id, $data);
    }

    public function SetasSeen($id){
        return parent::update($id, ['isVue' => true]);
    }


    public function destroy($id)
    {
        // $notificationExist =  $this->model->find($id);
        return parent::destroy($id);

        // if (!$notificationExist) {
        //     throw notificationException::NotExistNotification();
        // } else {
        // }
    }

        /**
     * Recherche les projets correspondants aux critères spécifiés.
     *
     * @param mixed $searchableData Données de recherche.
     * @param int $perPage Nombre d'éléments par page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    
    public function searchData($searchableData, $perPage = 4)
    {
        return $this->model->where(function ($query) use ($searchableData) {
            $query->where('titre', 'like', '%' . $searchableData . '%')
                ->orWhere('message', 'like', '%' . $searchableData . '%');
        })->paginate($perPage);
    }
}
