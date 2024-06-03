<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>{{ __('pkg_autorisations/autorisation.singular') }}</th>

                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilisateurData as $utilisateur)
                <tr>
                    <td>{{ $utilisateur->name }}</td>
                    <td>{{ $utilisateur->email }}</td>
                    <td>{{ $utilisateur->password }}</td>

                    <td class="text-center">
                        @can('show-utilisateursController')
                            <a href="{{ route('utilisateur.show', $utilisateur) }}" class="btn btn-default btn-sm">
                                <i class="far fa-eye"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-md-flex justify-content-between align-items-center p-2">
    <div class="d-flex align-items-center mb-2 ml-2 mt-2">
        @can('export-AutorisationsController')
                <a href="{{ route('utilisateur.export') }}" class="btn btn-default btn-sm mt-0 mx-2">
                    <i class="fas fa-file-export"></i>
                    {{ __('app.export') }}</a>
        @endcan
    </div>

    <ul class="pagination  m-0 float-right">
        {{ $utilisateurData->onEachSide(1)->links() }}
    </ul>
</div>
