@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'songs'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/select2/select2.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/plugins/select2/select2.full.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $(".new-albums").select2({
                placeholder: "Choose new albums for this song",
                allowClear: true
            });
            $(".new-genres").select2({
                placeholder: "Choose new genres for this song",
                allowClear: true
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Songs
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\SongController@index') !!}"><i class="fa fa-files-o"></i> Songs</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $song->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\SongController@store') !!} @else {!! action('Admin\SongController@update', [$song->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\SongController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('code')) has-error @endif">
                            <label for="code">@lang('admin.pages.songs.columns.code')</label>
                            <input type="text" class="form-control" id="code" name="code" required value="{{ old('code') ? old('code') : $song->code }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('wildcard')) has-error @endif">
                            <label for="wildcard">@lang('admin.pages.songs.columns.wildcard')</label>
                            <input type="text" class="form-control" id="wildcard" name="wildcard" required value="{{ old('wildcard') ? old('wildcard') : $song->wildcard }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.songs.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $song->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('link')) has-error @endif">
                            <label for="link">@lang('admin.pages.songs.columns.link')</label>
                            <input type="text" class="form-control" id="link" name="link" required value="{{ old('link') ? old('link') : $song->link }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('sub_link')) has-error @endif">
                            <label for="sub_link">@lang('admin.pages.songs.columns.sub_link')</label>
                            <input type="text" class="form-control" id="sub_link" name="sub_link" value="{{ old('sub_link') ? old('sub_link') : $song->sub_link }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('type')) has-error @endif">
                            <label for="type">@lang('admin.pages.songs.columns.type')</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ old('type') ? old('type') : $song->type }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('author_id')) has-error @endif">
                            <label for="author_id">@lang('admin.pages.songs.columns.author_id')</label>
                            <a href="{!! action('Admin\AuthorController@create') !!}" title="Create New Author"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>

                            <select class="form-control" name="os_version_id" id="os_version_id" required>
                                @foreach( $authors as $author )
                                    <option value="{!! $author->id !!}" @if( (old('author_id') && old('author_id') == $author->id) || ( $song->author_id == $author->id) ) selected @endif >
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publish_at">@lang('admin.pages.songs.columns.publish_at')</label>
                            <div class="input-group date datetime-field">
                                <input type="text" class="form-control" id="publish_at" name="publish_at" value="{{ old('publish_at') ? old('publish_at') : $song->publish_at }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.songs.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="@lang('admin.pages.songs.columns.description')">{{ old('description') ? old('description') : $song->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('image')) has-error @endif">
                            <label for="image">@lang('admin.pages.songs.columns.image')</label>
                            <input type="text" class="form-control" id="image" name="image" value="{{ old('image') ? old('image') : $song->image }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('view')) has-error @endif">
                            <label for="view">@lang('admin.pages.songs.columns.view')</label>
                            <input type="number" min="0" class="form-control" id="view" name="view" value="{{ old('view') ? old('view') : $song->view }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('play')) has-error @endif">
                            <label for="play">@lang('admin.pages.songs.columns.play')</label>
                            <input type="number" min="0" class="form-control" id="play" name="play" value="{{ old('play') ? old('play') : $song->play }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('vote')) has-error @endif">
                            <label for="vote">@lang('admin.pages.songs.columns.vote')</label>
                            <input type="number" min="0" class="form-control" id="vote" name="vote" value="{{ old('vote') ? old('vote') : $song->vote }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>

    {{-- album --}}
    @if( !$isNew )
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title text-center" style="display: block; font-weight: bold">
                            Albums
                        </h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered album-songs">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Vote</th>
                                <th>Actions</th>
                            </tr>
                            @foreach( $song->albums as $index => $album )
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>
                                        <a href="{!! action('Admin\AlbumController@show', $album->id) !!}">{{$album->name}}</a>
                                    </td>
                                    <td>{{$album->vote}}</td>
                                    <td>
                                        <a href="{{ action('Admin\AlbumController@deleteSong', [$album->id, $song->id]) }}" >@lang('admin.pages.common.buttons.delete')</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer">
                        <form action="{!! action('Admin\SongController@addNewAlbum', $song->id) !!}" method="POST">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="new-albums">Add New Album</label>
                                        <select class="form-control new-albums" name="new-albums[]" required id="new-albums" style="margin-bottom: 15px;" multiple="multiple">
                                            @foreach( $albums as $index => $album )
                                                <option value="{!! $album->id !!}">
                                                    {{ $album->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title text-center" style="display: block; font-weight: bold">
                            Genres
                        </h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered album-songs">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            @foreach( $song->genres as $index => $genre )
                                <tr>
                                    <td>{{$index}}</td>
                                    <td>
                                        <a href="{!! action('Admin\GenreController@show', $genre->id) !!}">{{$genre->name}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ action('Admin\GenreController@deleteSong', [$genre->id, $song->id]) }}" >@lang('admin.pages.common.buttons.delete')</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer">
                        <form action="{!! action('Admin\SongController@addNewGenre', $song->id) !!}" method="POST">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="new-genres">Add New Album</label>
                                        <select class="form-control new-genres" name="new-genres[]" required id="new-genres" style="margin-bottom: 15px;" multiple="multiple">
                                            @foreach( $genres as $index => $genre )
                                                <option value="{!! $genre->id !!}">
                                                    {{ $genre->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
