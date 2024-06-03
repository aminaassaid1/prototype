<div class="card-body table-responsive p-0">
    <table class="table table-striped text-nowrap">
        <thead>
            <tr>
                <th>{{ __('pkg_projets/task.singular') }}</th>
                <th>{{ __('app.description') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projectData as $project)
                <tr>
                    <td>{{ $project->nom }}</td>
                    <td>{{ $project->description }}</td>
                    
                    <td class="text-center">
                        @can('show-TaskController')
                        <a href="{{ route('tasks.show', $project) }}" class="btn btn-default btn-sm">
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit-TaskController')
                        <a href="{{ route('tasks.edit', $project) }}" class="btn btn-sm btn-default">
                            <i class="fas fa-pen-square"></i>
                        </a>
                        @endcan
                        @can('destroy-TaskController')
                        <form action="{{ route('tasks.destroy', $project) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce task ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center p-2">
    <div class="d-flex align-items-center mb-2 ml-2 mt-2">
            @can('import-TaskController')
            <form action="{{ route('tasks.import') }}" method="post" class="mt-2" enctype="multipart/form-data"
                id="importForm">
                @csrf
                <label for="upload" class="btn btn-default btn-sm font-weight-normal">
                    <i class="fas fa-file-download"></i>
                    {{ __('app.import') }}
                </label>
                <input type="file" id="upload" name="file" style="display:none;" onchange="submitForm()" />
            </form>
            @endcan
            @can('export-TaskController')
            <form>
                <a href="{{ route('tasks.export') }}" class="btn btn-default btn-sm mt-0 mx-2">
                    <i class="fas fa-file-export"></i>
                    {{ __('app.export') }}</a>
            </form>
            @endcan

    </div>
    <div class="">
        <ul class="pagination  m-0 float-right">
            {{ $projectData->links() }}
        </ul>
    </div>
</div>
