{{-- <div class="left-menu-btn">
    <button type="button" id="menu_open">open menu </button>
</div> --}}
<div class="userwrap-lft" id="menu_wrap">
    <div class="user-dashboard">
        <ul>
            <li class="{{Route::currentRouteName() == 'user.course_list' ? 'active' : ''}}">
                <a href="{{url('admin/inventry-details')}}"><i class="menu-icon fa-solid fa-chalkboard"></i> Inventry</a>
            </li>
            <li class="{{Route::currentRouteName() == 'user.course_list' ? 'active' : ''}}">
                <a href="{{url('admin/inventry-upload')}}"><i class="menu-icon fa-solid fa-upload"></i> Upload Inventry</a>
            </li>
            <li>
                <a href="{{url('admin/user_logout')}}"><i class="menu-icon fa-solid fa-arrow-right-from-bracket"></i>Logout</a>
            </li>
        </ul>
    </div>
</div>
