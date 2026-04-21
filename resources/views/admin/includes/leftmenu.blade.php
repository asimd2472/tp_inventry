{{-- <div class="left-menu-btn">
    <button type="button" id="menu_open">open menu </button>
</div> --}}
<div class="userwrap-lft" id="menu_wrap">
    <div class="user-dashboard">
        <ul>
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
                    <a href="{{url('admin/gallery')}}"><i class="menu-icon fa-solid fa-chalkboard"></i> Gallery</a>
                </li>
            @endif
            <li>
                <a href="{{url('admin/user_logout')}}"><i class="menu-icon fa-solid fa-arrow-right-from-bracket"></i>Logout</a>
            </li>
        </ul>
    </div>
</div>
