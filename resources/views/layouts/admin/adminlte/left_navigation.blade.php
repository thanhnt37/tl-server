<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if(!empty($authUser->present()->profileImage())) {{ $authUser->present()->profileImage()->present()->url }} @else {!! \URLHelper::asset('img/user_avatar.png', 'common') !!} @endif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>@if($authUser->name){{ $authUser->name }} @else {{ $authUser->email }} @endif</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li @if( $menu=='dashboard') class="active" @endif ><a href="{!! \URL::action('Admin\IndexController@index') !!}"><i class="fa fa-dashboard"></i> <span>@lang('admin.menu.dashboard')</span></a></li>
            <li @if( $menu=='boxes') class="active" @endif ><a href="{!! \URL::action('Admin\BoxController@index') !!}"><i class="fa fa-square-o"></i> <span>Boxes</span></a></li>
            <li @if( $menu=='kara_ota') class="active" @endif ><a href="{!! \URL::action('Admin\KaraOtaController@index') !!}"><i class="fa fa-object-ungroup"></i> <span>Kara OTA</span></a></li>
            <li @if( $menu=='kara_versions') class="active" @endif ><a href="{!! \URL::action('Admin\KaraVersionController@index') !!}"><i class="fa fa-code-fork"></i> <span>Kara Versions</span></a></li>
            <li @if( $menu=='os_versions') class="active" @endif ><a href="{!! \URL::action('Admin\OsVersionController@index') !!}"><i class="fa fa-android"></i> <span>OS Versions</span></a></li>
            <li @if( $menu=='sdk_versions') class="active" @endif ><a href="{!! \URL::action('Admin\SdkVersionController@index') !!}"><i class="fa fa-wrench"></i> <span>SDK Versions</span></a></li>
            <li @if( $menu=='box_versions') class="active" @endif ><a href="{!! \URL::action('Admin\BoxVersionController@index') !!}"><i class="fa fa-archive"></i> <span>Box Versions</span></a></li>

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_ADMIN) )
                <li @if( $menu=='oauth_clients') class="active" @endif ><a href="{!! \URL::action('Admin\OauthClientController@index') !!}"><i class="fa fa-key"></i> <span>Oauth Clients</span></a></li>
                <li @if( $menu=='admin_users') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserController@index') !!}"><i class="fa fa-user-secret"></i> <span>@lang('admin.menu.admin_users')</span></a></li>
{{--                <li @if( $menu=='admin_user_notifications') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserNotificationController@index') !!}"><i class="fa fa-bell-o"></i> <span>@lang('admin.menu.admin_user_notifications')</span></a></li>--}}
            @endif

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                {{--<li @if( $menu=='users') class="active" @endif ><a href="{!! \URL::action('Admin\UserController@index') !!}"><i class="fa fa-users"></i> <span>@lang('admin.menu.users')</span></a></li>--}}
                {{--<li @if( $menu=='user_notifications') class="active" @endif ><a href="{!! \URL::action('Admin\UserNotificationController@index') !!}"><i class="fa fa-bell"></i> <span>@lang('admin.menu.user_notifications')</span></a></li>--}}
{{--                <li @if( $menu=='site_configurations') class="active" @endif ><a href="{!! \URL::action('Admin\SiteConfigurationController@index') !!}"><i class="fa fa-cogs"></i> <span>@lang('admin.menu.site_configuration')</span></a></li>--}}
                <li @if( $menu=='logs') class="active" @endif ><a href="{!! \URL::action('Admin\LogController@index') !!}"><i class="fa fa-sticky-note-o"></i> <span>@lang('admin.menu.log_system')</span></a></li>
                {{--<li @if( $menu=='images') class="active" @endif ><a href="{!! \URL::action('Admin\ImageController@index') !!}"><i class="fa fa-file-image-o"></i> <span>@lang('admin.menu.images')</span></a></li>--}}
                {{--<li @if( $menu=='articles') class="active" @endif ><a href="{!! \URL::action('Admin\ArticleController@index') !!}"><i class="fa fa-file-word-o"></i> <span>@lang('admin.menu.articles')</span></a></li>--}}
            @endif
            <li @if( $menu=='songs') class="active" @endif ><a href="{!! \URL::action('Admin\SongController@index') !!}"><i class="fa fa-users"></i> <span>Songs</span></a></li>
            <li @if( $menu=='albums') class="active" @endif ><a href="{!! \URL::action('Admin\AlbumController@index') !!}"><i class="fa fa-users"></i> <span>Albums</span></a></li>
            <li @if( $menu=='authors') class="active" @endif ><a href="{!! \URL::action('Admin\AuthorController@index') !!}"><i class="fa fa-users"></i> <span>Authors</span></a></li>
            <!-- %%SIDEMENU%% -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>