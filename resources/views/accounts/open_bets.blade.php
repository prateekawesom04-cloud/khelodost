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

  .w-100 {
    overflow-x: auto;
  }

  .w-100 table {
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
  {{-- 
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]"> !text-white m-0">Account Statement</h2> --}}
  <a href="{{url()->current()}}" class="px-2 py-1 rounded-2 btn-submit !bg-[#0c0339]">Back</a>
</div>
<main class="layout-content-center !p-0">

    <div class="main-container">
      <div class="flex flex-row gap-2 items-center justify-start mt-3 mx-2" id="statement_tabs" role="tablist">
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="1" id="flexCheckDefault" checked>
          <label for="flexCheckDefault" href="javascript:void(0)" class="active" data-bs-toggle="tab" data-bs-target="#all_transaction">
            All Bets
          </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="2" id="flexCheckDefault2">
          <label for="flexCheckDefault2" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#transaction">
            Open Bets
            </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="2" id="flexCheckDefault3">
          <label for="flexCheckDefault3" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#profit_loss">
            Sattled Bets
            </label>
        </div>
          {{-- <a href="javascript:void(0)" class="!flex justify-center items-center btn btn-success fw-semibold px-4 rounded-2 btn-submit" data-bs-toggle="tab" data-bs-target="#transaction">Deposit/Withdraw</a>
          <a href="javascript:void(0)" class="!flex justify-center items-center btn btn-success fw-semibold px-4 rounded-2 btn-submit" data-bs-toggle="tab" data-bs-target="#profit_loss">Profit/Loss</a>
          <a href="javascript:void(0)" class="!flex justify-center items-center btn btn-success fw-semibold px-4 rounded-2 btn-submit" data-bs-toggle="tab" data-bs-target="#bonusTransaction">Bonus</a>
          <a href="javascript:void(0)" class="!flex justify-center items-center btn btn-success fw-semibold px-4 rounded-2 btn-submit" data-bs-toggle="tab" data-bs-target="#sportTransaction">Sport</a> --}}
          {{-- <a href="javascript:void(0)" class="!flex justify-center items-center btn btn-success fw-semibold px-4 rounded-2 btn-submit" data-bs-toggle="tab" data-bs-target="#activity">Activity</a> --}}
      </div>
        
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

      {{-- <div class="flex items-center justify-center gap-2">
        <a href="{{ route('user.betlist','cricket') }}" class="px-3 py-1 !bg-[#0c0339] text-white">Cricket</a>
        <a href="{{ route('user.betlist','soccer') }}" class="px-3 py-1 !bg-[#0c0339] text-white">Soccer</a>
        <a href="{{ route('user.betlist','tennis') }}" class="px-3 py-1 !bg-[#0c0339] text-white">Tennis</a>
      </div> --}}

