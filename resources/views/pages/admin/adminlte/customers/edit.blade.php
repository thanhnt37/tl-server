@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'customers'] )

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
    Customers
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CustomerController@index') !!}"><i class="fa fa-files-o"></i> Customers</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $customer->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\CustomerController@store') !!} @else {!! action('Admin\CustomerController@update', [$customer->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\CustomerController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.customers.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $customer->name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('address')) has-error @endif">
                            <label for="address">@lang('admin.pages.customers.columns.address')</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ? old('address') : $customer->address }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label for="email">@lang('admin.pages.customers.columns.email')</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : $customer->email }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('telephone')) has-error @endif">
                            <label for="telephone">@lang('admin.pages.customers.columns.telephone')</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" required value="{{ old('telephone') ? old('telephone') : $customer->telephone }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('area')) has-error @endif">
                            <label for="area">@lang('admin.pages.customers.columns.area')</label>
                            <input type="text" class="form-control" id="area" name="area" value="{{ old('area') ? old('area') : $customer->area }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('agency')) has-error @endif">
                            <label for="agency">@lang('admin.pages.customers.columns.agency')</label>
                            <input type="text" class="form-control" id="agency" name="agency" value="{{ old('agency') ? old('agency') : $customer->agency }}">
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
