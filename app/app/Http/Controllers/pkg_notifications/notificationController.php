<?php

namespace App\Http\Controllers\pkg_notifications;

use App\Exceptions\pkg_notifications\notificationException;
use App\Exports\pkg_notifications\notificationExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\pkg_notifications\notificationRequest;
use App\Imports\pkg_notifications\notificationImport;
use App\Models\pkg_notifications\notification as pkg_notificationsnotification;
use App\Repositories\pkg_notifications\notificationRepository;
use App\Repositories\pkg_rh\ApprenantRepositorie;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;

class notificationController extends AppBaseController
{

    protected $notification;
    protected $apprenant;
    public function __construct(notificationRepository $notification, ApprenantRepositorie $apprenant)
    {

        $this->apprenant = $apprenant;
        $this->notification = $notification;
    }

    public function index(Request $request)
    { 
        if ($request->ajax()) {
            $searchValue = $request->get('searchValue');
            if ($searchValue !== '') {
                $searchQuery = str_replace(' ', '%', $searchValue);
                $notificationsData = $this->notification->searchData($searchQuery);
                return view('pkg_notifications.notification.index', compact('notificationsData'))->render();
            }
        }
        $notificationsData = $this->notification->paginate();
        return view('pkg_notifications.notification.index', compact('notificationsData'));
    }

    public function create()
    {
        $apprenants = $this->apprenant->all();
        return view('pkg_notifications.notification.create', compact('apprenants'));
    }

    public function store(notificationRequest $request)
    {
        try {
            $data = $request->validated();
            $this->notification->create($data);
            return redirect()->route('notification.index')->with('success', __('pkg_notifications/notification.singular') . ' ' . __('app.addSucées'));
        } catch (notificationException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function show($id)
    {
        if (Auth::user()->name == 'apprenant'){
            $this->notification->SetasSeen($id);
        }

        $fetchedData = $this->notification->find($id);
        $personne = $this->apprenant->find($fetchedData->apprenant_id);
        return view('pkg_notifications.notification.show', compact('fetchedData', 'personne'));
    }
    public function edit($id)
    {
        $apprenants = $this->apprenant->all();
        $dataToEdit = $this->notification->find($id);
        return view('pkg_notifications.notification.edit', compact('dataToEdit', 'apprenants'));
    }

    public function update(notificationRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->notification->update($id, $data);
            return redirect()->route('notification.index')->with('success', __('pkg_notifications/notification.singular') . ' ' . __('app.updateSucées'));
        } catch (notificationException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id){
        $this->notification->destroy($id);
        return redirect()->route('notification.index')->with('success', __('pkg_notifications/notification.singular') . ' ' . __('app.deleteSucées'));
    }



    public function export()
    {
        $notifications = $this->notification->all();

        return Excel::download(new notificationExport($notifications), 'notification.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new notificationImport, $request->file('file'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('notification.index')->withError('Le symbole de séparation est introuvable. Pas assez de données disponibles pour satisfaire au format.');
        }
        return redirect()->route('notification.index')->with('success', __('pkg_notifications/notification.singular') . ' ' . __('app.addSucées'));
    }
}
