@extends('admin.master')

@section('body')

    <div class="flex flex-col justify-center items-center">
        <h4 class="my-1 border-b border-gray-300">Settlement Page</h4>
        <h4 class="mt-2 mb-1">{{$eventId}}</h4>
        <div class="">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" />
                <label class="form-check-label" for="inlineRadio1">Win</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                <label class="form-check-label" for="inlineRadio2">Loss</label>
            </div>
        </div>
    </div>
@endsection