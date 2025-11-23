@extends('admin.master')

@section('body')
<div class="container-fluid p-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">User General Setting</h5>
        </div>
        <div class="card-body">
            <h6 class="mb-3">Cricket</h6>
            <form method="POST" action="{{route('admin.action.user_general_setting')}}">
                @csrf
                <div class="row mb-3">
                    <div class="col-12 col-md-4">
                        <label for="min_stake" class="form-label">Min Stake:</label>
                        <input type="text" class="form-control" name="min_stake" id="min_stake" value="{{isset($UserGeneralSetting->min_stake)?$UserGeneralSetting->min_stake:''}}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="max_stake" class="form-label">Max Stake:</label>
                        <input type="text" class="form-control" name="max_stake" id="max_stake" value="{{isset($UserGeneralSetting->max_stake)?$UserGeneralSetting->max_stake:''}}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="bet_delay" class="form-label">Bet Delay:</label>
                        <input type="text" class="form-control" name="bet_delay" id="bet_delay" value="{{isset($UserGeneralSetting->bet_delay)?$UserGeneralSetting->bet_delay:''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-4">
                        <label for="min_odds" class="form-label">Min Odds:</label>
                        <input type="text" class="form-control" name="min_odds" id="min_odds" value="{{isset($UserGeneralSetting->min_odds)?$UserGeneralSetting->min_odds:''}}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="max_odds" class="form-label">Max Odds:</label>
                        <input type="text" class="form-control" name="max_odds" id="max_odds" value="{{isset($UserGeneralSetting->max_odds)?$UserGeneralSetting->max_odds:''}}">
                    </div>
                </div>

                <!-- Checkboxes -->
                {{-- <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="unmatch_bet" id="unmatch_bet" value="{{isset($UserGeneralSetting->unmatch_bet)?$UserGeneralSetting->unmatch_bet:''}}">
                            <label class="form-check-label" for="unmatch_bet">Unmatch Bet</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lock_bet" id="lock_bet" value="{{isset($UserGeneralSetting->lock_bet)?$UserGeneralSetting->lock_bet:''}}">
                            <label class="form-check-label" for="lock_bet">Lock Bet</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="match_odds" id="match_odds" value="{{isset($UserGeneralSetting->match_odds)?$UserGeneralSetting->match_odds:''}}">
                            <label class="form-check-label" for="match_odds">Match Odds</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="update_all_users" id="update_all_users" value="{{isset($UserGeneralSetting->update_all_users)?$UserGeneralSetting->update_all_users:''}}">
                            <label class="form-check-label" for="update_all_users">Click to update for all users</label>
                        </div>
                    </div>
                </div> --}}

                <div class="text-end">
                    <a type="submit" class="btn btn-primary user_general_setting">Update</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('js')

<script>
    $('.user_general_setting').click(function(){
        // $(this).addClass('disabled');
        let formData = new FormData($('form')[0]);
        callAjaxFormData('post','{{route('admin.action.user_general_setting')}}',formData,ajaxResponse);
    });

    
</script>

@endsection