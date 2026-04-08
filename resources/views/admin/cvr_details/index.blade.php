@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">CVR Details</div>
                        
                        <div class="user-body">
                            <form method="GET" action="{{ route('admin.cvrDetails') }}">
                                <div class="row mb-3 align-items-end">

                                    {{-- From Date --}}
                                    <div class="col-md-3">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ request('from_date') }}">
                                    </div>

                                    {{-- To Date --}}
                                    <div class="col-md-3">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ request('to_date') }}">
                                    </div>

                                    {{-- Visitor Name --}}
                                    <div class="col-md-3">
                                        <label>Visitor Name</label>
                                        <input type="text" name="visitor_name" class="form-control"
                                            placeholder="Search visitor..."
                                            value="{{ request('visitor_name') }}">
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="col-md-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary w-50">
                                            Search
                                        </button>

                                        <a href="{{ route('admin.cvrDetails') }}" class="btn btn-secondary w-50">
                                            Reset
                                        </a>

                                        {{-- Excel Download --}}
                                        <a href="{{ route('admin.export', request()->all()) }}"
                                        class="btn btn-success">
                                            Excel
                                        </a>
                                    </div>

                                </div>
                            </form>
                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Visit Date</th>
                                                    <th>Visitor Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Dealer</th>
                                                    <th>Distributor</th>
                                                    <th>Location</th>
                                                    
                                                    <th>Summary</th>
                                                    <th>Sentiment</th>
                                                    <th>Complaints</th>
                                                    <th>Action Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cvr_details as $item)
                                                    @php
                                                        $data = $item->cvr_data;

                                                        $date = '';
                                                        $time = '';

                                                        if (!empty($data['date'])) {
                                                            $dt = \Carbon\Carbon::parse($data['date'])->setTimezone('Asia/Kolkata');
                                                            $date = $dt->format('d-m-Y');
                                                            $time = $dt->format('h:i A');
                                                        }
                                                    @endphp

                                                    <tr>

                                                        {{-- Visitor --}}
                                                        <td>{{ $date }} {{ $time }}</td>
                                                        <td>{{ $data['visitorName'] ?? '' }}</td>

                                                        {{-- Dealer Info --}}
                                                        <td>{{ $data['dealer']['customerName'] ?? '' }}</td>
                                                        <td>{{ $data['dealer']['customerPhone'] ?? '' }}</td>
                                                        <td>{{ $data['dealer']['name'] ?? '' }}</td>
                                                        <td>{{ $data['dealer']['distributorName'] ?? '' }}</td>
                                                        <td>{{ $data['dealer']['locationName'] ?? '' }}</td>

                                                        {{-- Date Time --}}
                                                        

                                                        {{-- Summary --}}
                                                        <td>{{ $data['summary'] ?? '' }}</td>

                                                        {{-- Sentiment --}}
                                                        <td>{{ $data['sentiment'] ?? '' }}</td>

                                                        {{-- Complaints --}}
                                                        <td>
                                                            @if(!empty($data['complaints']))
                                                                <ul>
                                                                    @foreach($data['complaints'] as $comp)
                                                                        <li>
                                                                            {{ $comp['category'] }} <br>
                                                                            {{ $comp['description'] }} <br>
                                                                            <b>{{ $comp['severity'] }}</b>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>

                                                        {{-- Action Points --}}
                                                        <td>
                                                            @if(!empty($data['actionPoints']))
                                                                <ul>
                                                                    @foreach($data['actionPoints'] as $ap)
                                                                        <li>
                                                                            <b>{{ $ap['task'] }}</b><br>
                                                                            Owner: {{ $ap['owner'] }}<br>
                                                                            Deadline: {{ $ap['deadline'] }}<br>
                                                                            Priority: {{ $ap['priority'] }}<br>
                                                                            Status: {{ $ap['status'] }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-3">
                                            {{ $cvr_details->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
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
