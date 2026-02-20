@extends('layouts.front_user')
@section('content')
@php
    use Illuminate\Support\Facades\Crypt;
    use Carbon\Carbon;
@endphp
    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('front.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">HISTORICO DE PAGOS</div>
                        <div class="user-body">
                            <div class="account-tab-sec">
                                    <div class="container table-responsive">
                                        <table class="table table-bordered table-hover companyTable">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th scope="col">PAGO POR</th>
                                              <th scope="col">CANTIDAD</th>
                                              <th scope="col">ID DE PAGO</th>
                                              <th scope="col">RECIBO</th>
                                              <th scope="col">ESTADO</th>
                                              <th scope="col">FECHA DE PAGO</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($payment as $item)
                                                <tr>
                                                    <td>
                                                        @switch($item->type)
                                                            @case('Membership')
                                                                Membership Created
                                                                @break
                                                            @case('Membership Renew')
                                                                Membership Renewed
                                                                @break
                                                            @case('Membership Update')
                                                                Membership Update
                                                                @break
                                                            @case('Course')
                                                                Course
                                                                @break
                                                            @default
                                                                
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>{{$item->amount}} €</td>
                                                    <td>
                                                        <div id="txn-text-{{$item->id}}">
                                                            <span id="short-text-{{$item->id}}">{{ substr($item->local_translation_id, 0, 10) }}</span>
                                                            <div id="full-text-{{$item->id}}" class="more-text">
                                                                <span>{{ substr($item->local_translation_id, 10) }}</span>
                                                            </div>
                                                            <a href="javascript:void(0);" id="toggle-btn-{{$item->id}}">More</a>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <a style="color: #08adca;" href="{{url('user/invoice')}}/{{Crypt::encrypt($item->id)}}?type=view" target="_blank">VISTA</a><br>
                                                        <a style="color:#464c9a;" href="{{url('user/invoice')}}/{{Crypt::encrypt($item->id)}}?type=download" target="_blank">DESCARGAR</a>
                                                    </td>
                                                    <td>
                                                        @if($item->status==1)
                                                            <span class="badge bg-success">Paid</span>
                                                        @elseif($item->status==0)
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($item->status==2)
                                                            <span class="badge bg-danger">Overdue</span>
                                                        @endif
                                                    </td>
                                                    <td>{{Carbon::parse($item->created_at)->format('Y-m-d')}}</td>
                                                </tr>
                                            @endforeach

                                          </tbody>
                                        </table>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .more-text {
            max-height: 0;  /* Initially hidden */
            overflow: hidden;
            transition: max-height 0.3s ease-out;  /* Smooth transition */
        }
    
        .more-text.expanded {
            max-height: 500px;  /* Enough to reveal the full content */
        }
    
        
    </style>
    

    @push('scripts')
    <script type="module">
        @foreach ($payment as $item)
            const toggleBtn{{$item->id}} = document.getElementById('toggle-btn-{{$item->id}}');
            const fullText{{$item->id}} = document.getElementById('full-text-{{$item->id}}');
            
            toggleBtn{{$item->id}}.addEventListener('click', function() {
                if (fullText{{$item->id}}.classList.contains('expanded')) {
                    fullText{{$item->id}}.classList.remove('expanded');
                    toggleBtn{{$item->id}}.textContent = 'More';
                } else {
                    fullText{{$item->id}}.classList.add('expanded');
                    toggleBtn{{$item->id}}.textContent = 'Less';
                }
            });
        @endforeach
    </script>
    
    @endpush

@endsection




