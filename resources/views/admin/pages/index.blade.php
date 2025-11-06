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
                
                    <div class="container-fluid py-4">

                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event ID</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        {{-- <th>Description</th> --}}
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($events->count() > 0)
                                        @foreach($events as $row)
                                            <tr>
                                                <td>{{$row->eventId}}</td>
                                                <td>{{$row->eventName}}</td>
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

                        {{-- <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header text-white">
                                <strong>Events</strong>
                            </div>
                            <div class="card-body">


                                <div class="d-flex flex-wrap flex-nowrap align-items-center mb-3">
                                    <div class="d-flex align-items-center me-3 flex-shrink-0">
                                        <label class="me-2 mb-0" for="show-entries">Show</label>
                                        <select id="show-entries" class="form-select w-auto">
                                            <option>10</option>
                                            <option>25</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>

                                    <div class="d-flex align-items-center ms-auto flex-grow-1">
                                        <label class="me-2 mb-0" for="search">Search:</label>
                                        <input type="search" id="search" class="form-control form-control-sm border border-primary"
                                            style="max-width: 250px;">
                                    </div>
                                    <div class="col-6 col-lg-3 px-2">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#sattleEvent">Create Bonus</a>
                                    </div>
                                    <div class="col-6 col-lg-3 px-2">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#assignBonusModal">Update Event</a>
                                    </div>
                                </div>

                                
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
                                    <div class="small text-white mb-2 mb-md-0">Showing 1 to 10 of 0 entries</div>
                                    <nav>
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled"><a class="page-link">First</a></li>
                                            <li class="page-item disabled"><a class="page-link">Previous</a></li>
                                            <li class="page-item disabled"><a class="page-link">Next</a></li>
                                            <li class="page-item disabled"><a class="page-link">Last</a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                        </div> --}}
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
