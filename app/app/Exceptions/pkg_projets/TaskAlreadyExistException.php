<?php

namespace App\Exceptions\GestionProjets;

use App\Exceptions\BusinessException;

class TaskAlreadyExistException extends BusinessException
{
    public static function createTask()
    {
        return new self(__('La tâche existe déjà'));
    }
}