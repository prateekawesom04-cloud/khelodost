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
  <h2 class="page-title !text-white m-0">Referral Users</h2>
  <a href="{{url()->previous()}}" class="px-2 py-1 rounded-2 btn-submit !bg-[#0c0339]">Back</a>
</div>
<div class="flex items-center justify-between mt-2 p-2 !bg-[#0552cc]">
  <h4 class="page-title !text-white m-0">Referral Link</h4>
  <div class="clipboard !text-white">{{route('user.referral_code',$userData->referral_code)}}</div>
</div>
<main class="layout-content-center !p-0">
    <div class="main-container">

        <div class="tab-content mt-3">
            
            <div class="tab-pane fade show active" id="profit_loss" role="tabpanel">
                {{-- <h2 class="page-title">Referral Users</h2> --}}
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="w-100">
                            <thead class="table-header !text-[#444] !bg-[#fff]">
                                <tr>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-nowrap">User Name</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @if(count($referrals))
                                    @foreach($referrals as $transaction)
                                    <tr>
                                        <td>{{$transaction->created_at}}</td>
                                        <td>{{$transaction->username}}</td>
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
<script>
  $('.clipboard').on('click',function(){
     navigator.clipboard.writeText($(this).text());
     responseToast('Referral link copied to clipboard','bg-success');
  });
</script>
@endsection