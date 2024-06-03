<?php

namespace App\Http\Controllers\pkg_projets;

use App\Exceptions\GestionProjets\TaskAlreadyExistException;
use App\Exceptions\pkg_projets\ProjectAlreadyExistException;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\pkg_projets\TaskRequest;
use App\Imports\pkg_projets\TaskImport;
use App\Exports\pkg_projets\TaskExport;
use App\Models\pkg_projets\Tache;
use App\Repositories\pkg_projets\ProjectRepository;
use App\Repositories\pkg_projets\TaskRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends AppBaseController
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $taches = $this->taskRepository->searchData($searchQuery);
                return view('pkg_projets.taches.index', compact('taches'))->render();
            }
        }
        $taches = $this->taskRepository->paginate();
        return view('pkg_projets.taches.index', compact('taches'));
    }

    public function create()
    {
        $dataToEdit = null;
        return view('pkg_projets.taches.create', compact('dataToEdit'));
    }

    public function store(TaskRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->taskRepository->create($validatedData);
            return redirect()->route('tasks.index')->with('success', 'Le task a été ajouté avec succès.');
        } catch (TaskAlreadyExistException $e) {
            return back()->withInput()->withErrors(['project_exists' => 'La tâche existe déjà']);
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function show(string $id)
    {
        $tache = $this->taskRepository->find($id);
        return view('pkg_projets.taches.show', compact('tache'));
    }

    public function edit(string $id)
    {
        $dataToEdit = $this->taskRepository->find($id);
        $dataToEdit->date_debut = Carbon::parse($dataToEdit->date_debut)->format('Y-m-d');
        $dataToEdit->date_de_fin = Carbon::parse($dataToEdit->date_de_fin)->format('Y-m-d');

        return view('pkg_projets.taches.edit', compact('dataToEdit'));
    }

    public function update(TaskRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $this->taskRepository->update($id, $validatedData);
        return redirect()->route('tasks.index', $id)->with('success', 'Le task a été modifier avec succès.');
    }

    public function destroy(string $id)
    {
        $this->taskRepository->destroy($id);
        $projectData = $this->taskRepository->paginate();
        return view('pkg_projets.taches.index', compact('projectData'))->with('succes', 'Le task a été supprimer avec succés.');
    }

    // 
    public function indexGantt(Request $request, ProjectRepository $projectRepository)
    {
        if ($request->ajax()) {
            $projectId = $request->get('project_id');
            // dd($projectId);
            if ($projectId) {
                $taches = $this->taskRepository->find($projectId);
            } else {
                $taches = $this->taskRepository->all();
            }
            $taches->load('Projet', 'StatutTache');
            return view('pkg_projets.taches.gantt-chart', compact('taches'))->render();
        }

        $taches = $this->taskRepository->all();
        $taches->load('Projet', 'StatutTache');
        $projects = $projectRepository->all();
        return view('pkg_projets.taches.index-gantt', compact(['taches', 'projects']));
    }





    public function export()
    {
        $tasks = $this->taskRepository::all();
        return Excel::download(new TaskExport($tasks), 'task_export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TaskImport, $request->file('file'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('tasks.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('tasks.index')->with('success', 'Task a ajouté avec succès');
    }
}
