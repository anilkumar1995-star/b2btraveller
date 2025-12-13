@extends('layouts.app')
@section('title', "wallet to wallet Statement")
@section('pagetitle',  "wallet to wallet Statement")

@php
    $table = "yes";
    $export = "fund";
    $status['type'] = "Fund";
    $status['data'] = [
        "success" => "Success",
        "pending" => "Pending",
        "failed" => "Failed",
        "approved" => "Approved",
        "rejected" => "Rejected",
    ];


@endphp

@section('content')

<style>
    .swal2-shown{
        overflow-y: auto;
        z-index: 9999;
    }
</style>

     <div class="row mt-4">
        <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="card">
               <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                   
                    <h4 class="card-title">wallet to wallet statement</h4>
                      <div class="heading-elements">
                         
                       <button type="button" class="btn btn-primary" onclick="addSetup()"> Send Wallet 2 Wallet</button>
                    </div>
                </div>
                <div class="card-datatable table-responsive mt-5">
                <table class="table table-bordered table-striped table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Details</th>
                            <th>Sender Details</th>
                            <th>Refrence Details</th>
                            <th>Type</th>
                            <th>Amount</th>
                             <th>Closing Balance</th>
                            <th>Remark</th>
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

<div id="fundRequestModal" class="modal fade" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-slate">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h6 class="modal-title">Wallet Fund Request</h6>
            </div>
            <form id="fundRequestForm" action="{{route('fundtransaction')}}" method="post">
                <div class="modal-body">

                    <input type="hidden" name="user_id">
                    <input type="hidden" name="type", value="wallet2wallet">
                    {{ csrf_field() }}

                    <div class="row">
                         <div class="form-group col-md-6">
                            <label>Mobile</label>
                            <input type="number" class="form-control" name="mobile" placeholder="Enter Value" required="">
                             <small id="customername" class="badge rounded-pill bg-label-success"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter Value" required="">
                        </div>
                      </div>    
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label>Remark</label>
                            <input type="text" class="form-control" name="remark" placeholder="Enter Value" required="">
                            </div>
                        <div class="form-group col-md-6">
                            <label>T- PIN</label>
                            <input type="password" name="pin" class="form-control" placeholder="Enter transaction pin" required="">
                            <a href="{{url('profile/view?tab=pinChange')}}" target="_blank" class="text-primary pull-right">Generate or Forgot PIN?</a>
                        </div>
                    </div>
                  
                    <p class="text-danger">Note - If you want to change bank details, please send mail with account details to update your bank details.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary reportSmallBtnCustom m-0" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn bg-slate btn-raised legitRipple" type="submit" data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@push('style') 

@endpush

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        
          $("[name='mobile']").blur(function(){
           var number = $('[name="mobile"]').val();
        if(number != ''){
            $.ajax({
                url: '{{route("getmember")}}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {'mobile' : number},
                beforeSend : function(){
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching user details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
               success: function(data) {
                    swal.close();
                    console.log(data);
                    if(data.status == "success"){
                         $('#customername').text(data.data.name);
                    }else{
                          $('#customername').text(' ');
                       notify('Invalid Mobile number', 'warning');
                    }
                },
                error: function(errors) {
                 swal.close();
                  $('#customername').text(' ');
                notify('Somthing went wrong', 'warning');
                 }
            })
        }else{
            notify('Mobile number  field required', 'warning');
        }
        });

        var url = "{{url('statement/fetch')}}/wallet2walletstatement/0";
        var onDraw = function() {};
        var options = [
            { "data" : "name",
                render:function(data, type, full, meta){
                    return `<span class='text-inverse m-l-10'><b>`+full.id +`</b> </span><br>
                            <span style='font-size:13px'>`+full.updated_at+`</span>`;
                }
            },
            { "data" : "bank",
                render:function(data, type, full, meta){
                         return full.username;
                }
            },
             { "data" : "bank",
                render:function(data, type, full, meta){
                      if(full.product == "fund send"){
                            return full.option1 +`<br>` + full.phone;
                      }else{
                            return full.sendername;
                        
                      }
                        
                }
            },
            { "data" : "bank",
                render:function(data, type, full, meta){
                    if(full.product == "fund request"){
                        return `Name - `+full.fundbank.name+`<br>Account No. - `+full.fundbank.account+`<br>Ref - `+full.refno+`(`+full.product+`)`;
                    }else{
                        return full.refno+`<br>`+full.product;
                    }
                }
            },
            {"data":"trans_type"},
          { "data" : "amount",
                render:function(data, type, full, meta){
                      if(full.product == 'fund return')
                    {
                       return `<i class="text-danger">  `+ full.amount;   
                    }
                     return full.amount;
                }
            },
         { "data" : "bank",
                render:function(data, type, full, meta){
                    if(full.status == "pending" || full.status == "success" || full.status == "reversed" || full.status == "failed" || full.status == "refunded"){
                        if(full.trans_type == "credit"){
                            return `<i class="fa fa-inr"></i> `+ (parseFloat(full.balance) + parseFloat(parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit)));
                        }else if(full.trans_type == "debit"){
                            return `<i class="fa fa-inr"></i> `+ (parseFloat(full.balance) - parseFloat(parseFloat(full.amount) + parseFloat(full.charge) - parseFloat(full.profit)));
                        }
                    }else{
                        return `<i class="fa fa-inr"></i> `+full.balance;
                    }
                }
            }, 
            { "data" : "remark"},
            { "data" : "action",
                render:function(data, type, full, meta){
                    var out = '';
                    if(full.status == "approved" ||full.status == "success"){
                        out += `<label class="label label-success">`+full.status+`</label>`;
                    }else if(full.status == "pending"){
                        out += `<label class="label label-warning">Pending</label>`;
                    }else{
                        out += `<label class="label label-danger">`+full.status+`</label>`;
                    }

                    return out;
                }
            }
        ];

        datatableSetup(url, options, onDraw);
        
        
           $( "#fundRequestForm").validate({
            rules: {
                amount: {
                    required: true
                },
                type: {
                    required: true
                },
            },
            messages: {
                amount: {
                    required: "Please enter request amount",
                },
                type: {
                    required: "Please select request type",
                }
            },
            errorElement: "p",
            errorPlacement: function ( error, element ) {
                if ( element.prop("tagName").toLowerCase() === "select" ) {
                    error.insertAfter( element.closest( ".form-group" ).find(".select2") );
                } else {
                    error.insertAfter( element );
                }
            },
            submitHandler: function () {
                var form = $('#fundRequestForm');
                form.ajaxSubmit({
                    dataType:'json',
                 beforeSubmit: function() {
                    form.find('button[type="submit"]').html(
                        '<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Loading...'
                    ).attr(
                        'disabled', true).addClass('btn-secondary');
                },
                    complete: function () {
                         form[0].reset();
                        form.find('button[type="submit"]').html('Submit').attr(
                            'disabled', false).removeClass('btn-secondary');
                               $('#customername').text(' ');
                    },
                    success:function(data){
                        if(data.status == "success"){
                            form.closest('.modal').modal('hide');
                            notify("Amount send Successfull", 'success');
                            $('#datatable').dataTable().api().ajax.reload();
                        }else{
                            notify(data.status , 'warning');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
            }
        });
        
     
    });
    
 function addSetup() {
    $('#fundRequestModal').find('.msg').text("Add");
    $('#fundRequestModal').find('input[name="id"]').val("new");
    $('#fundRequestModal').modal('show');
}

</script>
@endpush