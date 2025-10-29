@extends('admin.master')
@section('body')
    <div class="container-fluid p-4">
        <div class="pl-body px-2 ">

            <!-- Filter Card -->
            <div class="card pl-card border border-primary p-1 mb-4">
                <div class="pl-header"></div>
                <form>
                    <div class="row g-3 align-items-end">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label for="data-source" class="form-label">Data Source</label>
                                <form class="filter_data">
                                    @csrf
                                    <input type="hidden" name="username" value="{{$userData->username}}">
                                    <select name="filter_type" class="form-control bg-dark text-white border-secondary filter_type">
                                        <option value="0">Deposit</option>
                                        {{-- <option value="1">Withdrawal</option>
                                        @foreach($providers as $provider)
                                        <option value="{{$provider->provider}}">{{$provider->provider}}</option>
                                        @endforeach --}}
                                    </select>
                                </form>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label for="fromDate" class="form-label">From Date:</label>
                            <input type="text" id="fromDate" name="fromDate" class="form-control"
                                value="2025-09-08T00:00" />
                        </div>

                        <div class="col-6 col-md-4 col-lg-1">
                            <label for="from-time" class="form-label">Time</label>
                            <input type="time" id="from-time" class="form-control form-control-sm" value="00:00">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label for="toDate" class="form-label">To Date:</label>
                            <input type="text" id="toDate" name="toDate" class="form-control"
                                value="2025-09-15T00:00" />
                        </div>
                        <div class="col-6 col-md-4 col-lg-1">
                            <label for="to-time" class="form-label">Time</label>
                            <input type="time" id="to-time" class="form-control form-control-sm" value="23:59">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a type="submit" class="btn btn-primary w-100 btn-sm">Get P&L</a>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Table + Controls Card -->
            <div class="card pl-card p-1">
                <div class="pl-header text-center bg-primary text-white py-1 rounded">Profit & Loss Table</div>
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

                <!-- Table -->
                <div class="table-responsive table_div">
                    {{-- <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sport Name</th>
                                <th>Upline Profit/Loss</th>
                                <th>Downline Profit/Loss</th>
                                <th>Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cricket</td>
                                <td>+5000</td>
                                <td>-3000</td>
                                <td>500</td>
                            </tr>
                            <tr>
                                <td>Football</td>
                                <td>-1000</td>
                                <td>+2000</td>
                                <td>300</td>
                            </tr>
                            <tr>
                                <td>Tennis</td>
                                <td>+800</td>
                                <td>-500</td>
                                <td>100</td>
                            </tr>
                            </tr>
                        </tbody>
                    </table> --}}
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>Showing 1 to 10 of 0 entries</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">First</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">Last</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    
    let form = $('.filter_type').parents('form');
    let formData = new FormData(form[0]);
    
    $(document).ready(function(){
        callAjaxFormData('post', `{{url('/admin')}}/userStatments`, formData, transactionList);
    });

</script>
@endsection
