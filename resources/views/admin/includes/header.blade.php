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



                            {{-- <ul class="account-login" style="display: none;">

                                
                                    <li><a href="{{url('admin/users')}}">Create User</a></li>
                                    <li><a href="{{url('admin/cvr-details')}}">CVR Details</a></li>
                                    <li><a href="{{url('admin/inventry-upload')}}">Upload Inventory</a></li>
                                    <li><a href="{{url('admin/inventry-details')}}">Inventory Details</a></li>
                                    <li><a href="{{url('admin/gallery')}}">Manage Gallery</a></li>
                                    <li><a href="{{url('admin/login-history')}}">Login history</a></li>
                                    <li><a href="{{url('user/inventry-check')}}">Explore Inventory</a></li>
                                    <li><a href="javascript:void(0)" onclick="inventorySend()">Download Catalog</a></li>
                                    

                                    <li><a href="{{url('admin/user_logout')}}">Logout</a></li>

                                        <li><a href="{{url('admin/inventry-upload')}}">Upload Inventory</a></li>
                                        <li><a href="{{url('admin/inventry-details')}}">Inventory Details</a></li>
                                            <li><a href="{{url('user/inventry-check')}}">Explore Inventory</a></li>
                                    <li><a href="{{url('user/user_logout')}}">Logout</a></li>
                            </ul> --}}


                            <ul class="account-login" style="display: none;">
                                @can('explore-inventory')
                                <li>
                                    <a href="{{ url('user/inventry-check') }}">
                                        Explore Inventory
                                    </a>
                                </li>
                                @endcan
                                @can('download-deales')
                                <li>
                                    <a href="{{ url('admin/download-deales') }}">
                                        Download Dealer list
                                    </a>
                                </li>
                                @endcan
                                @can('post-installation-images')
                                <li>
                                    <a href="{{ url('admin/post-installation-images') }}">
                                        Post Installation Images
                                    </a>
                                </li>
                                @endcan
                                @can('inventry-upload')
                                <li><a href="{{ url('admin/inventry-upload') }}">Upload Inventory</a></li>
                                @endcan
                                @can('inventory-details-view')
                                <li><a href="{{ url('admin/inventry-details') }}">Inventory Details</a></li>
                                @endcan
                                @can('user-view')
                                <li><a href="{{ url('admin/users') }}">Create User</a></li>
                                @endcan
                                @can('cvr-view')
                                <li>
                                    <a href="{{ url('admin/cvr') }}">
                                        CVR
                                    </a>
                                </li>
                                @endcan  
                                @can('repository') 
                                <li>
                                    <a href="{{ url('admin/cvr/repository') }}">
                                        CVR Repository
                                    </a>
                                </li>
                                @endcan

                                @can('site-visit-view')
                                <li>
                                    <a href="{{ route('admin.site_visit_record') }}">
                                        Site Visit Dashboard
                                    </a>
                                </li>
                                @endcan

                                    
                                        
                                    
                                <li>
                                    <a href="javascript:void(0)" onclick="inventorySend()">
                                        Download Catalog
                                    </a>
                                </li>
                                @can('manage-gallery')
                                    <li><a href="{{ url('admin/gallery') }}">Manage Gallery</a></li>
                                @endcan
                                @can('login-history')
                                    <li><a href="{{ url('admin/login-history') }}">Login history</a></li>
                                @endcan

                                    <li><a href="{{ url('user/user_logout') }}">Logout</a></li>

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