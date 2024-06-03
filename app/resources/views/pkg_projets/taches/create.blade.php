@extends('layouts.app')
@section('title', __('app.add') . ' ' . __('GestionTasks/task/message.titre'))
@section('content')
    <div class="content-header">
        @if ($errors->has('project_exists'))
            <div class="alert alert-danger">
                {{ $errors->first('project_exists') }}
            </div>
        @else
            @if ($errors->has('unexpected_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('unexpected_error') }}
                </div>
            @endif
        @endif
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="nav-icon fas fa-table"></i>
                                {{ __('app.add') }} {{ __('GestionTasks/task/message.titre') }}
                            </h3>
                        </div>
                        <!-- Obtenir le formulaire -->
                        @include('GestionTasks.task.fields')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
