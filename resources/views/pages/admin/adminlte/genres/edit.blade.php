@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'genres'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/select2/select2.min.css', 'admin') !!}">
    <style>
        .album-songs tr td:nth-child(5){
            text-align: center;
        }
    </style>
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/plugins/select2/select2.full.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $(".new-songs").select2({
                placeholder: "Choose new song to album",
                allowClear: true,
                ajax: {
                    delay: 500,
                    url: function (params) {
                        return '{{action('Admin\SongController@search')}}';
                    },
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                },
                cache: true
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Genres
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\GenreController@index') !!}"><i class="fa fa-files-o"></i> Genres</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $genre->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\GenreController@store') !!} @else {!! action('Admin\GenreController@update', [$genre->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <a href="{!! URL::action('Admin\GenreController@index') !!}"
                           class="btn btn-block btn-default btn-sm"
                           style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group text-center">
                                @if( !empty($genre->image) )
                                    <img id="profile-image-preview" style="max-width: 500px; width: 100%;" src="{!! $genre->image !!}" alt="" class="margin"/>
                                @else
                                    <img id="profile-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                                @endif
                                <input type="file" style="display: none;" id="cover-image" name="cover_image">
                                <p class="help-block" style="font-weight: bolder;">Cover Image </p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <table class="edit-user-profile">
                                <tr class="@if ($errors->has('name')) has-error @endif">
                                    <td>
                                        <label for="name">@lang('admin.pages.genres.columns.name')</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $genre->name }}">
                                    </td>
                                </tr>
                                <tr class="@if ($errors->has('image')) has-error @endif">
                                    <td>
                                        <label for="image">@lang('admin.pages.genres.columns.image')</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="image" name="image" value="{{ old('image') ? old('image') : $genre->image }}" style="margin-top: 15px;">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('description')) has-error @endif">
                                <label for="description">@lang('admin.pages.genres.columns.description')</label>
                                <textarea name="description" class="form-control" rows="5" placeholder="@lang('admin.pages.genres.columns.description')">{{ old('description') ? old('description') : $genre->description }}</textarea>
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

    @if( !$isNew )
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-center" style="display: block; font-weight: bold">
                    Songs
                </h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered album-songs">
                    <tr>
                        <th>No.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Vote</th>
                        <th>Actions</th>
                    </tr>
                    @foreach( $genre->songs as $index => $song )
                        <tr>
                            <td>{{$index}}</td>
                            <td>
                                <a href="{!! action('Admin\SongController@show', $song->id) !!}">{{$song->code}}</a>
                            </td>
                            <td>
                                <a href="{!! action('Admin\SongController@show', $song->id) !!}">{{$song->name}}</a>
                            </td>
                            <td>{{$song->vote}}</td>
                            <td>
                                <a href="{{ action('Admin\GenreController@deleteSong', [$genre->id, $song->id]) }}" >@lang('admin.pages.common.buttons.delete')</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="box-footer">
                <form action="{!! action('Admin\GenreController@addNewSong', $genre->id) !!}" method="POST">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="employee-id">Add New Song</label>
                                <select class="form-control new-songs" name="new-songs[]" required id="new-songs" style="margin-bottom: 15px;" multiple="multiple">

                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                </form>
            </div>
        </div>
    @endif
@stop
