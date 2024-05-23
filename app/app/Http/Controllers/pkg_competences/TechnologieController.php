<?php

namespace App\Http\Controllers\Pkg_competences;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AppBaseController;
use App\Models\pkg_competences\Technologie;
use App\Exports\pkg_competences\TechnologieExport;
use App\Imports\pkg_competences\TechnologieImport;
use App\Http\Requests\pkg_competences\TechnologieRequest;
use App\Repositories\Pkg_competences\TechnologieRepository;
use App\Exceptions\pkg_competences\TechnologieAlreadyExistException;

// class TechnologieController extends AppBaseController
class TechnologieController extends Controller
{
    protected $TechnologieRepository;
    public function __construct(TechnologieRepository $technologieRepository)
    {
        $this->TechnologieRepository = $technologieRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $technologieData = $this->TechnologieRepository->searchData($searchQuery);
                return view('Pkg_competences.Technologie.index', compact('technologieData'))->render();
            }
        }
        $technologieData = $this->TechnologieRepository->paginate();
        return view('Pkg_competences.Technologie.index', compact('technologieData'));
    }


    public function create()
    {
        $dataToEdit = null;
        return view('Pkg_competences.Technologie.create', compact('dataToEdit'));
    }


    public function store(TechnologieRequest $request)
    {

        try {
            $validatedData = $request->validated();
            // dd($validatedData);
            $this->TechnologieRepository->create($validatedData);
            return redirect()->route('Pkg_competences.Technologie.index')->with('success', __('Pkg_competences.Technologie.singular') . ' ' . __('app.addSucées'));

        } catch (TechnologieAlreadyExistException $e) {
            return back()->withInput()->withErrors(['technologie_exists' => __('Pkg_competences.Technologie/message.createProjectException')]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }


    public function show(string $id)
    {
        $fetchedData = $this->TechnologieRepository->find($id);
        return view('Pkg_competences.Technologie.show', compact('fetchedData'));
    }


    public function edit(string $id)
    {
        $dataToEdit = $this->TechnologieRepository->find($id);
        return view('Pkg_competences.Technologie.edit', compact('dataToEdit'));
    }


    public function update(TechnologieRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $this->TechnologieRepository->update($id, $validatedData);
        return redirect()->route('Pkg_competences.Technologie.index', $id)->with('success', __('Pkg_competences.Technologie.technologie.singular') . ' ' . __('app.updateSucées'));
    }


    public function destroy(string $id)
    {
        $this->TechnologieRepository->destroy($id);
        return redirect()->route('Pkg_competences.Technologie.index')->with('success', __('Pkg_competences.Technologie.technologie.singular') . ' ' . __('app.deleteSucées'));
    }


    public function export()
    {
        $projects = Technologie::all();

        return Excel::download(new TechnologieExport($projects), 'technologie_export.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TechnologieImport, $request->file('file'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('projets.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('projets.index')->with('success', __('Pkg_competences.Technologie.singular') . ' ' . __('app.addSucées'));
    }
}