<header class="main-header start-style">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                {{-- <div class="logo-area">
                    <a href="{{url('/')}}" class="logoimg">
                       <span>
                            <img class="img-blog" src="{{Vite::asset('resources/front/images/tatasteel-logo-blue.png')}}" alt="Tatasteel Logo">
                            <img class="img-blog" src="{{Vite::asset('resources/front/images/logo.png')}}" alt="Logo">
                        </span>
                    </a>
                </div> --}}
                <div class="">
                    <table width="100%">
                        <tr>
                            <td align="left">
                                <a href="{{url('/')}}">
                                    <img src="{{Vite::asset('resources/front/images/tatasteel-logo-blue.png')}}" alt="Tatasteel Logo">
                                </a>
                            </td>
                            <td align="right">
                                <a href="{{url('/')}}">
                                    <img src="{{Vite::asset('resources/front/images/logo.png')}}" alt="Logo">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="account-area">
                    <ul>
                        <li class="position-relative">
                            @if(empty(Session::get('user_session')))
                                {{-- <span class="account-img" data-bs-toggle="modal" data-bs-target="#loginModal"><img src="{{ Vite::asset('resources/front/images/avatar.jpg')}}" alt=""></span> --}}
                            @else
                                <div class="account-details">
                                    <div class="account-name account_name" onclick="lang_select()">
                                        <span class="account-img">
                                            @if(Auth::user()->admin_img!='')
                                                <img src="{{asset('storage/images/'.Auth::user()->admin_img)}}">
                                            @else
                                                <img src="{{ Vite::asset('resources/front/images/avatar.jpg')}}" alt="">
                                            @endif
                                        </span>
                                        <p>{{Session::get('user_session')->name}}</p>
                                    </div>
                                    <ul class="account-login" style="display: none;">
                                        {{-- <li class="active"><a href="{{url('user/my-account')}}">MI CUENTA</a></li> --}}
                                        @if(Auth::user()->is_admin==1)
                                            <li><a href="{{url('admin/user_logout')}}">Logout</a></li>
                                        @else
                                            <li><a href="{{url('user/user_logout')}}">Logout</a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </li>
                        @if(Route::currentRouteName()!='home')
                        <li class="category-mobile-off-on">
                            <div class="category-mobile-menu">
                                <div class="category-hamburger" id="menu_open">
                                    <div class="category-hamburger-box">
                                        <div class="category-hamburger-inner"></div>
                                        <div class="category-hamburger-inner"></div>
                                        <div class="category-hamburger-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </header>
