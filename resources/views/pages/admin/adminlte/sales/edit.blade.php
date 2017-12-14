@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'sales'] )

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
    Sales
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\SaleController@index') !!}"><i class="fa fa-files-o"></i> Sales</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $sale->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\SaleController@store') !!} @else {!! action('Admin\SaleController@update', [$sale->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\SaleController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('customer_id')) has-error @endif">
                            <label for="customer_id">@lang('admin.pages.sales.columns.customer_id')</label>
                            <select class="form-control" name="customer_id" id="customer_id" required>
                                @foreach( $customers as $customer )
                                    <option value="{!! $customer->id !!}" @if( (old('customer_id') && old('customer_id') == $customer->id) || ( $sale->customer_id == $customer->id) || ($customer->id == \Session::get('customer_id')) ) selected @endif >
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('serial')) has-error @endif">
                            <label for="serial">@lang('admin.pages.sales.columns.box_id')</label>
                            <input type="text" class="form-control" id="serial" name="serial" autofocus value="{{ old('serial') ? old('serial') : (isset($sale->box->serial) ? $sale->box->serial : '') }}">
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
