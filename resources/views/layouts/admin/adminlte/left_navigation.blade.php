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

        <ul class="sidebar-menu" style="margin-top: 15px;">
            <li class="header">Main Navigation</li>
            <li @if( $menu=='dashboard') class="active" @endif ><a href="{!! \URL::action('Admin\IndexController@index') !!}"><i class="fa fa-dashboard"></i> <span>@lang('admin.menu.dashboard')</span></a></li>

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                <li class="header">Boxes Management</li>
                <li @if( $menu=='boxes') class="active" @endif ><a href="{!! \URL::action('Admin\BoxController@index') !!}"><i class="fa fa-square-o"></i> <span>Boxes</span></a></li>
                <li @if( $menu=='os_versions') class="active" @endif ><a href="{!! \URL::action('Admin\OsVersionController@index') !!}"><i class="fa fa-android"></i> <span>Phiên bản OS</span></a></li>
                <li @if( $menu=='sdk_versions') class="active" @endif ><a href="{!! \URL::action('Admin\SdkVersionController@index') !!}"><i class="fa fa-wrench"></i> <span>Phiên bản SDK</span></a></li>
                <li @if( $menu=='box_versions') class="active" @endif ><a href="{!! \URL::action('Admin\BoxVersionController@index') !!}"><i class="fa fa-archive"></i> <span>Loại Box</span></a></li>

                <li class="header">App Management</li>
                <li @if( $menu=='applications') class="active" @endif ><a href="{!! \URL::action('Admin\ApplicationController@index') !!}"><i class="fa fa-microchip"></i> <span>Ứng dụng</span></a></li>
                <li @if( $menu=='app_versions') class="active" @endif ><a href="{!! \URL::action('Admin\AppVersionController@index') !!}"><i class="fa fa-code-fork"></i> <span>Phiên bản</span></a></li>
                <li @if( $menu=='app_ota') class="active" @endif ><a href="{!! \URL::action('Admin\AppOtaController@index') !!}"><i class="fa fa-object-ungroup"></i> <span>OTA Manager</span></a></li>

                <li class="header">Sales Management</li>
                <li @if( $menu=='customers') class="active" @endif ><a href="{!! \URL::action('Admin\CustomerController@index') !!}"><i class="fa fa-users"></i> <span>Khách hàng</span></a></li>
                <li @if( $menu=='sales') class="active" @endif ><a href="{!! \URL::action('Admin\SaleController@index') !!}"><i class="fa fa-money"></i> <span>Bán hàng</span></a></li>

                <li class="header">TL Launcher</li>
            @endif

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_ADMIN) )
                <li class="header">TL Karaoke</li>
                <li @if( $menu=='songs') class="active" @endif ><a href="{!! \URL::action('Admin\SongController@index') !!}"><i class="fa fa-music"></i> <span>Bài hát</span></a></li>
                <li @if( $menu=='albums') class="active" @endif ><a href="{!! \URL::action('Admin\AlbumController@index') !!}"><i class="fa fa-braille"></i> <span>Albums</span></a></li>
                <li @if( $menu=='genres') class="active" @endif ><a href="{!! \URL::action('Admin\GenreController@index') !!}"><i class="fa fa-transgender-alt"></i> <span>Thể loại</span></a></li>
                <li @if( $menu=='singers') class="active" @endif ><a href="{!! \URL::action('Admin\SingerController@index') !!}"><i class="fa fa-user-circle"></i> <span>Ca sĩ</span></a></li>
                <li @if( $menu=='authors') class="active" @endif ><a href="{!! \URL::action('Admin\AuthorController@index') !!}"><i class="fa fa-user-o"></i> <span>Tác giả</span></a></li>
            @endif

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                <li class="header">TL Store</li>
                <li @if( $menu=='store_applications') class="active" @endif ><a href="{!! \URL::action('Admin\StoreApplicationController@index') !!}"><i class="fa fa-microchip"></i> <span>Ứng dụng</span></a></li>
                <li @if( $menu=='categorys') class="active" @endif ><a href="{!! \URL::action('Admin\CategoryController@index') !!}"><i class="fa fa-list"></i> <span>Danh mục</span></a></li>
                <li @if( $menu=='developers') class="active" @endif ><a href="{!! \URL::action('Admin\DeveloperController@index') !!}"><i class="fa fa-user-md"></i> <span>Nhà Phát triển</span></a></li>

                <li class="header">Backend</li>
                <li @if( $menu=='oauth_clients') class="active" @endif ><a href="{!! \URL::action('Admin\OauthClientController@index') !!}"><i class="fa fa-key"></i> <span>Oauth Clients</span></a></li>
                <li @if( $menu=='admin_users') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserController@index') !!}"><i class="fa fa-user-secret"></i> <span>Quản trị viên</a></li>
                <li @if( $menu=='logs') class="active" @endif ><a href="{!! \URL::action('Admin\LogController@index') !!}"><i class="fa fa-sticky-note-o"></i> <span>@lang('admin.menu.log_system')</span></a></li>
            @endif
            <!-- %%SIDEMENU%% -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>