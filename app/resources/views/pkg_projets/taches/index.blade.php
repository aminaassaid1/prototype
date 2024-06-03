@extends('layouts.app')
@section('title', __('pkg_projets/task/message.titre'))

@section('content')

    <div class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @php
                            // Generate the title using the title function
                            use App\helpers\TranslationHelper;
                            $lang = Config::get('app.locale');
                            $translatedName = TranslationHelper::getTitle(__('pkg_projets/task.singular'), $lang);
                            echo $translatedName;
                        @endphp
                    </h1>
                </div>

                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ route('tasks.create') }}" class="btn btn-info">
                            <i class="fas fa-plus"></i>
                            {{ __('app.add') }} {{ __('pkg_projets/task.singular') }}
                        </a>
                    </div>
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
                            <div class=" p-0">
                                <div class="input-group input-group-sm float-sm-right col-md-3 p-0">
                                    <input type="text" name="table_search" id="table_search"
                                        class="form-control float-right" placeholder="Recherche">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @include('pkg_projets.task.table')
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id='page' value="1">
    </section>
@endsection
