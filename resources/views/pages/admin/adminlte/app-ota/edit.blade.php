@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'kara_ota'] )

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

        Boilerplate.appVersionSelectedId = <?php echo isset($karaOta->karaVersion->id) ? $karaOta->karaVersion->id : 0; ?>;
        Boilerplate.appVersions = {!! $karaVersions !!};

        $(document).ready(function () {
            $('#application_id').on('change', function () {
                let applicationId = $('#application_id').find(":selected").val();

                $('#kara_version_id').html('');
                Boilerplate.appVersions.forEach(function (item, index) {
                    if( item.application_id == applicationId ) {
                        let selected = ( item.id == Boilerplate.appVersionSelectedId ) ? 'selected' : '';
                        let option = '<option value="' + item.id + '" ' + selected + '>' + item.version + ' | ' + item.name + '</option>';

                        $('#kara_version_id').append(option);
                    }
                });
                console.log(applicationId);
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    KaraOta
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\AppOtaController@index') !!}"><i class="fa fa-files-o"></i> KaraOta</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $karaOta->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\AppOtaController@store') !!} @else {!! action('Admin\AppOtaController@update', [$karaOta->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\AppOtaController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('os_version_id')) has-error @endif">
                            <label for="os_version_id">@lang('admin.pages.kara-ota.columns.os_version')</label>
                            <select class="form-control" name="os_version_id" id="os_version_id" required>
                                @foreach( $osVersions as $osVersion )
                                    <option value="{!! $osVersion->id !!}" @if( (old('os_version_id') && old('os_version_id') == $osVersion->id) || ( $karaOta->os_version_id == $osVersion->id) ) selected @endif >
                                        {{ $osVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('sdk_version_id')) has-error @endif">
                            <label for="sdk_version_id">@lang('admin.pages.kara-ota.columns.sdk_version')</label>
                            <select class="form-control" name="sdk_version_id" id="sdk_version_id" required>
                                @foreach( $sdkVersions as $sdkVersion )
                                    <option value="{!! $sdkVersion->id !!}" @if( (old('sdk_version_id') && old('sdk_version_id') == $sdkVersion->id) || ( $karaOta->sdk_version_id == $sdkVersion->id) ) selected @endif >
                                        {{ $sdkVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('box_version_id')) has-error @endif">
                            <label for="box_version_id">@lang('admin.pages.kara-ota.columns.box_version_id')</label>
                            <select class="form-control" name="box_version_id" id="box_version_id" required>
                                @foreach( $boxVersions as $boxVersion )
                                    <option value="{!! $boxVersion->id !!}" @if( (old('box_version_id') && old('box_version_id') == $boxVersion->id) || ( $karaOta->box_version_id == $boxVersion->id) ) selected @endif >
                                        {{ $boxVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('application_id')) has-error @endif">
                            <label for="application_id">Application</label>

                            <select class="form-control" name="application_id" id="application_id" required>
                                @foreach( $applications as $application )
                                    <option value="{!! $application->id !!}" @if( (old('application_id') && old('application_id') == $application->id) || ( isset($karaOta->karaVersion->application->id) && ($karaOta->karaVersion->application->id == $application->id)) ) selected @endif >
                                        {{ $application->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('kara_version_id')) has-error @endif">
                            <label for="kara_version_id">App Version</label>
                            <select class="form-control" name="kara_version_id" id="kara_version_id" required>
                                @foreach( $karaVersions as $karaVersion )
                                    @if( isset($karaOta->karaVersion->application->id) && ($karaOta->karaVersion->application->id == $karaVersion->application_id))
                                        <option value="{!! $karaVersion->id !!}" @if( (old('kara_version_id') && old('kara_version_id') == $karaVersion->id) || ( $karaOta->kara_version_id == $karaVersion->id) ) selected @endif >
                                            {{ $karaVersion->version . ' | ' . $karaVersion->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
