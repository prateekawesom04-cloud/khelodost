@extends('admin.master')
@section('body')
    <div class="container-fluid">
        <div class="mobile-padding py-4">
            <div class="row g-4">
                <!-- Date Filter Card -->
                <!-- <div class="col-12">
                    <div class="card mb-2 shadow-sm border-0">
                        <div class="card-body">
                            <form class="row gy-3 gx-3">
                                <div class="col-6 col-md-3">
                                    <label for="fromDate" class="form-label">From Date:</label>
                                    <input type="text" id="fromDate" name="fromDate" class="form-control"
                                        value="2025-09-08T00:00" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label for="toDate" class="form-label">To Date:</label>
                                    <input type="text" id="toDate" name="toDate" class="form-control"
                                        value="2025-09-15T00:00" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <a type="submit" class="btn btn-primary w-100 mt-4">Submit</a>
                                </div>
                                <div class="col-6 col-md-3">
                                    <a type="reset" class="btn btn-danger w-100 mt-4">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->

                <!-- Stats Cards -->
                <div class="col-12">
                    <div class="row text-center g-3">
                        <div class="col-6 col-md-2">
                            <div class="bg-info text-white p-3 rounded shadow-sm">
                                <h6>P&L</h6>
                                <h5>{{$p_l}}</h5>
                            </div>
                        </div>
                        <!-- <div class="col-6 col-md-2">
                            <div class="bg-warning text-white p-3 rounded shadow-sm">
                                <h6>Commission</h6>
                                <h5>{{$userData->commission_amount}}</h5>
                            </div>
                        </div> -->
                        <div class="col-6 col-md-2">
                            <div class="bg-success text-white p-3 rounded shadow-sm">
                                <h6>Deposit</h6>
                                <h5>{{$userData->wallet_amount}}</h5>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="bg-danger text-white p-3 rounded shadow-sm">
                                <h6>Withdrawal</h6>
                                <h5>{{$userData->wallet_amount}}</h5>
                            </div>
                        </div>
                        {{-- <div class="col-6 col-md-2">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-success text-white fw-bold">
                                    <i class="fas fa-bolt me-2"></i>User Data
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="mb-3">Active User Data</h5>
                                    <canvas id="liveChart" class="w-100" style="max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-info text-white fw-bold">
                                    <i class="fas fa-database me-2"></i>Backup Sports Profit
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="mb-3">Last Backup Profit</h5>
                                    <canvas id="backupChart" class="w-100" style="max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div> --}}
                        <!-- <div class="col-6 col-md-2">
                            <div class="bg-primary text-white p-3 rounded shadow-sm">
                                <h6>Sport P&L</h6>
                                <h5>0</h5>
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Live Sports Profit Chart -->
                <div class="col-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-success text-white fw-bold" style="background: #28a745 !important;">
                            <i class="fas fa-bolt me-2"></i>User Data
                        </div>
                        <div class="card-body text-center">
                            <h5 class="mb-3">Active User Data</h5>
                            <canvas id="liveChart" class="w-100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Backup Sports Profit Chart -->
                <div class="col-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-info text-white fw-bold">
                            <i class="fas fa-database me-2"></i>Backup Sports Profit
                        </div>
                        <div class="card-body text-center">
                            <h5 class="mb-3">Last Backup Profit</h5>
                            <canvas id="backupChart" class="w-100"></canvas>
                        </div>
                    </div>
                </div>
                
                    <div class="container-fluid p-4">
                        
                        <div class="card shadow-sm border-0 !mb-5">
                            <div class="card-header text-white">
                                <strong>All Events</strong>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                {{-- <th>Exposure</th> --}}
                                                <th>Date</th>
                                                <th>Status</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($allEvents->count() > 0)
                                                @foreach($allEvents as $row)
                                                    <tr>
                                                        <td>{{$row->eventId}}</td>
                                                        <td>{{$row->eventName}}</td>
                                                        {{-- <td>{{$row->exposure}}</td> --}}
                                                        <td>{{$row->eventDate}}</td>
                                                        @php
                                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                                        @endphp
                                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                                        {{-- <td>
                                                            <div class="flex flex-row items-center justify-evenly">
                                                                <div>
                                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-target="#sattleEvent"></i>
                                                                </div>

                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10" class="text-white text-center">No data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 !mb-5">
                            <div class="card-header text-white">
                                <strong>Cricket</strong>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                <th>Exposure</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($cricketEvents->count() > 0)
                                                @foreach($cricketEvents as $row)
                                                    <tr>
                                                        <td>{{$row->eventId}}</td>
                                                        <td>{{$row->eventName}}</td>
                                                        <td>{{$row->exposure}}</td>
                                                        <td>{{$row->eventDate}}</td>
                                                        @php
                                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                                        @endphp
                                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                                        {{-- <td>
                                                            <div class="flex flex-row items-center justify-evenly">
                                                                <div>
                                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-target="#sattleEvent"></i>
                                                                </div>

                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10" class="text-white text-center">No data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 !mb-5">
                            <div class="card-header text-white">
                                <strong>Soccer</strong>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                <th>Exposure</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($footballEvents->count() > 0)
                                                @foreach($footballEvents as $row)
                                                    <tr>
                                                        <td>{{$row->eventId}}</td>
                                                        <td>{{$row->eventName}}</td>
                                                        <td>{{$row->exposure}}</td>
                                                        <td>{{$row->eventDate}}</td>
                                                        @php
                                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                                        @endphp
                                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                                        {{-- <td>
                                                            <div class="flex flex-row items-center justify-evenly">
                                                                <div>
                                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-target="#sattleEvent"></i>
                                                                </div>

                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10" class="text-white text-center">No data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 !mb-5">
                            <div class="card-header text-white">
                                <strong>Tennis</strong>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                <th>Exposure</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($tennisEvents->count() > 0)
                                                @foreach($tennisEvents as $row)
                                                    <tr>
                                                        <td>{{$row->eventId}}</td>
                                                        <td>{{$row->eventName}}</td>
                                                        <td>{{$row->exposure}}</td>
                                                        <td>{{$row->eventDate}}</td>
                                                        @php
                                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                                        @endphp
                                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                                        {{-- <td>
                                                            <div class="flex flex-row items-center justify-evenly">
                                                                <div>
                                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-target="#sattleEvent"></i>
                                                                </div>

                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10" class="text-white text-center">No data!</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        // Chart.js code
        const charts = [{
                id: 'liveChart',
                value: {{ $user }},
                color: '#28a745'
            },
            {
                id: 'backupChart',
                value: 8765,
                color: '#17a2b8'
            }
        ];

        charts.forEach(chart => {
            const ctx = document.getElementById(chart.id).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Profit', 'Remaining'],
                    datasets: [{
                        data: [chart.value, {{ $userTotal }} - chart.value],
                        backgroundColor: [chart.color, '#e0e0e0'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
