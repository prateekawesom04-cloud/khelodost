@extends('admin.master')

@section('body')
<div class="container-fluid p-4">
    <div class="card shadow rounded bg-white" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-primary text-white p-2 rounded-top">
            <h4 class="mb-0">Add Number</h4>
        </div>
        <form class="px-4">
            <!-- Banner Table Section -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Mobile</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Edit</th>
                        <!-- <th scope="col">Delete</th> -->
                    </tr>
                </thead>
                <tbody id="bannerTableBody">
                    <tr>
                        <td>{{$userData->phone}}</td>
                        <td>{{$userData->username}}</td>
                        <td><a href="#" class="btn btn-warning btn-sm px-3 py-1"data-bs-toggle="modal"
                                        data-bs-target="#editMobileModal"data-bs-placement="top" title="Edit">✍️</a></td>
                        <!-- <td>
                         <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"data-bs-placement="top" title="Delete">🗑️</a></td> -->
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
    $('.updatePhone').click(function(){
        // $(this).addClass('disabled');
        let formData = new FormData($('#editMobileForm')[0]);
        callAjaxFormData('post','{{route("updatePhone")}}',formData,ajaxResponse1);
    });
    
</script>

@endsection
