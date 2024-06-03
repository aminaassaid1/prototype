<?php

namespace Tests\Feature\pkg_projets;

use App\Exceptions\GestionProjets\TaskAlreadyExistException;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\pkg_projets\ProjetRepository;
use App\Models\pkg_projets\Projet;
use Tests\TestCase;
use App\Models\pkg_projets\Tache;
use App\Repositories\pkg_projets\TaskRepository;

/**
 * Classe de test pour tester les fonctionnalités du module de taches.
*/
class TacheTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Le référentiel de taches utilisé pour les tests.
     *
     * @var ProjetRepository
    */
    protected $taskRepository;

    /**
     * L'utilisateur utilisé pour les tests.
     *
     * @var User
    */
    protected $user;


    /**
     * Met en place les préconditions pour chaque test.
    */
    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = new TaskRepository(new Tache());
        $this->user = User::factory()->create();
    }

    /**
     * Teste la pagination des taches.
    */
    public function test_paginate()
    {
        $this->actingAs($this->user);
        $taskData = [
            'nom' => 'task create test',
            'description' => 'task create test',
            
        ];
        $task = $this->taskRepository->create($taskData);
        $tasks = $this->taskRepository->paginate();
        $this->assertNotNull($tasks);
    }


    /**
     * Teste la création d'un tache.
    */
    public function test_create()
    {
        $this->actingAs($this->user);
        $taskData = [
            'nom' => 'task create test',
            'description' => 'task create test',
            
        ];
        $task = $this->taskRepository->create($taskData);
        $this->assertEquals($taskData['nom'], $task->nom);
    }

    /**
     * Teste la création d'un tach déjà existant.
    */
    public function test_create_task_already_exist()
    {
        $this->actingAs($this->user);

        $task = Projet::factory()->create();
        $taskData = [
            'nom' => $task->nom,
            'description' => 'task create test',
           
        ];

        try {
            $task = $this->taskRepository->create($taskData);
            $this->fail('Expected taskException was not thrown');
        } catch (TaskAlreadyExistException $e) {
            $this->assertEquals(('La tâche existe déjà'), $e->getMessage());
        } catch (\Exception $e) {
            $this->fail('Unexpected exception was thrown: ' . $e->getMessage());
        }
    }

    /**
     * Teste la mise à jour d'un tach.
    */
    public function test_update()
    {
        $this->actingAs($this->user);
        $task = Projet::factory()->create();
        $taskData = [
            'nom' => 'task update test',
            'description' => 'task update test',
           
        ];
        $this->taskRepository->update($task->id, $taskData);
        $this->assertDatabaseHas('taches', $taskData);
    }

    /**
     * Teste la suppression d'un tach.
    */
    public function test_delete_task()
    {
        $this->actingAs($this->user);
        $task = Projet::factory()->create();
        $this->taskRepository->destroy($task->id);
        $this->assertDatabaseMissing('taches', ['id' => $task->id]);
    }

    /**
     * Teste la recherche de taches.
    */
    public function test_task_search()
    {
        $this->actingAs($this->user);
        $taskData = [
            'nom' => 'tests',
            'description' => 'search task test',
            
        ];
        $this->taskRepository->create($taskData);
        $searchValue = 'tests';
        $searchResults = $this->taskRepository->searchData($searchValue);
        $this->assertTrue($searchResults->contains('nom', $searchValue));
    }

}