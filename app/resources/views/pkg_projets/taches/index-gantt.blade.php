@extends('layouts.app')

@section('title',  __('pkg_projets/taches/diagramme-de-gantt.singular'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('pkg_projets/taches/diagramme-de-gantt.singular') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-6 row">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-5 pl-0">
                                            <select id="projectSelect" class="form-control">
                                                <option value="">{{ __('Tous les Projets') }}</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div id="taskContainer">
                            @include('pkg_projets.taches.gantt-chart')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
