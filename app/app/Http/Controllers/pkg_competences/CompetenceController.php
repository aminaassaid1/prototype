<?php

namespace App\Http\Controllers\pkg_competences;

use App\Exceptions\pkg_competences\CompetenceAlreadyExistException;
use App\Http\Controllers\Controller;
use App\Imports\pkg_competences\CompetenceImport;
use App\Models\pkg_competences\Competence;
use Illuminate\Http\Request;
use App\Http\Requests\pkg_competences\CompetenceRequest;
use App\Repositories\pkg_competences\CompetenceRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use App\Exports\pkg_competences\CompetenceExport;
use Maatwebsite\Excel\Facades\Excel;

class CompetenceController extends AppBaseController
{
    protected $competenceRepository;

    public function __construct(CompetenceRepository $competenceRepository)
    {
        $this->competenceRepository = $competenceRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $competenceData = $this->competenceRepository->searchData($searchQuery);
                return view('pkg_competences.competence.index', compact('competenceData'))->render();
            }
        }
        $competenceData = $this->competenceRepository->paginate();
        return view('pkg_competences.competence.index', compact('competenceData'));
    }

    public function create()
    {
        $dataToEdit = null;
        return view('pkg_competences.competence.create', compact('dataToEdit'));
    }

    public function store(CompetenceRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->competenceRepository->create($validatedData);
            return redirect()->route('competence.index')->with('success', __('pkg_competences/competence.singular') . ' ' . __('pkg_competences/competence.competence_added_success'));
        } catch (CompetenceAlreadyExistException $e) {
            return back()->withInput()->withErrors(['competence_exists' => __('pkg_competences/competence.createProjectException')]);
        }



    }

    public function show(string $id)
    {

        $fetchedData = $this->competenceRepository->find($id);
        return view('pkg_competences.competence.show', compact('fetchedData'));
    }

    public function edit(string $id)
    {
        $dataToEdit = $this->competenceRepository->find($id);

        return view('pkg_competences.competence.edit', compact('dataToEdit'));
    }

    public function update(CompetenceRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $this->competenceRepository->update($id, $validatedData);
        return redirect()->route('competence.index')->with('success', __('pkg_competences/competence.singular') . ' ' . __('pkg_competences/competence.competence_updated_success'));
    }

    public function destroy(string $id)
    {
        $this->competenceRepository->destroy($id);
        return redirect()->route('competence.index')->with('success', 'Le competence a été supprimé avec succès.');
    }

    public function export()
    {
        $competences = Competence::all();
        return Excel::download(new CompetenceExport($competences), 'competence_export.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new CompetenceImport, $request->file('file'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('competences.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('competences.index')->with('success', __('pkg_competences/competence.singular') . ' ' . __('app.addSuccess'));
    }
}
