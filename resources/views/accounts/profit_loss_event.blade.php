@extends('sports_master')

@section('sports_body')
<style>
    .main-container{background:#e9ecef;min-height:100vh;padding:30px}
    .page-title{color:#0c9971;font-size:20px;font-weight:600;margin-bottom:10px}
    .form-card{background:white;border-radius:10px;padding:30px;box-shadow:0 2px 4px rgba(0,0,0,0.1);margin-bottom:20px}
    .form-row{margin-bottom:20px}
    .form-control,.form-select{height:50px;border:2px solid #ced4da;border-radius:5px;font-size:14px}
    .btn-submit{background:#0c9971;color:white;border:none;height:50px;border-radius:5px;font-weight:500;width:100%}
    .btn-reset{background:#929292;color:white;border:none;height:50px;border-radius:5px;font-weight:500;width:100%}
    .table-card{background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 4px rgba(0,0,0,0.1)}
    .table-header{background:#0c9971;color:white}
    .table-header th{padding:18px 15px;font-weight:500;border:none;text-align:center;white-space:nowrap;min-width:120px}
    .table-body td{padding:15px;border-bottom:1px solid #dee2e6;text-align:center;white-space:nowrap;min-width:120px}
    .scroll-container{overflow-x:auto;-webkit-overflow-scrolling:touch}
    .data-table{width:100%;margin:0;border-collapse:collapse;min-width:800px}
    @media(max-width:768px){
        .main-container{padding:15px}.form-card{padding:20px}.page-title{font-size:18px;text-align:center}
        .form-row{margin-bottom:15px}.form-control,.form-select,.btn-submit,.btn-reset{height:45px}
        .table-header th,.table-body td{padding:12px 8px;font-size:13px;min-width:100px}.data-table{min-width:600px}
    }
    @media(max-width:480px){
        .main-container{padding:10px}.form-card{padding:15px}.page-title{font-size:16px}
        .form-control,.form-select,.btn-submit,.btn-reset{height:40px;font-size:13px}
        .table-header th,.table-body td{padding:10px 6px;font-size:12px;min-width:80px}
    }
</style>

<main class="layout-content-center p-3">
    <div class="main-container">

        <div class="tab-content mt-3">
            
            <div class="tab-pane fade show active" id="profit_loss" role="tabpanel">
                <h2 class="page-title">Profit & Loss By Event Markets</h2>
                <div class="table-card">
                    <div class="scroll-container">
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">Event Name</th>
                                    <th class="text-nowrap">Profit</th>
                                    <th class="text-nowrap">Loss</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @if(count($bets))
                                    @foreach($bets as $transaction)
                                    <tr>
                                        <td>{{$transaction->created_at}}</td>
                                        <td>{{$transaction->eventName}}</td>
                                        <td class="text-success">{{$transaction->profit}}</td>
                                        <td class="text-danger">{{$transaction->loss}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            {{-- <div class="tab-pane fade show active" id="profit_loss" role="tabpanel">
                <h2 class="page-title">Profit & Loss By Event Markets</h2>
                <div class="form-card">
                    <form>
                        <div class="row form-row">
                            <div class="col-12">
                                <select class="form-select">
                                    <option selected>ALL</option>
                                    <option value="1">D & W</option>
                                    <option value="2">WCO</option>
                                    <option value="3">Sports</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="col-6">
                                <input type="date" class="form-control" value="2025-08-27">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" value="2025-09-27">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn-submit">Submit</button>
                            </div>
                            <div class="col-6">
                                <button type="reset" class="btn-reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-card">
                    <div class="scroll-container">
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    <th class="text-nowrap">Sportname</th>
                                    <th class="text-nowrap">Event Name</th>
                                    <th class="text-nowrap">Market name</th>
                                    <th class="text-nowrap">Result</th>
                                    <th class="text-nowrap">Profit/Loss</th>
                                    <th class="text-nowrap">Total Balance</th>
                                    <th class="text-nowrap">Settle Time</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @if(count($sportbookBets))
                                    @foreach($sportbookBets as $transaction)
                                    <tr>
                                        <td>{{$transaction->sportname}}</td>
                                        <td>{{$transaction->eventName}}</td>
                                        <td>{{$transaction->mname}}</td>
                                        <td>{{$transaction->nat}}</td>
                                        <td class="{{($transaction->status==2)? 'text-danger' : 'text-success'}}">{{$transaction->profit}}</td>
                                        <td>{{$transaction->wallet_before}}</td>
                                        <td class="text-success fw-bold text-nowrap">{{$transaction->status? $transaction->updated_at : 'Unsattled'}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div> --}}
            
            {{--             
            <div class="tab-pane fade" id="activity" role="tabpanel">
                <h2 class="page-title">Activity Log</h2>
                <div class="table-card">
                    <div class="scroll-container">
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    <th class="text-nowrap">Login Date & Time</th>
                                    <th class="text-nowrap">IP</th>
                                    <th class="text-nowrap">City/State/Country</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach($activities as $activity)
                                <tr>
                                    <td class="text-nowrap">{{$activity->created_at}}</td>
                                    <td>{{$activity->ip}}</td>
                                    <td class="text-success fw-bold text-nowrap">Patna</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div> 
            --}}
        </div>
    </div>

</main>
@endsection