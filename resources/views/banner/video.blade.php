@extends('layouts.app')
@section('title', 'Video List')
@section('pagetitle', 'Video List')
@php
$table = "yes";
$agentfilter = "hide";
@endphp

@section('content')
<div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4 ">
                <div class="card-title mb-5">
                    <h5 class="mb-0">
                        <span>@yield('pagetitle')</span>
                    </h5>
                </div>
                <div class="col-sm-12 col-md-2 mb-5">
                    <div class="user-list-files d-flex float-right">
                        <button class="btn btn-success text-white ms-2" data-bs-toggle="offcanvas" data-bs-target="#frontslideModal">
                            <i class="ti ti-plus ti-xs"></i> Add Video</button>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Video</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>


<div class="offcanvas offcanvas-end" id="frontslideModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

            <div class="offcanvas-header text-center bg-primary">
                <div class="text-center ">
                    <h3 class="mb-2 text-white">Video Add</h3>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form class="dropzone" id="slideupload" action="{{route('storeVideo')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <span id="messageShow" style="color:red; font-weight:bold"></span>
                    <input type="text" name="title" value="Title" class="form-control" placeholder="Enter Title" />
                    <br />
                    <br />
              

                </form>
                <p>Info - Video size should be between 2-3 MB and format is MP4</p>
                </div>
       
</div>
@endsection


@push('script')
<script type="text/javascript" src="{{asset('')}}assets/js/core/dropzone.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "{{url('statement/fetch')}}/video/0";

        var onDraw = function() {
           
        };

        var options = [{
                "data": "id"
            },
            {
                "data": "title"
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == 'inactive') {
                        return `<span class="badge badge-danger">Inactive</span>`;
                    } else {
                        return `<span class="badge badge-success">Active</span>`;
                    }
                  
                }
            },
            {
                "data": "action",
                "className": "text-center",
                render: function(data, type, full, meta) {

                    return `<a href="{{asset('/banner/')}}/` + full.slides + `" target="_blank"><img src="{{asset('/banner/')}}/video.jpg" width="100px" height="50px"></a>`;
                }
            },
            {
                "data": "action",
                render: function(data, type, full, meta) {
                    return `<button type="button" class="btn btn-primary" onclick="deleteSlide('` + full.id + `')"> Status Change</button>`;
                }
            }
        ];
        datatableSetup(url, options, onDraw);

        Dropzone.options.slideupload = {
            paramName: "video", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            acceptedFiles: ".mp4,.gif",
            addRemoveLinks: true,
            timeout: 5000,

            complete: function(file) {
                this.removeFile(file);
            },
            success: function(file, data) {
                $('#datatable').dataTable().api().ajax.reload();
                if (data.status == "success") {
                    notify("Video Successfully Uploaded", 'success');
                } else {
                    $('#messageShow').text(data.errors['video'][0]);
                    //notify("Something went wrong, please try again.", 'warning');
                }
            }
        };
    });

    function deleteSlide(id) {
        $.ajax({
                url: '{{route("statementDelete")}}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "slide": id,
                    'type': 'video'
                },
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are status change',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                }
            })
            .success(function(data) {
                swal.close();
                $('#datatable').dataTable().api().ajax.reload();
                notify("Video status changed successfully", 'success');
            })
            .fail(function() {
                swal.close();
                notify('Somthing went wrong', 'warning');
            });
    }
</script>
@endpush