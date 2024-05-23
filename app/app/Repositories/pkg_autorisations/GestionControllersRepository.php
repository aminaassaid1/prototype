<?php

namespace App\Repositories\pkg_autorisations;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Route;
use App\Exceptions\pkg_autorisations\ControllerNotExistException;
use App\Models\pkg_autorisations\Controller as AutorisationController;
use App\Exceptions\pkg_autorisations\ControllerAlreadyExistException;

class GestionControllersRepository extends BaseRepository {
    protected $model;

    public function __construct(AutorisationController $Controller){
        $this->model = $Controller;
    }
    public function getModel() {
        return $this->model;
    }

    public function create(array $data) {
        $nom = $data['nom'];

        if (!in_array($nom, $this->extractControllerNames())) {
            throw new ControllerNotExistException(__('Autorisation/controllers/message.controllerExistPas'));
        }

        $existingController = $this->model->where('nom', $nom)->first();
        if ($existingController) {
            throw new ControllerAlreadyExistException(__('Autorisation/controllers/message.nomControllerExistDeja'));
        }

        return parent::create($data);
    }

    
    public static function extractControllerNames(): array
    {
        $extractControllerNames = [];
        // Loop through all routes
        foreach (Route::getRoutes() as $route) {
            $action = $route->getAction();
            // Check if the route has a controller key in its action
            if (array_key_exists('controller', $action)) {
                $fullControllerName = $action['controller'];
                // Check if the controller is in the correct namespace and does not belong to Auth namespace
                if (
                    strpos($fullControllerName, 'App\Http\Controllers\\') === 0 &&
                    strpos($fullControllerName, 'App\Http\Controllers\Auth\\') !== 0
                ) {
                    // Extract the controller class name without the namespace and method
                    $controllerNameWithNamespace = str_replace('App\Http\Controllers\\', '', $fullControllerName);
                    $controllerNameParts = explode('\\', $controllerNameWithNamespace);
                    $controllerClassName = end($controllerNameParts); // Get the last part (controller class name)
                    $controllerClassNameWithoutMethod = strtok($controllerClassName, '@');
                    $extractControllerNames[] = $controllerClassNameWithoutMethod;
                }
            }
        }
        // Remove duplicate controller names
        $uniqueControllerNames = array_unique($extractControllerNames);
        return $uniqueControllerNames;
    }
}