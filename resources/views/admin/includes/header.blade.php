<header class="main-header start-style">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">

            <!-- Left Logo -->
            <div class="col-auto left-logo">
                <a href="{{ url('/') }}" class="site-logo">
                    <img src="{{ Vite::asset('resources/front/images/tatasteel-logo-blue.png') }}" alt="Tatasteel Logo">
                </a>
            </div>

            <!-- Account Section (Now Before logo.png) -->
            <div class="col-auto pe-0">
                <div class="account-area-wrap">
                    @if(!empty(Session::get('user_session')))
                        <div class="account-details">
                            <div class="account-name account_name" onclick="lang_select()">
                                <span class="account-img">
                                    @if(Auth::user()->admin_img!='')
                                        <img src="{{asset('storage/images/'.Auth::user()->admin_img)}}">
                                    @else
                                        <img src="{{ Vite::asset('resources/front/images/avatar.jpg')}}" alt="">
                                    @endif
                                </span>
                                {{-- <p>{{Session::get('user_session')->name}}</p> --}}
                            </div>



                            <ul class="account-login" style="display: none;">
                                @if(Auth::user()->is_admin==1)
                                    <li><a href="{{url('admin/inventry-upload')}}">Upload Inventory</a></li>
                                    <li><a href="{{url('admin/inventry-details')}}">Inventory Details</a></li>
                                    @if(Auth::user()->user_access==2)
                                        <li><a href="{{url('user/inventry-check')}}">Frontend</a></li>
                                        <li><a href="javascript:void(0)" onclick="inventorySend()">Inventory Send</a></li>
                                    @endif
                                    

                                    <li><a href="{{url('admin/user_logout')}}">Logout</a></li>
                                @else

                                    @if(Auth::user()->user_access==2)
                                        <li><a href="{{url('admin/inventry-upload')}}">Upload Inventory</a></li>
                                        <li><a href="{{url('admin/inventry-details')}}">Inventory Details</a></li>
                                        <li><a href="{{url('user/inventry-check')}}">Frontend</a></li>
                                        
                                    @endif
                                    <li><a href="javascript:void(0)" onclick="inventorySend()">Inventory Send</a></li>
                                    <li><a href="{{url('user/user_logout')}}">Logout</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <div class="account-rgt-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ Vite::asset('resources/front/images/logo.png') }}" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Logo -->
            {{-- <div class="col-auto">
                <a href="{{ url('/') }}">
                    <img src="{{ Vite::asset('resources/front/images/logo.png') }}" alt="Logo">
                </a>
            </div> --}}

        </div>
    </div>
</header>