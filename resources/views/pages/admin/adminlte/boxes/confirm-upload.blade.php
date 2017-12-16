@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'boxes'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #box-index tr td:nth-of-type(6) {
            text-align: center;
        }
    </style>
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Boxes
@stop

@section('breadcrumb')
<li class="active">Boxes</li>
@stop

@section('content')
<div class="box box-primary">
    <form action="{{ action('Admin\BoxController@completeUploadImei') }}" method="POST">
        {{ csrf_field() }}
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\BoxController@index') !!}" class="btn btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                            <input type="submit" class="btn btn-primary btn-success" style="width: 125px;" value="Complete Upload">
                        </p>
                    </h3>
                    <br>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => count($boxes)])</p>
                </div>
            </div>
        </div>
        <div class="box-body" style=" overflow-x: scroll; ">
            <table class="table table-bordered" id="box-index">
                <tr>
                    <th style="width: 10px">No.</th>
                    <th>IMEI</th>
                    <th>Serial</th>
                </tr>
                @foreach( $boxes as $index => $box )
                    <tr>
                        <td>{{ $index }}</td>
                        <td>
                            <input type="hidden" name="boxes[{{$index}}][imei]" value="{{$box->imei}}">
                            {{ $box->imei }}
                        </td>
                        <td>
                            <input type="hidden" name="boxes[{{$index}}][serial]" value="{{$box->serial}}">
                            {{ $box->serial }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="box-footer">
        </div>
    </form>
</div>
@stop