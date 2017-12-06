@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'box_versions'] )

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
    BoxVersions
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\BoxVersionController@index') !!}"><i class="fa fa-files-o"></i> BoxVersions</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $boxVersion->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\BoxVersionController@store') !!} @else {!! action('Admin\BoxVersionController@update', [$boxVersion->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <a href="{!! URL::action('Admin\BoxVersionController@index') !!}"
                           class="btn btn-block btn-default btn-sm"
                           style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                <label for="name">@lang('admin.pages.box-versions.columns.name')</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ old('name') ? old('name') : $boxVersion->name }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm"
                            style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
    </form>
@stop
