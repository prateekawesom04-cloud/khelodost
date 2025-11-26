@extends('sports_master')

@section('sports_body')
<style>
  .open-bets-header {
    background-color: #2888ef;
    /* background-color: #0c9971; */
    color: white;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    font-weight: 600;
    font-size: 16px;
  }

  .section-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 15px;
    overflow: hidden;
  }

  .section-label {
    background-color: #f8f9fa;
    padding: 8px 15px;
    font-size: 14px;
    font-weight: 500;
    color: #666;
    border-bottom: 1px solid #e9ecef;
  }

  .table-header {
    background-color: white;
    border-bottom: 2px solid #e9ecef;
  }

  .table-header th {
    padding: 12px 8px;
    font-size: 13px;
    font-weight: 600;
    /* color: #333; */
    text-align: left;
    border-right: 1px solid #e9ecef;
  }

  .no-data {
    text-align: center;
    padding: 60px 20px;
    color: #999;
  }

  .no-data-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 15px;
    border: 2px solid #ddd;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #ddd;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .table-responsive table {
    min-width: 700px;
    width: 100%;
    border-collapse: collapse;
  }
    .main-container{background:#e9ecef;min-height:100vh;padding:30px}
    .page-title{color:#0c9971;font-size:20px;font-weight:600;margin-bottom:20px}
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
  <!-- Open Bets Section -->
  <div class="section-card">
        <h2 class="page-title">Open Bets</h2>
    
    {{-- <div class="section-label">Match Odds</div> --}}
    
    <div class="table-responsive">
      <table>
        <thead class="table-header">
          <tr>
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
        <tbody class="table-body">
            @if($openBets->count() > 0)
                  @foreach ($openBets as $bet)
                      <tr>
                          {{-- <td class="">{{ $bet->username ?? 'N/A' }}</td> --}}
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
      
      @if(!$bets->count())
      <div class="no-data">
        <div class="no-data-icon">📄</div>
        <div>No data</div>
      </div>
      @endif
    </div>
  </div>

  <!-- Session Section -->
  <div class="section-card">
        <h2 class="page-title">Bets</h2>
    {{-- <div class="section-label">Bets</div> --}}
    
    <div class="table-responsive">
      <table>
        <thead class="table-header">
          <tr>
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
        <tbody class="table-body">
            @if($bets->count() > 0)
                  @foreach ($bets as $bet)
                      <tr>
                          {{-- <td class="">{{ $bet->username ?? 'N/A' }}</td> --}}
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
      
      @if(!$bets->count())
      <div class="no-data">
        <div class="no-data-icon">📄</div>
        <div>No data</div>
      </div>
      @endif
    </div>
  </div>
</main>
@endsection