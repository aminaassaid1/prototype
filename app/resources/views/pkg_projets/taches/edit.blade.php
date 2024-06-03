@extends('layouts.app')
@section('title', __('app.edit') . ' ' . __('GestionTasks/task/message.titre'))

@section('content')
    <div class="content-header">
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="nav-icon fas fa-table"></i>
                                {{ __('app.edit') }}
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
