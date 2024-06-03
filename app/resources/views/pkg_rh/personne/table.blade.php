<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th class="text-center">{{__('pkg_rh/personne.name')}}</th>
                <th class="text-center">{{__('pkg_rh/personne.prenom')}}</th>
                <th class="text-center">{{__('pkg_rh/personne.type')}}</th>
                <th class="text-center">{{__('pkg_rh/personne.action')}}</th>
            </tr>
        </thead>
        <tbody id="table-personne">
            @foreach ($personnes as $item)
                <tr>
                    <td class="text-center">{{ $item->nom }}</td>
                    <td class="text-center">{{ $item->prenom }}</td>
                    <td class="text-center">{{ $item->type }}</td>
                    <td class="text-center">
                        {{-- @can('show-PersonneController') --}}
                            <a href="{{ route($type.'.show', $item->id) }}" class="btn btn-default btn-sm">
                                <i class="far fa-eye"></i>
                            </a>
                        {{-- @endcan --}}
                        {{-- @can('edit-PersonneController') --}}
                            <a href="{{ route($type.'.edit', $item->id) }}" class="btn btn-sm btn-default">
                                <i class="fas fa-pen-square"></i>
                            </a>
                        {{-- @endcan --}}
                        {{-- @can('destroy-PersonneController') --}}
                            <form action=""{{ route($type.'.delete', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        {{-- @endcan --}}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-md-flex justify-content-between align-items-center p-2">
    {{-- <div class="d-flex align-items-center mb-2 ml-2 mt-2">
        @can('import-PersonneController')
            <form action="{{ route($type.'.import') }}" method="post" class="mt-2" enctype="multipart/form-data"
                id="importForm">
                @csrf
                <label for="upload" class="btn btn-default btn-sm font-weight-normal">
                    <i class="fas fa-file-download"></i>
                    {{ __('app.import') }}
                </label>
                <input type="file" id="upload" name="file" style="display:none;" onchange="submitForm()" />
            </form>
        @endcan
        @can('export-PersonneController')
            <form class="">
                <a href="{{ route($type.'.export') }}" class="btn btn-default btn-sm mt-0 mx-2">
                    <i class="fas fa-file-export"></i>
                    {{ __('app.export') }}</a>
            </form>
        @endcan
    </div> --}}

    <ul class="pagination  m-0 float-right">
        {{ $personnes->onEachSide(1)->links() }}
    </ul>
</div>
