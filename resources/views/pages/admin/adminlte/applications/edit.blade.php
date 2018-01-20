@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'applications'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Applications
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ApplicationController@index') !!}"><i class="fa fa-files-o"></i> Applications</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $application->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="@if($isNew) {!! action('Admin\ApplicationController@store') !!} @else {!! action('Admin\ApplicationController@update', [$application->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\ApplicationController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Application Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $application->name }}">
                        </div>
                    </div>
                </div>

                @if( !$isNew )
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('app_key')) has-error @endif">
                                <label for="app_key">@lang('admin.pages.applications.columns.app_key')</label>
                                <textarea name="app_key" class="form-control" rows="5" required placeholder="@lang('admin.pages.applications.columns.app_key')">{{ old('app_key') ? old('app_key') : $application->app_key }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
