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
                <h2 class="page-title">Live Game Bet History</h2>
                <div class="table-card">
                    <div class="scroll-container">
                        @if(count($bets))
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    {{-- <th>S.No.</th> --}}
                                    <th>Date</th>
                                    <th>Game</th>
                                    <th>Event Id</th>
                                    <th>Details</th>
                                    <th>Selection</th>
                                    <th>Bet Type</th>
                                    <th>Type</th>
                                    <th>Bhaw</th>
                                    <th>Stake</th>
                                    <th>P&L</th>
                                    <th>Loss</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach ($bets as $transaction)
                                <tr>
                                    {{-- <td>{{$a+=1}}</td> --}}
                                    <td>{{$transaction->created_at}}</td>
                                    <td>{{$transaction->sportname}}</td>
                                    <td>{{$transaction->eventId}}</td>
                                    <td>{{$transaction->eventName}}/{{$transaction->mname}}/{{$transaction->nat}}</td>
                                    <td>{{$transaction->nat}}</td>
                                    <td>{{$transaction->betOn?'Lay':'Back'}}</td>
                                    <td>{{$transaction->gtype}}</td>
                                    <td>{{$transaction->oddVal}}</td>
                                    <td>{{$transaction->bet_amount}}</td>
                                    <td class="{{$transaction->profit>0?'text-success':'text-danger'}}">{{$transaction->profit}}</td>
                                    <td>{{($transaction->status==0)?'--':(($transaction->status==1)?'0':$transaction->bet_amount)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="no-records py-3 text-center">
                        No records found
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</main>
@endsection