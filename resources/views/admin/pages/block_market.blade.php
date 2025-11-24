@extends('admin.master')

@section('body')
<div class="container-fluid p-4">
    <div class="card shadow-lg rounded bg-white">
        <div class="card-header bg-primary text-white p-2">
            <h4 class="mb-0">Block Market</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th class="col-2">Status</th>
                            <th class="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($markets))
                            @foreach($markets as $market)
                        <tr>
                            <td>{{$market->name}}</td>
                            <td class="status"><span class="badge {{$market->status?'bg-success':'bg-danger'}} text-white">{{$market->status?'Active':''}}</span></td>
                            <td>
                                <label class="toggle-switch">
                                    <input data-name="{{$market->name}}" type="checkbox" {{$market->status?'checked':''}} onchange="updateStatus(this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </td>
                        </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $('input').on('change',function(){
        $(this).attr('disabled','disabled');
        callApi('post', `{{Route('admin.action.block_market')}}`, {name:$(this).attr('data-name')}, ajaxResponseModal);
    });
    
</script>
@endsection
