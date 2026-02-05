@extends('layouts.app')
@section('title', "Van List")
@section('pagetitle', "Van List")

@php
$table = "yes";
@endphp

@section('content')
  <style>
        .select2-container {
            border: 1px solid silver;
            border-radius: 4px;
        }

        .select2-dropdown {
            background: white !important;
        }
    </style>
 
 <div class="row mt-4">
    <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
          

            <div class="card-header bg-label-warning pb-0 d-flex justify-content-between position-relative align-items-center">
                <div class="card-title">
                    <h5 class="mb-0">
                        <span>@yield('pagetitle')</span>
                    </h5>
                </div>

                <div>
                    <button type="button" class="btn btn-success mb-3" onclick="addVan()">
                        Create Virtual Account
                   </button>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <table width="100%" class="table border-top mb-5" id="datatable" role="grid" aria-describedby="user-list-page-info">
                    <thead class=" text-center bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Created By</th>
                            <th>Label</th>
                            <th>Virtual A/C No. </th>
                            <th>IFSC </th>
                            <th>VPA Address </th>
                            <th>QR Code </th>
                            <th>Status </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
    <div class="modal" id="vanModalCreate" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Virtual Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>

                <form id="vanFormCreate" action="{{ route('generate') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="bank_id">
                    <input type="hidden" name="id">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="modal-body">

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Label : <b class="text-danger">*</b></label>
                                <input type="text" name="label" class="form-control" required
                                    placeholder="Enter Label "><span class="text-danger error-label"
                                    id="error-label"></span>
                            </div>


                            <div class="col-md-6">
                                <label>Virtual Account Number:<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span style="background-color:#f0f0f0" class="input-group-text">111222</span>
                                    <input required type="number" name="van_number" class="form-control"
                                        placeholder="Enter 8 to 10 Virtual Account Number">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label>VPA Address:<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" required name="vpa_address" class="form-control"
                                        placeholder="Enter 8 to 10 Character VPA Address">
                                    <span style="background-color:#f0f0f0" class="input-group-text">@yesbank</span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label>Auto Deductive Date:</label>
                                <input type="date" name="auto_deductive_date" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label>Phone Number:</label>
                                <input type="number" name="mobile_number" class="form-control" maxlength="10"
                                    placeholder="Enter 10 digit Mobile Number">
                            </div>

                            <div class="col-md-12">
                                <label>Description:</label>
                                <textarea placeholder="Enter Description" class="form-control" name="description" id=""></textarea>
                            </div>
                        </div><br>
                    

                        <div class="" id="">
                            <div class="border p-3 mb-3">

                                <b> Transaction Amount Limit :</b><br>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label>IMPS: <span class="text-danger">*</span></label>
                                        <input required type="number" name="imps" class="form-control"
                                            placeholder="Less Than 5 Lack" value="200000">
                                    </div>
                                    <div class="col-md-3">
                                        <label>NEFT:<span class="text-danger">*</span></label>
                                        <input required type="number" name="neft" class="form-control"
                                            placeholder="Less Than 5 Lack" value="200000">
                                    </div>
                                    <div class="col-md-3">
                                        <label>RTGS:<span class="text-danger">*</span></label>
                                        <input type="number" required name="rtgs" class="form-control"
                                            placeholder="Greater Than 2 Lack" value="300000">
                                    </div>
                                    <div class="col-md-3">
                                        <label>UDF 1:</label>
                                        <input type="number" name="udf_1" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>UDF 2:</label>
                                        <input type="number" name="udf_2" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>UDF 3:</label>
                                        <input type="number" name="udf_3" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>UDF 4:</label>
                                        <input type="number" name="udf_4" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>UDF 5:</label>
                                        <input type="number" name="udf_5" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer py-0 mt-2">
                            <button class="btn btn-success" type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('style')
  
@endpush

