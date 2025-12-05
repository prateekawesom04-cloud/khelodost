@extends('admin.master')

@section('body')

    <div class="w-100 mx-auto p-4">
        @if(count($marketData))
        <!-- Bet History Section -->
        @if(count($MATCH_ODDS))
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Match_Odds</strong>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Selection</th>
                                <th>Exposure</th>
                                <th>Total Bets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($MATCH_ODDS as $row)
                                <tr>
                                    <td>{{$row->nat}}</td>
                                    <td>{{$row->exposure}}</td>
                                    <td>{{$row->totalBets}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        @endif
    
        <!-- Bet History Section -->
        @if(count($Bookmaker))
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Bookmaker</strong>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Selection</th>
                                <th>Exposure</th>
                                <th>Total Bets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Bookmaker as $row)
                                <tr>
                                    <td>{{$row->nat}}</td>
                                    <td>{{$row->exposure}}</td>
                                    <td>{{$row->totalBets}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        @endif
        
        <!-- Bet History Section -->
        @if(count($TIED_MATCH))
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>TIED_MATCH</strong>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Selection</th>
                                <th>Exposure</th>
                                <th>Total Bets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($TIED_MATCH as $row)
                                <tr>
                                    <td>{{$row->nat}}</td>
                                    <td>{{$row->exposure}}</td>
                                    <td>{{$row->totalBets}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        @endif
        
        <!-- Bet History Section -->
        @if(count($Normal))
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Normal</strong>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Selection</th>
                                <th>Exposure</th>
                                <th>Total Bets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Normal as $row)
                                <tr>
                                    <td>{{$row->nat}}</td>
                                    <td>{{$row->exposure}}</td>
                                    <td>{{$row->totalBets}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        @endif
        @else
        <div class="flex items-center justify-center">
            <h1 class="text-[24px] text-black">No Data Available</h1>
        </div>
        @endif

    </div>

<script>
    

</script>

@endsection