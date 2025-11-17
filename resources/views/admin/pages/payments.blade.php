@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">

        <div class="card border border-primary">
            <div class="card-header bg-primary text-white p-2 rounded-top">
                <h4 class="mb-0">Add Method</h4>
            </div>

            <!-- Action Button -->
            <div class="card-body pb-0">
                <div class="text-end mb-3">
                    <a href="#"class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#mainModal">Add Method</a>
                </div>

                </a>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Holder Name</th>
                                <th>UPI ID / Account No / USDT Wallet Address</th>
                                <th>IFSC Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->payment_method}}</td>
                                <td>{{$payment->holder_name}}</td>
                                <td>
                                    @if(str_contains($payment->payment_method_uid, 'img'))
                                    <img src="{{asset('storage').$payment->payment_method_uid}}" alt="" srcset="" class="w-15">
                                    @else
                                    {{$payment->payment_method_uid}}
                                    @endif
                                </td>
                                <td>{{$payment->ifsc_code}}</td>
                                <td>{{($payment->status)?'active':'inactive'}}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                        <a class="btn btn-sm btn-outline-danger" title="Delete">🗑️</a>
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
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
        @endsection
