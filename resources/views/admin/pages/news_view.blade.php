@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">
        <div class="card shadow rounded bg-white" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-primary text-white p-2 rounded-top">
                <h4 class="mb-0">Add News</h4>
            </div>
            <form class="px-4">
                <!-- Add Message Button on the right side -->
                <div class="d-flex justify-content-end mb-3 p-2">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMessageModal">
                        Add News
                    </a>
                </div>

                <!-- News Table below the Add Message button -->
                <div class="mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Message Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $newses)
                            <tr>
                                <td>{{$newses->news}}</td>
                                <td><a href="#" data-news_id="{{$newses->news_id}}" class="btn btn-warning btn-sm px-3 py-1 news_edit"data-bs-toggle="modal"
                                        data-bs-target="#editNewsModal{{$newses->news_id}}" data-bs-placement="top" title="Edit">
                                        ✍️
                                    </a></td>
                                <td> <a href="#" class="btn-sm px-3 py-1 btn-btn-danger delete_news" data-news_id="{{$newses->news_id}}" data-bs-placement="top"
                                        title="Delete">🗑️</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')

<script>
    $('.add_news').on('click',function(){
        
        let formData = new FormData($(this).parents('form')[0]);
        
        callAjaxFormData('post', `{{url('/admin')}}/update_news`, formData, ajaxResponseModal);
    });
    
    // $('.news_edit').on('click',function(){

    // });

    $('.delete_news').on('click',function(){
        let formData = new FormData();
        formData.append('news_id',$(this).attr('data-news_id'));
        callAjaxFormData('post', `{{url('/admin')}}/delete_news`, formData, ajaxResponseModal);
    });
    
    $('.update_news').on('click',function(){
        let formData = new FormData($(this).parents('form')[0]);
        formData.append('news_id',$(this).attr('data-news_id'));
        callAjaxFormData('post', `{{url('/admin')}}/update_news`, formData, ajaxResponseModal);
    });
</script>

@endsection
