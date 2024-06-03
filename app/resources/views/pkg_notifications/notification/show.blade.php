@extends('layouts.app')
@section('title', __('app.show') . ' ' . __('pkg_notifications/notification.singular'))
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('app.detail') }} {{ __('pkg_notifications/notification.singular') }}</h1>
                </div>
                @can('edit-notificationController')
                    <div class="col-sm-6">
                        <a href="{{ route('notification.edit', $fetchedData->id) }}" class="btn btn-info float-right">
                            <i class="far fa-edit"></i>
                            {{ __('app.edit') }}
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <label>Apprenant</label>
                                <p>{{ $personne->prenom . ' ' . $personne->nom }}</p>
                            </div>
                            <div class="col-sm-12">
                                <label>{{ __('app.title') }}</label>
                                <p>{{ $fetchedData->titre }}</p>
                            </div>

                            <div class="col-sm-12">
                                <label>{{ __('app.message') }}</label>
                                <p>{!! $fetchedData->message !!}</p>
                            </div>
                        </div>  
                        <div class="card-footer">
                            <a href="{{ route('notification.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
