<?php

namespace App\Http\Controllers\pkg_autorisations;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\pkg_autorisations\UtilisateurRequest;
use App\Repositories\pkg_autorisations\UtilisateureRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use App\Exports\pkg_autorisations\UtilisateurExport;
use Maatwebsite\Excel\Facades\Excel;

class utilisateursController extends AppBaseController
{
    protected $UtilisateureRepository;

    public function __construct(UtilisateureRepository $UtilisateureRepository)
    {
        $this->UtilisateureRepository = $UtilisateureRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $utilisateurData = $this->UtilisateureRepository->searchData($searchQuery);
                return view('pkg_autorisations.utilisateur.index', compact('utilisateureData'))->render();
            }
        }
        $utilisateurData = $this->UtilisateureRepository->paginate();
        return view('pkg_autorisations.utilisateur.index', compact('utilisateurData'));
    }

    public function show(string $id)
    {

        $fetchedData = $this->UtilisateureRepository->find($id);
        return view('pkg_autorisations.utilisateur.show', compact('fetchedData'));
    }

    public function export()
    {
        $utilisateurs = User::all();
        return Excel::download(new UtilisateurExport($utilisateurs), 'utilisateur_export.xlsx');
    }
}
