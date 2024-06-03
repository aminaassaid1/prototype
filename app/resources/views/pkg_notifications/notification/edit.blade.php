@extends('layouts.app')
@section('title', __('app.edit') . ' ' . __('pkg_notifications/notification.singular'))
@section('content')
    <div class="content-header">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
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
                                {{ __('app.edit') }} {{ __('pkg_notifications/notification.singular') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form id="createForm" method="post"
                                action="{{ route('notification.update', $dataToEdit->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="apprenant_id">Apprenant:</label>
                                        <select class="form-control" name="apprenant_id" id="apprenant_id">
                                            @foreach ($apprenants as $apprenant)
                                                <option {{ ($dataToEdit->apprenant_id == $apprenant->id || old('apprenant_id') == $apprenant->id ) ? 'selected' : ''}} value="{{ $apprenant->id }}">{{ $apprenant->prenom . ' ' . $apprenant->nom}}</option>
                                            @endforeach
                                        </select>
                                        @error('apprenant_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="titre">Titre:</label>
                                        <input type="text" class="form-control" id="titre" name="titre"
                                            value="{{ $dataToEdit ? $dataToEdit->titre : old('titre') }}">
                                        @error('titre')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message:</label>
                                        <textarea class="form-control" id="editor" name="message" rows="3">{{ $dataToEdit ? $dataToEdit->message : old('titre') }}</textarea>
                                        @error('message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('notification.index') }}"
                                        class="btn btn-secondary">{{ __('app.cancel') }}</a>
                                    <button type="submit" class="btn btn-info">{{ __('app.edit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
