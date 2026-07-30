@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">CVR</div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')





<style>

  </style>
@endpush
