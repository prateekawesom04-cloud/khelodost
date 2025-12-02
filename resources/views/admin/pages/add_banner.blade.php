@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">
        <div class="card shadow rounded bg-white" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-primary text-white p-2 rounded-top">
                <h4 class="mb-0">Add Banner</h4>
            </div>
            <form class="px-4">
                <!-- Add Banner Button Section (Aligned to the right) -->
                <div class="d-flex justify-content-end p-2 mb-3">
                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                        Add Banner
                    </a>
                </div>

                <!-- Banner Table Section -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bannerTableBody">
                        @if(count($banners))
                            @foreach($banners as $banner)
                        <tr>
                            <td>
                                <img src="{{asset('storage').$banner->image}}" alt="" srcset="" class="w-15">
                            </td>
                            <td class="status"><span class="badge {{$banner->status?'bg-success':'bg-danger'}} text-white">{{$banner->status?'Active':''}}</span></td>
                            <td>
                                <a href="#" data-id="{{$banner->id}}" class="btn btn-warning btn-sm px-3 py-1 news_edit"data-bs-toggle="modal"
                                    data-bs-target="#bannerUpdateImage{{$banner->id}}" data-bs-placement="top" title="Edit">
                                    ✍️
                                </a>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-2">
                                    <label class="toggle-switch">
                                        <input class="statusInput" id="status_{{$banner->id}}" name="id" data-id="{{$banner->id}}" type="checkbox" {{$banner->status?'checked':''}} onchange="updateStatus(this)">
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <a href="#" class="btn-sm px-3 py-1 btn-btn-danger deleteBanner" data-id="{{$banner->id}}" data-bs-placement="top" title="Delete">🗑️</a>
                                </div>
                            </td>
                        </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </form>
        </div>
    </div>

<script>

    $('.statusInput').on('change',function(){
        $(this).attr('disabled','disabled');
        callApi('post', `{{Route('admin.action.bannerUpdate')}}`, {id:$(this).attr('data-id')}, ajaxResponseModal);
    });
    
    $('.deleteBanner').on('click',function(){
        $(this).attr('disabled','disabled');
        callApi('post', `{{Route('admin.action.deleteBanner')}}`, {id:$(this).attr('data-id')}, ajaxResponseModal);
    });
    
</script>

@endsection


