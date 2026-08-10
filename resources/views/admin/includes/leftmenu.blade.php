{{-- <div class="left-menu-btn">
    <button type="button" id="menu_open">open menu </button>
</div> --}}
<div class="userwrap-lft" id="menu_wrap">
    <div class="user-dashboard">
        {{-- <ul>
            <li class="{{Route::currentRouteName() == 'user.course_list' ? 'active' : ''}}">
                <a href="{{url('admin/inventry-details')}}"><i class="menu-icon fa-solid fa-chalkboard"></i> Inventory Details</a>
            </li>
            <li class="{{Route::currentRouteName() == 'user.course_list' ? 'active' : ''}}">
                <a href="{{url('admin/inventry-upload')}}"><i class="menu-icon fa-solid fa-upload"></i> Upload Inventory</a>
            </li>
            @if(Auth::user()->super_admin==1)
                <li class="{{Route::currentRouteName() == 'user.users' ? 'active' : ''}}">
                    <a href="{{url('admin/users')}}"><i class="menu-icon fa-solid fa-users"></i> Users</a>
                </li>
                <li class="{{Route::currentRouteName() == 'user.cvr_details' ? 'active' : ''}}">
                    <a href="{{url('admin/cvr-details')}}"><i class="menu-icon fa-solid fa-chalkboard"></i> CVR Details</a>
                </li>
                <li class="{{Route::currentRouteName() == 'admin.gallery' ? 'active' : ''}}">
                    <a href="{{url('admin/gallery')}}"><i class="menu-icon fa-solid fa-chalkboard"></i>Manage Gallery</a>
                </li>
                <li class="{{Route::currentRouteName() == 'admin.login_history' ? 'active' : ''}}">
                    <a href="{{url('admin/login-history')}}"><i class="menu-icon fa-solid fa-chalkboard"></i> Login history</a>
                </li>
            @endif
            <li>
                <a href="{{url('admin/user_logout')}}"><i class="menu-icon fa-solid fa-arrow-right-from-bracket"></i>Logout</a>
            </li>
        </ul> --}}

        <ul>

            
                @can('explore-inventory')
                <li class="">
                    <a href="{{ url('user/inventry-check') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        Explore Inventory
                    </a>
                </li>
                @endcan
                @can('inventory-details-view')
                <li class="{{ Route::currentRouteName() == 'admin.inventory_details' ? 'active' : '' }}">
                    <a href="{{ url('admin/inventry-details') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        Inventory Details
                    </a>
                </li>
                @endcan

                @can('inventry-upload')
                <li class="{{ Route::currentRouteName() == 'admin.inventory_upload' ? 'active' : '' }}">
                    <a href="{{ url('admin/inventry-upload') }}">
                        <i class="menu-icon fa-solid fa-upload"></i>
                        Upload Inventory
                    </a>
                </li>
                @endcan
                @can('download-deales')
                <li class="{{ Route::currentRouteName() == 'admin.inventory_upload' ? 'active' : '' }}">
                    <a href="{{ url('admin/download-deales') }}">
                        <i class="menu-icon fa-solid fa-download"></i>
                        Download Dealer list
                    </a>
                </li>
                @endcan
                @can('post-installation-images')
                <li class="{{ Route::currentRouteName() == 'admin.inventory_upload' ? 'active' : '' }}">
                    <a href="{{ url('admin/post-installation-images') }}">
                        <i class="menu-icon fa-solid fa-download"></i>
                        Post Installation Images
                    </a>
                </li>
                @endcan
                @can('user-view')
                <li class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">
                    <a href="{{ url('admin/users') }}">
                        <i class="menu-icon fa-solid fa-users"></i>
                        Users
                    </a>
                </li>
                @endcan

                @can('role-view')
                <li class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">
                    <a href="{{ url('admin/roles') }}">
                        <i class="menu-icon fa-solid fa-users"></i>
                        Role Management
                    </a>
                </li>
                @endcan

                @can('cvr-view')
                <li class="{{ Route::currentRouteName() == 'admin.cvr' ? 'active' : '' }}">
                    <a href="{{ url('admin/cvr') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        CVR
                    </a>
                </li>
                @endcan
                @can('repository')
                <li class="{{ Route::currentRouteName() == 'admin.repository' ? 'active' : '' }}">
                    <a href="{{ url('admin/cvr/repository') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        CVR Repository
                    </a>
                </li>
                @endcan
                @if(Auth::user() && (Auth::user()->hasRole('Super User') || Auth::user()->hasRole('Sales Manager') || Auth::user()->hasRole('Sales Executive')))
                <li class="{{ Route::currentRouteName() == 'admin.site_visit_record' ? 'active' : '' }}">
                    <a href="{{ route('admin.site_visit_record') }}">
                        <i class="menu-icon fa-solid fa-map-marker-alt"></i>
                        Site Visit Dashboard
                    </a>
                </li>
                @endif
                @can('manage-gallery')
                <li class="{{ Route::currentRouteName() == 'admin.gallery' ? 'active' : '' }}">
                    <a href="{{ url('admin/gallery') }}">
                        <i class="menu-icon fa-solid fa-image"></i>
                        Manage Gallery
                    </a>
                </li>
                @endcan
                @can('login-history')
                <li class="{{ Route::currentRouteName() == 'admin.login_history' ? 'active' : '' }}">
                    <a href="{{ url('admin/login-history') }}">
                        <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                        Login History
                    </a>
                </li>
                @endcan

            {{-- LOGOUT --}}
            <li>
                <a href="{{ url('admin/user_logout') }}">
                    <i class="menu-icon fa-solid fa-arrow-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>
    </div>
</div>
