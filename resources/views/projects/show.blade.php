@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-3 rounded-3">
            <div class="container-fluid">
                <div class="row flex-nowrap">
                    <div class="col-12 col-md-12 px-0 bg-light rounded-3 sidebar">
                        <div class="d-flex flex-column align-items-center align-items-sm-start pt-2 text-white min-vh-100">
                        @include('sidebar');
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <span class="mr-5">{{ __('Project Details') }}</span>
                    <a href={{ route('projects.index')}}>Back to the list</a>
                </div>

                <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $project->title }}
                        </div>
                    </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>description:</strong>
                            {{ $project->description }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tiempo estimado:</strong>
                            {{ $project->eta }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Diseñador a cargo:</strong>
                            {{ $designer->name }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cliente:</strong>
                            {{ $client->name }}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
