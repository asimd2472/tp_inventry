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

        @php
            $user = Auth::user();

            $isSuperAdmin = $user->super_admin == 1;
            $isUserAdmin = $user->user_access == 2;
        @endphp

        <ul>

            {{-- SUPER ADMIN + USER ADMIN --}}
            @if($isSuperAdmin || $isUserAdmin)

                <li class="{{ Route::currentRouteName() == 'admin.inventory_details' ? 'active' : '' }}">
                    <a href="{{ url('admin/inventry-details') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        Inventory Details
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.inventory_upload' ? 'active' : '' }}">
                    <a href="{{ url('admin/inventry-upload') }}">
                        <i class="menu-icon fa-solid fa-upload"></i>
                        Upload Inventory
                    </a>
                </li>

            @endif


            {{-- SUPER ADMIN ONLY --}}
            @if($isSuperAdmin)

                <li class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">
                    <a href="{{ url('admin/users') }}">
                        <i class="menu-icon fa-solid fa-users"></i>
                        Users
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.cvr_details' ? 'active' : '' }}">
                    <a href="{{ url('admin/cvr-details') }}">
                        <i class="menu-icon fa-solid fa-chalkboard"></i>
                        CVR Details
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.gallery' ? 'active' : '' }}">
                    <a href="{{ url('admin/gallery') }}">
                        <i class="menu-icon fa-solid fa-image"></i>
                        Manage Gallery
                    </a>
                </li>

                <li class="{{ Route::currentRouteName() == 'admin.login_history' ? 'active' : '' }}">
                    <a href="{{ url('admin/login-history') }}">
                        <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                        Login History
                    </a>
                </li>

            @endif


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
