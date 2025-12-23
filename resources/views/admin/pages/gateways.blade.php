@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">

        <div class="card border border-primary">
            <div class="card-header bg-primary text-white p-2 rounded-top">
                <h4 class="mb-0">Add Method</h4>
            </div>

            <!-- Action Button -->
            <div class="card-body pb-0">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>S.No.</th>
                                <th>Gateway Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gateways as $key => $payment)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$payment->name}}</td>
                                <td>{{($payment->status)?'active':'inactive'}}</td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <label class="toggle-switch">
                                            <input class="statusInput" id="status_{{$payment->id}}" name="id" data-id="{{$payment->id}}" type="checkbox" {{$payment->status?'checked':''}} onchange="updateStatus(this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        $('.statusInput').on('change',function(){
            $(this).attr('disabled','disabled');
            callApi('post', `{{Route('admin.action.gatewayUpdate')}}`, {id:$(this).attr('data-id')}, ajaxResponseModal);
        });

    </script>
        @endsection
