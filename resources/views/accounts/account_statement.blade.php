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

@php
$a = 0;
$b = 0;
$c = 0;
$d = 0;
$e = 0;
@endphp

<div class="flex items-center justify-between p-2 !bg-[#0552cc]">
  <h2 class="page-title !text-white m-0">Account Statement</h2>
  <a href="{{url()->current()}}" class="px-2 py-1 rounded-2 btn-submit !bg-[#0c0339]">Back</a>
</div>
<main class="layout-content-center !p-0">
    <div class="main-container">
      
      <div class="flex flex-row gap-2 items-center justify-start mt-3 mx-2 flex-wrap" id="statement_tabs" role="tablist">
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="1" id="flexCheckDefault" checked>
          <label for="flexCheckDefault" href="javascript:void(0)" class="active" data-bs-toggle="tab" data-bs-target="#all_transaction">
            All
          </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="2" id="flexCheckDefault2">
          <label for="flexCheckDefault2" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#transaction">
            Deposit/Withdraw
            </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="2" id="flexCheckDefault3">
          <label for="flexCheckDefault3" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#profit_loss">
            Profit/Loss
            </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="4 " id="flexCheckDefault4">
          <label for="flexCheckDefault4" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#bonusTransaction">
            Bonus
            </label>
        </div>
        <div class="!flex justify-center items-center gap-1">
          <input class="form-check-input !bg-[#000] checked:!bg-[#0552cc]" type="radio" name="filter" value="5" id="flexCheckDefault5">
          <label for="flexCheckDefault5" href="javascript:void(0)" data-bs-toggle="tab" data-bs-target="#sportTransaction">
            Sport
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

      <!-- Table Section -->
      <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="all_transaction" role="tabpanel">
            {{-- <h2 class="page-title">All</h2> --}}
            <div class="table-card">
              <div class="table-responsive">
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Balance</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach($allTransactions as $transaction)
                        @php
                          if($transaction->status==2){
                              if($transaction->payment_type){
                                  $available_balance = (int) $transaction->wallet_before - (int) $transaction->transfer_amount;
                              } else{
                                  $available_balance = (int) $transaction->wallet_before + (int) $transaction->transfer_amount;
                              }

                          } else{
                              $available_balance = (int) $transaction->wallet_before;
                          }
                        @endphp
                    <tr>
                      <td>{{$a+=1}}</td>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->remark}}</td>
                      <td>{{($transaction->payment_type)?'-':$transaction->transfer_amount}}</td>
                      <td>{{($transaction->payment_type)?$transaction->transfer_amount:'-'}}</td>
                      <td>{{$available_balance}}</td>
                      <td>{{($transaction->status==2)?'success':(($transaction->status==1)?'processing':'failed')}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
                <!-- No Records Message -->
                {{-- <div class="no-records">
                  No records found
                </div> --}}
              </div>
            </div>
              
          </div>
          
          <div class="tab-pane fade" id="transaction" role="tabpanel">
            {{-- <h2 class="page-title">Deposit & Withdraw</h2> --}}
            <div class="table-card">
              <div class="table-responsive">
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Balance</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach($transactions as $transaction)
                        @php
                          if($transaction->status==2){
                              if($transaction->payment_type){
                                  $available_balance = (int) $transaction->wallet_before - (int) $transaction->transfer_amount;
                              } else{
                                  $available_balance = (int) $transaction->wallet_before + (int) $transaction->transfer_amount;
                              }

                          } else{
                              $available_balance = (int) $transaction->wallet_before;
                          }
                        @endphp
                    <tr>
                      <td>{{$b+=1}}</td>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->remark}}</td>
                      <td>{{($transaction->payment_type)?'-':$transaction->transfer_amount}}</td>
                      <td>{{($transaction->payment_type)?$transaction->transfer_amount:'-'}}</td>
                      <td>{{$available_balance}}</td>
                      <td>{{($transaction->status==2)?'success':(($transaction->status==1)?'processing':'failed')}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
                <!-- No Records Message -->
              </div>
            </div>
              
          </div>

          <div class="tab-pane fade" id="profit_loss" role="tabpanel">
            {{-- <h2 class="page-title">Profit & Loss</h2> --}}
              
            <div class="table-card">
              <div class="table-responsive">
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      {{-- <th>Profit</th>
                      <th>Loss</th> --}}
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Balance</th>
                      {{-- <th>Balance</th> --}}
                      {{-- <th>Status</th> --}}
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach($plTransactions as $transaction)
                        {{-- @php
                          if($transaction->status==2){
                              if($transaction->payment_type){
                                  $available_balance = (int) $transaction->wallet_before - (int) $transaction->loss;
                              } else{
                                  $available_balance = (int) $transaction->wallet_before + (int) $transaction->profit;
                              }

                          } else{
                              $available_balance = (int) $transaction->wallet_before;
                          }
                        @endphp --}}
                    <tr>
                      <td>{{$c+=1}}</td>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->eventName}}</td>
                      <td class="text-success">{{($transaction->status)?$transaction->profit:'-'}}</td>
                      <td class="text-danger">{{($transaction->status==2)?'-':$transaction->loss}}</td>
                      {{-- <td>{{$available_balance}}</td> --}}
                      {{-- <td>{{($transaction->status==2)?'success':(($transaction->status==1)?'processing':'failed')}}</td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
                <!-- No Records Message -->
                {{-- <div class="no-records">
                  No records found
                </div> --}}
              </div>
            </div>
              
          </div>
          
          <div class="tab-pane fade" id="bonusTransaction" role="tabpanel">
            {{-- <h2 class="page-title">Bonus</h2> --}}
              
            <div class="table-card">
              <div class="table-responsive">
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Credit</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach($bonusTransaction as $transaction)
                        @php
                          
                                  $available_balance = (float) $transaction->wallet_before + (float) $transaction->transfer_amount;
                        @endphp
                    <tr>
                      <td>{{$d+=1}}</td>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->remark}}</td>
                      <td>{{$transaction->transfer_amount}}</td>
                      <td>{{$available_balance}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
              </div>
            </div>
              
          </div>
          
          <div class="tab-pane fade" id="sportTransaction" role="tabpanel">
            {{-- <h2 class="page-title">Sports</h2> --}}
              
            <div class="table-card">
              <div class="table-responsive">
                <table class="w-100">
                  <thead class="table-header !text-[#444] !bg-[#fff]">
                    <tr>
                      <th>S.No.</th>
                      <th>Sportname</th>
                      {{-- <th>Profit</th>
                      <th>Loss</th> --}}
                      <th>Credit</th>
                      <th>Debit</th>
                    </tr>
                  </thead>
                  <tbody class="table-body">
                    @foreach($bets as $transaction)
                    <tr>
                      <td>{{$e+=1}}</td>
                      <td>{{$transaction->sportname}}</td>
                      <td>{{$transaction->profit}}</td>
                      <td>{{$transaction->loss}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
              </div>
            </div>
              
          </div>
          
      </div>
    </div>

  <!-- Page Title -->
  {{-- <div class="account-title">Account Statement</div> --}}
{{-- 
  <div class="table-card">
    <div class="table-responsive">
      <table class="w-100">
        <thead class="table-header !text-[#444] !bg-[#fff]">
          <tr>
            <th>S.No.</th>
            <th>Date</th>
            <th>Description</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>From / To</th>
            <th>Balance</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="table-body">
          @foreach($transactions as $transaction)
              @php
                  $counter = 0;
                  if($transaction->status==2){
                      if($transaction->payment_type){
                          $available_balance = (int) $transaction->wallet_before - (int) $transaction->transfer_amount;
                      } else{
                          $available_balance = (int) $transaction->wallet_before + (int) $transaction->transfer_amount;
                      }

                  } else{
                      $available_balance = (int) $transaction->wallet_before;
                  }
              @endphp
          <tr>
            <td>{{$counter+=1}}</td>
            <td>{{$transaction->created_at}}</td>
            <td>{{$transaction->remark}}</td>
            <td>{{($transaction->payment_type==1)?$transaction->transfer_amount:'-'}}</td>
            <td>{{($transaction->payment_type)?'-':$transaction->transfer_amount}}</td>
            <td>{{$transaction->manual?'Admin -> User':'Deposit by User'}}</td>
            <td>{{$available_balance}}</td>
            <td>{{($transaction->status==2)?'success':(($transaction->status==1)?'processing':'failed')}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
      <!-- No Records Message -->
      <div class="no-records">
        No records found
      </div>
    </div>
  </div> --}}
</main>
@endsection