@push('script')
    <script type="text/javascript">
        $("#setupManager").validate({
            rules: {
                type: {
                    required: true,
                }
            },
            messages: {
                type: {
                    required: "Please select Type",
                }
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.closest(".form-group").find(".select2"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function() {
                var form = $('#setupManager');
                var id = form.find('[name="id"]').val();

                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]')
                            .html('Please wait...')
                            .attr('disabled', true)
                            .addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]')
                            .html('Submit')
                            .attr('disabled', false)
                            .removeClass('btn-secondary');
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status === "success") {
                            form[0].reset();
                            notify(data?.message || "Bank Added Successfully",
                                'success');
                            form.closest('.offcanvas').offcanvas('hide');
                            $('#datatable').dataTable().api().ajax.reload();
                        } else if (data.status === 500 || data.status === "500") {
                            notify(data?.message || "Account already exists",
                                'warning');
                        } else {
                            notify(data?.message || "Something went wrong", 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            showError(xhr.responseJSON.errors, form);
                        } else {
                            notify("An unexpected error occurred.", 'error');
                        }
                    }
                });
            }

        });
        $("#vanForm").validate({
            submitHandler: function() {
                var form = $('form#vanForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            $('#datatable').dataTable().api().ajax.reload();
                            notify("VAN Updated", 'success');
                            $('#vanModal').modal('hide');
                        } else {
                            notify(data.status, 'error');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        notify(errors?.responseJSON?.message ||
                            "Something went wrong",
                            'error');
                    }
                });
            }
        });

      function editVan(id, user_id, account_id, label, virtual_account_number, vpa_address, authorized_remitters) {
    $('#vanModal').find('[name="id"]').val(id);
    $('#vanModal').find('[name="user_id"]').val(user_id);
    $('#vanModal').find('[name="account_id"]').val(account_id);
    $('#vanModal').find('[name="label"]').val(label);
    $('#vanModal').find('[name="van_number"]').val(virtual_account_number);
    $('#vanModal').find('[name="vpa_address"]').val(vpa_address);

    // authorized_remitters is JSON string, parse it to array
    let authAccounts = [];
    try {
        authAccounts = JSON.parse(authorized_remitters).map(a => a.account_number);
    } catch(e) { console.warn(e); }

    $('#vanModal').find('[name="authorize_account[]"]').val(authAccounts).trigger('change');

    $('#vanModal').modal('show');
}

        $(document).ready(function() {

            $('#multi').select2({
            placeholder: "Select Authorized Accounts", 
            width: '100%',
            allowClear: true
        });

           $("#vanFormCreate").validate({
                ignore: [], 
                errorClass: 'text-danger',
                errorElement: 'div',   
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                 
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    var $form = $(form);
                    $form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            $form.find('button:submit')
                                .html('Please wait...')
                                .attr('disabled', true)
                                .addClass('btn-secondary');
                        },
                        success: function(response) {
                            swal.close();
                            $form.find('button:submit')
                                .html('Submit')
                                .attr('disabled', false)
                                .removeClass('btn-secondary');

                            if (typeof response.status === 'boolean') {
                                let message = typeof response.message === 'object' ? response.message.message : response.message;
                                notify(message, response.status ? 'success' : 'error');
                                return;
                            }

                            if (response.status === "SUCCESS" || response.status === "success") {
                                notify(response.message, 'success');
                                $('#datatable').DataTable().ajax.reload();
                                $form[0].reset();
                                $('#vanModalCreate').modal('hide');
                            } else if (response.status === "FAILURE") {
                                let failureMessage = response.data?.message || response.message || 'An error occurred';
                                notify(failureMessage, 'error');
                            } else {
                                notify("Unexpected response: " + JSON.stringify(response), 'warning');
                            }
                        },
                        error: function(err) {
                            swal.close();
                            $form.find('button:submit')
                                .html('Submit')
                                .attr('disabled', false)
                                .removeClass('btn-secondary');

                            let errMsg = err?.responseJSON?.message || 'Something went wrong while processing your request.';
                            notify(errMsg, 'error');
                        }
                    });
                }
            });


            var url = "{{ url('statement/fetch') }}/vanlist/0";

            var onDraw = function() {
                $('[data-popup="tooltip"]').tooltip();
                $('[data-popup="popover"]').popover({
                    template: '<div class="popover border-teal-400"><div class="arrow"></div><h3 class="popover-title bg-teal-400"></h3><div class="popover-content"></div></div>'
                });
            };

            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${full?.id}<br/>${full?.created_at}</span>`;
                    }
                },
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        if (!full?.user) {
                            return `<span>N/A</span>`;
                        }
                        return `<span>${full?.user?.name}<br>${full?.user?.agentcode}</span>`;
                    }
                },
                
                {
                    "data": "user_id",
                    render: function(data, type, full, meta) {
                        return `<span>${full?.label}</span>`;
                    }
                },

                {
                    "data": "account_number",
                    render: function(data, type, full, meta) {
                        return `<span> ${full?.virtual_account_number}</span>`;
                    }
                },

                {
                    "data": "is_verify",
                    render: function(data, type, full, meta) {
                        return `${full.ifsc}`;
                    }
                },
                {
                    "data": "is_verify",
                    render: function(data, type, full, meta) {
                        return `${full.vpa_address}`;
                    }
                },
                {
                    "data": "qr_code_url_pdf",
                    render: function(data, type, full, meta) {
                        if (data) {
                            return `
                <a href="${data}" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" 
                         width="40" title="Download PDF" alt="PDF" />
                </a>`;
                        }
                        return `<span>No QR PDF</span>`;
                    }
                },
                {
                    "data": "is_verify",
                    render: function(data, type, full, meta) {
                        const status = full?.status === '1';
                        if (status) {
                            return `<span class="btn btn-sm btn-success ">Active</span>`;
                        } else {
                            return `<span class="btn btn-sm btn-danger ">In Active</span>`;
                        }
                    }
                },
                {
                    "data": "is_verify",
                    render: function(data, type, full, meta) {
                        let out = '';
                        @if (\Myhelper::hasRole('retailer') || \Myhelper::hasRole('admin') )
                            out += `
                                <span class="btn m-1 btn-sm btn-danger cursor-pointer" 
                                    onclick="ChangeStatusVan('${full?.account_id}')">
                               <i class="ti ti-arrows-exchange" title="Status Update"></i>
                                </span>`;
                        @else
                            out += `N/A`;
                        @endif
                        return out;
                    }
                },

            ];

            datatableSetup(url, options, onDraw, '#datatable', {
                searching: true,
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    width: '80px',
                    targets: [0]
                }]
            });

        });

         function ChangeStatusVan(account_id) {

            swal({
                title: "Are you sure?",
                text: "You want to Status Update this virtual account?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Change Status !",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed || result.value) {
                        swal({
                        title: "Please wait...",
                        text: "Changing Status...",
                        allowOutsideClick: false,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "/payment/vandelete/" + account_id,
                        type: "post",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {

                            if (res.status === "SUCCESS" && res.statusCode ==="0x0200") {
                                swal("Changed!", res.message, "success");

                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                swal("Error!", res.message, "error");
                            }
                        },
                        error: function(xhr) {
                            swal("Error!", xhr?.responseJSON?.message || "Something went wrong", "error");
                        }
                    });
                }
            });
        }


        function addVan() {
            // $('#vanFormCreate').find('[name="bank_id"]').val(id);

            $('#vanModalCreate').modal('show');
        }
    </script>
@endpush