@php
$a = 0;
$b = 0;
$c = 0;
$d = 0;
@endphp
      <!-- Table Section -->
      <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="all_transaction" role="tabpanel">
            {{-- 
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">">All Bets</h2> --}}
            <div class="table-card">
              <div class="table-responsive">
                @if($bets->count() > 0)
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Selection</th>
                      <th>Type</th>
                      <th>Bhaw</th>
                      <th>Amount</th>
                      <th>Profit</th>
                      <th>Loss</th>
                      <th>BetType</th>
                      <th>ID</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                      @foreach ($bets as $transaction)
                      <tr>
                        <td>{{$a+=1}}</td>
                        <td>{{$transaction->created_at}}</td>
                        <td>{{$transaction->sportname}}/{{$transaction->eventName}}/{{$transaction->mname}}</td>
                        <td>{{$transaction->nat}}</td>
                        <td>{{$transaction->betOn?'Lay':'Back'}}</td>
                        <td>{{$transaction->oddVal}}</td>
                        <td>{{$transaction->bet_amount}}</td>
                        <td class="text-success">{{$transaction->profit}}</td>
                        <td class="text-danger">{{($transaction->status==0)?'--':(($transaction->status==1)?'0':$transaction->bet_amount)}}</td>
                        <td>{{$transaction->gtype}}</td>
                        <td>{{$transaction->betId}}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                
                <!-- No Records Message -->
                      @else
                <div class="no-records py-3 text-center">
                  No records found
                </div>
                    @endif
              </div>
            </div>
              
          </div>
          
          <div class="tab-pane fade" id="transaction" role="tabpanel">
            {{-- 
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">">Open Bets</h2> --}}
            <div class="table-card">
              <div class="table-responsive">
                @if($openBets->count() > 0)
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Selection</th>
                      <th>Type</th>
                      <th>Bhaw</th>
                      <th>Amount</th>
                      <th>Profit</th>
                      <th>BetType</th>
                      <th>ID</th>
                      {{-- <th>Loss</th> --}}
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach ($openBets as $transaction)
                    <tr>
                      <td>{{$a+=1}}</td>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->sportname}}/{{$transaction->eventName}}/{{$transaction->mname}}</td>
                      <td>{{$transaction->nat}}</td>
                      <td>{{$transaction->betOn?'Lay':'Back'}}</td>
                      <td>{{$transaction->oddVal}}</td>
                      <td>{{$transaction->bet_amount}}</td>
                      <td>{{$transaction->profit}}</td>
                      <td>{{$transaction->gtype}}</td>
                      <td>{{$transaction->betId}}</td>
                      {{-- <td>{{($transaction->status==0)?'--':(($transaction->status==1)?'0':$transaction->bet_amount)}}</td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @else
                
                <!-- No Records Message -->
                <div class="no-records py-3 text-center">
                  No records found
                </div>
                @endif
              </div>
            </div>
              
          </div>

          <div class="tab-pane fade" id="profit_loss" role="tabpanel">
            {{-- 
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">">Sattled Bets</h2> --}}
              
            <div class="table-card">
              <div class="table-responsive">
                @if($sattledBets->count() > 0)
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Selection</th>
                      <th>Type</th>
                      <th>Bhaw</th>
                      <th>Amount</th>
                      <th>Profit</th>
                      <th>Loss</th>
                      <th>BetType</th>
                      <th>ID</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                      @foreach ($sattledBets as $transaction)
                      <tr>
                        <td>{{$b+=1}}</td>
                        <td>{{$transaction->created_at}}</td>
                        <td>{{$transaction->sportname}}/{{$transaction->eventName}}/{{$transaction->mname}}</td>
                        <td>{{$transaction->nat}}</td>
                        <td>{{$transaction->betOn?'Lay':'Back'}}</td>
                        <td>{{$transaction->oddVal}}</td>
                        <td>{{$transaction->bet_amount}}</td>
                        <td class="text-success">{{$transaction->profit}}</td>
                        <td class="text-danger">{{($transaction->status==0)?'--':(($transaction->status==1)?'0':$transaction->bet_amount)}}</td>
                        <td>{{$transaction->gtype}}</td>
                        <td>{{$transaction->betId}}</td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                  
                  <!-- No Records Message -->
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

  <!-- Session Section -->
  {{-- <div class="section-card">
        
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">">Bets</h2>
    
    <div class="w-100">
      <table>
        <thead class="table-header !text-[#444] !bg-[#fff]">
          <tr>
            <th>Sport Name</th>
            <th>BetId</th>
            <th>EventId</th>
            <th>Market</th>
            <th>Selection</th>
            <th>Type</th>
            <th>Odds</th>
            <th>Bet Amount</th>
            <th>Profit/Loss</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="table-body">
            @if($bets->count() > 0)
                  @foreach ($bets as $bet)
                      <tr>
                          <td class="">{{ $bet->username ?? 'N/A' }}</td>
                          <td class="">{{ $bet->betId }}</td>
                          <td class="">{{ $bet->eventId }}</td>
                          <td class="">{{ $bet->oddVal }}</td>
                          <td class="">{{ $bet->stakeValue }}</td>
                          <td class="">{{ $bet->bet_amount }}</td>
                          <td class="">{{ $bet->profit ?? 'N/A'}}</td>
                          <td class="">
                              @if($bet->status == 0)
                                  Unsettled
                                  <span class="">Unsettled</span>
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
      
      @if(!$bets->count())
      <div class="no-data">
        <div class="no-data-icon">📄</div>
        <div>No data</div>
      </div>
      @endif
    </div>
  </div> --}}
</main>
@endsection