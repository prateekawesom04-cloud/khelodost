@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">

        <!-- Filter Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-3">
                            <label for="choose-type" class="form-label">Choose Type</label>
                            <select id="choose-type" class="form-select form-select-sm">
                                <option>Settle</option>
                                <option>UnSettle</option>
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <label for="choose-sport" class="form-label">Choose Sport</label>
                            <select id="choose-sport" class="form-select form-select-sm">
                                <option>Cricket</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <label for="fromDate" class="form-label">From Date:</label>
                            <input type="text" id="fromDate" name="fromDate" class="form-control"
                                value="2025-09-08T00:00" />
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <label for="toDate" class="form-label">To Date:</label>
                            <input type="text" id="toDate" name="toDate" class="form-control"
                                value="2025-09-15T00:00" />
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <label class="form-label d-block">&nbsp;</label>
                            <a type="submit" class="btn btn-primary w-100 btn-sm">Get History</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bet History Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Bet History</strong>
            </div>
            <div class="card-body">

                <!-- Table Controls -->
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
                </div>

                <!-- Bet History Table -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>User Name</th>
                                {{-- <th>Sport Name</th> --}}
                                <th>BetId</th>
                                <th>EventId</th>
                                {{-- <th>Market</th>
                                <th>Selection</th>
                                <th>Type</th> --}}
                                <th>Odds</th>
                                <th>Bet Amount</th>
                                <th>Profit/Loss</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bets->count() > 0)
                                @foreach ($bets as $bet)
                                    <tr>
                                        <td class="">{{ $bet->username ?? 'N/A' }}</td>
                                        <td class="">{{ $bet->betId }}</td>
                                        <td class="">{{ $bet->eventId }}</td>
                                        <td class="">{{ $bet->oddVal }}</td>
                                        {{-- <td class="">{{ $bet->stakeValue }}</td> --}}
                                        <td class="">{{ $bet->bet_amount }}</td>
                                        <td class="">{{ $bet->profit ?? 'N/A'}}</td>
                                        <td class="">
                                            @if($bet->status == 0)
                                                Unsettled
                                                {{-- <span class="">Unsettled</span> --}}
                                            @elseif($bet->status == 1)
                                                <span class="text-success">Won</span>
                                            @elseif($bet->status == 2)
                                                <span class="text-danger">Lost</span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="">No data!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
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
        </div>
    </div>
@endsection
