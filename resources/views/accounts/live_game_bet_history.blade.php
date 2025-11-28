@extends('sports_master')

@section('sports_body')
<style>
  .account-title {
    color: #0c9971;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
  }

  .filter-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
  }

  .date-input {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px 15px;
    font-size: 14px;
    background: white;
  }

  .btn-submit {
    background-color: #0c9971;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 25px;
    font-weight: 600;
    font-size: 14px;
  }

  .btn-reset {
    background-color: #e9ecef;
    color: #666;
    border: none;
    border-radius: 6px;
    padding: 10px 25px;
    font-weight: 600;
    font-size: 14px;
  }

  .table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .table-responsive table {
    min-width: 600px;
    border-collapse: collapse;
  }
  
  .table-body {
    background: white;
  }
  
  .table-body td {
    padding: 15px;
    text-align: center;
    border: 1px solid #ddd;
    font-size: 14px;
    min-width: max-content;
  }

  .table-header {
    background-color: #0c9971;
    color: white;
    font-weight: 600;
    font-size: 14px;
  }

  .table-header th {
    padding: 15px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.2);
    min-width: max-content;
  }

  .no-records {
    text-align: center;
    color: #999;
    font-style: italic;
    padding: 40px;
    font-size: 16px;
  }

  .pagination-arrow {
    color: #999;
    font-size: 18px;
    cursor: pointer;
  }
  
  .date-row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
  }
  
  .date-row .date-input {
    flex: 1;
  }
  
  .button-row {
    display: flex;
    gap: 10px;
  }
  
  .button-row button {
    flex: 1;
  }
  
  .page-title{color:#0c9971;font-size:20px;font-weight:600;margin-bottom:10px}

  @media (max-width: 768px) {
    .filter-card {
      padding: 20px;
    }
    
    .filter-responsive .d-flex {
      flex-direction: column;
    }
    
    .account-title {
      font-size: 20px;
    }

    .page-title{font-size:18px;text-align:start}
  }
</style>

<div class="flex items-center justify-between p-2 !bg-[#0552cc]">
  <h2 class="page-title !text-white m-0">Live Game Bet History</h2>
  <a href="{{url()->current()}}" class="px-2 py-1 rounded-2 btn-submit !bg-[#0c0339]">Back</a>
</div>
<main class="layout-content-center !p-0">
    <div class="main-container">

        <!-- Filter Section -->
        <div class="filter-card my-2 !p-2">
            <div class="filter-responsive">
            <div class="date-row">
                <div class="input-group date" id="datetimepicker">
                <input type="text" class="date-input datetimepicker form-control" name="iTime" value="{{date('Y-m-d h:m')}}" />
                <span class="input-group-text">
                    <i class="bi bi-calendar"></i> 
                </span>
                </div>
                <div class="input-group date" id="datetimepicker">
                <input type="text" class="date-input datetimepicker form-control" name="eTime" value="{{date('Y-m-d h:m')}}" />
                <span class="input-group-text">
                    <i class="bi bi-calendar"></i> 
                </span>
                </div>
            </div>
            <div class="flex flex-row gap-2 items-center">
                <div class="input-group !w-1/2" id="datetimepicker">
                <input type="text" class="date-input form-control" name="search" placeholder="search..." />
                <span class="input-group-text">
                    <i class="bi bi-search"></i> 
                </span>
                </div>
                <div class="button-row flex flex-row gap-2 items-center !w-1/2">
                <button class="btn-submit">Filter</button>
                <button class="btn-reset">Clear</button>
                </div>
            </div>
            </div>
        </div>
        <div class="tab-content mt-3">
            
            <div class="tab-pane fade show active" id="profit_loss" role="tabpanel">
                {{-- <h2 class="page-title">Live Game Bet History</h2> --}}
                <div class="table-card">
                    <div class="table-responsive">
                        @if(count($bets))
                        <table class="w-100">
                            <thead class="table-header !text-[#444] !bg-[#fff]">
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
                                    {{-- <th>Loss</th> --}}
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
                                    <td>
                                        <span class="text-success">{{$transaction->profit}}</span>/<span class="text-danger">{{$transaction->bet_amount}}</span>
                                    </td>
                                    {{-- <td>{{($transaction->status==0)?'--':(($transaction->status==1)?'0':$transaction->bet_amount)}}</td> --}}
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