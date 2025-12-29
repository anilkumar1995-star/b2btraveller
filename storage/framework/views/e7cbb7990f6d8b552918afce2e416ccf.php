<!DOCTYPE html>

<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light-style layout-navbar-fixed layout-menu-fixed"
    dir="ltr" data-theme="theme-default" data-assets-path="<?php echo e(asset('theme_1/assets')); ?>/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(Auth::user()->company->companyname); ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://ipayments.in/assets/images/ilogo.png"
        class=" img-fluid rounded" />

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <style>
        .datepicker.datepicker-dropdown.dropdown-menu {
            top: 280px;
            left: 488px;
            display: block;
            z-index: 9999;
            padding: 25px;
        }

        .datepicker.datepicker-dropdown.dropdown-menu table tr td {
            padding: 5px !important;
        }

        table.dataTable .form-check-size .form-check-input {
            width: 35px;
            height: 17px;
        }
    </style>

    <?php echo $__env->yieldPushContent('style'); ?>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/tabler-icons.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/fonts/flag-icons.css')); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/rtl/core.css?v=1.0.0')); ?>"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/rtl/theme-default.css?v=1.0.0')); ?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/css/demo.css')); ?>" />

    <!-- Vendors CSS -->

    
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')); ?>" />
    
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.css')); ?>" />
    
    
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(asset('theme_1/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />
    
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/libs/flatpickr/flatpickr.css')); ?>" />
    
    
    <link rel="stylesheet"
        href="<?php echo e(asset('theme_1/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')); ?>" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('theme_1/assets/vendor/css/pages/cards-advance.css')); ?>" />
    <!-- Helpers -->
    <script src="<?php echo e(asset('theme_1/assets/vendor/js/helpers.js')); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo e(asset('theme_1/assets/js/config.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    



    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/sweetalert2.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/jquery.form.min.js"></script>
    <script src="<?php echo e(asset('')); ?>theme/js/jquery.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    
    
    

    <?php if(isset($table) && $table == 'yes'): ?>
        <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <?php endif; ?>

    <?php if(env('MAINTENANCE_MODE', false)): ?>
        <?php echo e(Artisan::call('down')); ?>

    <?php endif; ?>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.select').select2();

            $('#profileImg').hover(function() {
                $('span.changePic').show('400');
            });

            $('.changePic').hover(function() {
                $('span.changePic').show('400');
            }, function() {
                $('span.changePic').hide('400');
            });

            $(document).ready(function() {
                $(".sidebar-default a").each(function() {
                    if (this.href == window.location.href) {
                        $(this).addClass("active");
                        $(this).parent().addClass("active");
                        $(this).parent().parent().prev().addClass("active");
                        $(this).parent().parent().prev().click();
                    }
                });
            });

            $('#reportExport').click(function() {
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                const day = String(currentDate.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate = `${year}-${month}-${day}`;

                var type = $(this).attr('product');
                var fromdate = $('#searchForm').find('input[name="from_date"]').val() || formattedDate;
                var todate = $('#searchForm').find('input[name="to_date"]').val() || formattedDate;
                var searchtext = $('#searchForm').find('input[name="searchtext"]').val();
                var agent = $('#searchForm').find('input[name="agent"]').val();
                var status = $('#searchForm').find('[name="status"]').val();
                var product = $('#searchForm').find('[name="product"]').val();

                <?php if(isset($id)): ?>
                    agent = "<?php echo e($id); ?>";
                <?php endif; ?>

                const currentDate1 = new Date(fromdate);
                const year1 = currentDate1.getFullYear();
                const month1 = String(currentDate1.getMonth() + 1).padStart(2,
                    '0'); // Months are zero-based
                const day1 = String(currentDate1.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate1 = `${year1}-${month1}-${day1}`;

                const currentDate2 = new Date(todate);
                const year2 = currentDate2.getFullYear();
                const month2 = String(currentDate2.getMonth() + 1).padStart(2,
                    '0'); // Months are zero-based
                const day2 = String(currentDate2.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate2 = `${year2}-${month2}-${day2}`;

                window.location.href = "<?php echo e(url('statement/export')); ?>/" + type + "?fromdate=" +
                    formattedDate1 +
                    "&todate=" + formattedDate2 + "&searchtext=" + searchtext + "&agent=" + agent +
                    "&status=" +
                    status + "&product=" + product;
            });

            // Dropzone.options.profileupload = {
            //     paramName: "profiles", // The name that will be used to transfer the file
            //     maxFilesize: .5, // MB
            //     complete: function(file) {
            //         this.removeFile(file);
            //     },
            //     success: function(file, data) {
            //         console.log(file);
            //         if (data.status == "success") {
            //             $('#profileImg').removeAttr('src');
            //             $('#profileImg').attr('src', file.dataURL);
            //             notify("Profile Successfully Uploaded", 'success');
            //         } else {
            //             notify("Something went wrong, please try again.", 'warning');
            //         }
            //     }
            // };

            $('.mydate').datepicker({
                'autoclose': true,
                'clearBtn': true,
                'todayHighlight': true,
                'format': 'mm/dd/yyyy'
            });

            $('input[name="from_date"]').datepicker("setDate", getPrevious(new Date(), 0));
            $('input[name="to_date"]').datepicker('setEndDate', getPrevious(new Date(), 0));

            $('input[name="to_date"]').datepicker().on('changeDate', function(e) {
                $('input[name="from_date"]').datepicker('setEndDate', $('input[name="to_date"]').val());
            });

            $('input[name="to_date"]').focus(function() {
                if ($('input[name="from_date"]').val().length == 0) {
                    $('input[name="to_date"]').datepicker('hide');
                    $('input[name="from_date"]').focus();
                }
            });


            $('#formReset').click(function() {
                $('form#searchForm')[0].reset();
                $('form#searchForm').find('[name="from_date"]').datepicker().datepicker("setDate",
                    getPrevious(new Date(), 0));
                $('form#searchForm').find('[name="to_date"]').datepicker().datepicker("setDate",
                    getPrevious(new Date(), 0));
                $('form#searchForm').find('select').val(null).trigger('change')
                $('#formReset').find('button[type="submit"]').html('loading');
                $('#datatable').dataTable().api().ajax.reload();
            });

            $('form#searchForm').submit(function() {
                var fromdate = $(this).find('input[name="from_date"]').val();
                var todate = $(this).find('input[name="to_date"]').val();
                if (fromdate.length != 0 || todate.length != 0) {
                    $('#datatable').dataTable().api().ajax.reload();
                }
                return false;
            });


            $(".navigation-menu a").each(function() {
                alert();
            });

            $('select').change(function(event) {
                var ele = $(this);
                if (ele.val() != '') {
                    $(this).closest('div.form-group').find('p.error').remove();
                }
            });

            $(".modal").on('hidden.bs.modal', function() {
                if ($(this).find('form').length) {
                    $(this).find('form')[0].reset();
                }

                if ($(this).find('.select').length) {
                    $(this).find('.select').val(null).trigger('change');
                }
            });

            $("#walletLoadForm").validate({
                rules: {
                    amount: {
                        required: true,
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },
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
                    var form = $('#walletLoadForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('loading..').attr('disabled',
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status) {
                                form[0].reset();
                                getbalance();
                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Wallet successfully loaded", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                            notify('Something went wrong', 'error');
                        }
                    });
                }
            });

            $("#notifyForm").validate({
                rules: {
                    amount: {
                        required: true,
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },
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
                    var form = $('#notifyForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled',
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status) {
                                form[0].reset();
                                getbalance();
                                form.closest('.modal').modal('hide');
                                notify("Send successfully", 'success');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                            notify('Something went wrong', 'error');
                        }
                    });
                }
            });

            // $("#complaintForm").validate({
            //     rules: {
            //         subject: {
            //             required: true,
            //         },
            //         description: {
            //             required: true,
            //         }
            //     },
            //     messages: {
            //         subject: {
            //             required: "Please select subject",
            //         },
            //         description: {
            //             required: "Please enter your description",
            //         },
            //     },
            //     errorElement: "p",
            //     errorPlacement: function(error, element) {
            //         if (element.prop("tagName").toLowerCase() === "select") {
            //             error.insertAfter(element.closest(".form-group").find(".select2"));
            //         } else {
            //             error.insertAfter(element);
            //         }
            //     },
            //     submitHandler: function() {
            //         var form = $('#complaintForm');
            //         form.ajaxSubmit({
            //             dataType: 'json',
            //             beforeSubmit: function() {
            //                 form.find('button:submit').html('Please wait...').attr(
            //                     'disabled',
            //                     true).addClass('btn-secondary');
            //             },
            //             complete: function() {
            //                 form.find('button:submit').html('Update').attr('disabled',
            //                     false).removeClass('btn-secondary');
            //             },
            //             success: function(data) {
            //                 if (data.status) {
            //                     form[0].reset();
            //                     form.closest('.offcanvas').offcanvas('hide');
            //                     notify("Complaint successfully submitted", 'success');
            //                 } else {
            //                     notify(data.status, 'warning');
            //                 }
            //             },
            //             error: function(errors) {
            //                 showError(errors, form);
            //                 notify('Something went wrong', 'error');
            //             }
            //         });
            //     }
            // });
        });

        function getbalance() {
            $.ajax({
                url: "<?php echo e(route('getbalance')); ?>",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(result) {

                    $.each(result, function(index, value) {

                        $('.' + index).text(value);
                    });
                }
            });

            $.ajax({
                url: "<?php echo e(url('mydata')); ?>",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    $('.fundCount').text(data.fundrequest);
                    $('.aepsrequestfundCount').text(data.aepsfundrequest);
                    $('.member').text(data.member);
                    $('.aepspayoutfundCount').text(data.aepspayoutrequest);
                    $('.downlinebalance').text(data.downlinebalance);
                    $('.aepsfundCount').text(data.aepsfundrequest + data.aepspayoutrequest);
                }
            });
        }


        getbalance();



        <?php if(isset($table) && $table == 'yes'): ?>
            function datatableSetup(urls, datas, onDraw = function() {}, ele = "#datatable", element = {}) {
                let statusColumnIndex = 0;
                $(`${ele} thead th`).each(function(index) {
                    if ($(this).hasClass('status-column')) {
                        statusColumnIndex = index;
                    }
                });
                var options = {
                    dom: '<"d-flex justify-content-between align-items-center mb-2"<"d-flex align-items-center"l><"d-flex align-items-center gap-2"fB>>rt<"datatable-footer"ip>',
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ordering: false,
                    buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-primary text-end',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === statusColumnIndex - 1) {
                                        const el = document.createElement('div');
                                        el.innerHTML = data;
                                        const text = el.innerText || el.textContent || '';
                                        return text.trim().split('\n')[0];
                                    }
                                    return typeof data === 'string' ?
                                        data.replace(/<[^>]*>/g, '').trim() :
                                        data;
                                }
                            }
                        }
                    }],


                    columnDefs: [{
                        orderable: false,
                        width: '130px',
                        targets: [0]
                    }],
                    lengthMenu: [
                        [10, 50, 100, 500, 1000, 5000, 10000, 20000, -1],
                        [10, 50, 100, 500, 1000, 5000, 10000, 20000, 50000]
                    ],

                    language: {
                        paginate: {
                            'first': 'First',
                            'last': 'Last',
                            'next': '&rarr;',
                            'previous': '&larr;'
                        }
                    },
                    drawCallback: function() {
                        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    },
                    preDrawCallback: function() {
                        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                    },
                    ajax: {
                        url: urls,
                        type: "post",
                        data: function(d) {
                            d._token = $('meta[name="csrf-token"]').attr('content');
                            d.fromdate = $('#searchForm').find('[name="from_date"]').val();
                            d.todate = $('#searchForm').find('[name="to_date"]').val();
                            d.searchtext = $('#searchForm').find('[name="searchtext"]').val();
                            d.agent = $('#searchForm').find('[name="agent"]').val();
                            d.status = $('#searchForm').find('[name="status"]').val();
                            d.product = $('#searchForm').find('[name="product"]').val();
                            d.bank = $('#searchForm').find('[name="bank"]').val();
                        },
                        beforeSubmit: function() {
                            $('#searchForm').find('button:submit').html('Loading').attr("disabled", true).addClass(
                                'btn-secondary');
                        },
                        complete: function() {
                            $('#searchForm').find('button:submit').html('Search').attr("disabled", false)
                                .removeClass('btn-secondary');
                        },
                        error: function(response) {}
                    },
                    columns: datas
                };

                $.each(element, function(index, val) {
                    options[index] = val;
                });

                var DT = $(ele).DataTable(options).on('draw.dt', onDraw);

                return DT;
            }
        <?php endif; ?>

        function getPrevious(date = new Date(), days = 1) {
            const previous = new Date(date.getTime());
            previous.setDate(date.getDate() - days);

            return previous;
        }

        function showError(errors, form = "withoutform") {
            if (form != "withoutform") {
                $('p.error').remove();
                $('div.alert').remove();
                if (errors.status == 422) {
                    $.each(errors.responseJSON.errors, function(index, value) {
                        form.find('[name="' + index + '"]').closest('div.form-group').append('<p class="error">' +
                            value + '</span>');
                    });
                    form.find('p.error').first().closest('.form-group').find('input').focus();
                    setTimeout(function() {
                        form.find('p.error').remove();
                    }, 5000);
                } else if (errors.status == 400) {
                    if (errors.responseJSON.message) {
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"><span></span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> ` + errors.responseJSON.message + `
                        </div>`);
                    } else {
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"><span></span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> ` + errors.responseJSON.status + `
                        </div>`);
                    }

                    setTimeout(function() {
                        form.find('div.alert').remove();
                    }, 10000);
                } else {
                    notify(errors.statusText, 'warning');
                }
            } else {
                if (errors.responseJSON.message) {
                    notify(errors.responseJSON.message, 'warning');
                } else {
                    notify(errors.responseJSON.status, 'warning');
                }
            }
        }

        function sessionOut() {
            window.location.href = "<?php echo e(route('logout')); ?>";
        }

        // function status(id, type) {
        //     $.ajax({
        //         url: `<?php echo e(route('statementStatus')); ?>`,
        //         type: 'post',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {
        //             'id': id,
        //             "type": type
        //         },
        //         dataType: 'json',
        //         beforeSend: function() {
        //             swal({
        //                 title: 'Wait!',
        //                 text: 'Please wait, we are fetching transaction details',
        //                 onOpen: () => {
        //                     swal.showLoading()
        //                 },
        //                 allowOutsideClick: () => !swal.isLoading()
        //             });
        //         },
        //         success: function(data) {
        //             if (data.statuscode == "TXN" || data.status == 'success') {
        //                 if (data.txnStatus == undefined || data.txnStatus == null) {
        //                     var ot = data.status;
        //                 } else {
        //                     var ot = data.txnStatus;

        //                 }
        //                 var refno = "Your transaction " + ot;
        //                 console.log(refno);
        //                 swal({
        //                     type: 'success',
        //                     title: "Transaction status",
        //                     text: refno,
        //                     onClose: () => {
        //                         $('#datatable').dataTable().api().ajax.reload();
        //                     }
        //                 });
        //             } else if (data.statuscode == "TXF" || data.status == 'failed' || data.status ==
        //                 'reversed') {
        //                 if (data.txnStatus == undefined || data.txnStatus == null) {
        //                     var ot = data.status;
        //                 } else {
        //                     var ot = data.txnStatus;

        //                 }
        //                 var refno = "Your transaction " + ot;
        //                 console.log(refno);
        //                 swal({
        //                     type: 'success',
        //                     title: "Transaction status",
        //                     text: refno,
        //                     onClose: () => {
        //                         $('#datatable').dataTable().api().ajax.reload();
        //                     }
        //                 });

        //             } else {
        //                 swal({
        //                     type: 'warning',
        //                     title: "Transaction status",
        //                     text: data.message || "Please try after sometimes",
        //                     onClose: () => {
        //                         $('#datatable').dataTable().api().ajax.reload();
        //                     }
        //                 });
        //             }
        //         },
        //         error: function(errors) {
        //             swal.close();
        //             $('#datatable').dataTable().api().ajax.reload();
        //             showError(errors, "withoutform");
        //             notify(errors.responseJSON, 'error');

        //         }
        //     })

        // }

        // function editReport(id, refno, txnid, payid, remark, status, actiontype) {
        //     $('#editModal').find('[name="id"]').val(id);
        //     $('#editModal').find('[name="status"]').val(status).trigger('change');
        //     $('#editModal').find('[name="refno"]').val(refno);
        //     $('#editModal').find('[name="txnid"]').val(txnid);
        //     if (actiontype == "billpay") {
        //         $('#editModal').find('[name="payid"]').closest('div.form-group').remove();
        //     } else {
        //         $('#editModal').find('[name="payid"]').val(payid);
        //     }
        //     $('#editModal').find('[name="remark"]').val(remark);
        //     $('#editModal').find('[name="actiontype"]').val(actiontype);
        //     $('#editModal').offcanvas('show');
        // }

        // function complaint(id, product) {
        //     $('#complaintModal').find('[name="transaction_id"]').val(id);
        //     $('#complaintModal').find('[name="product"]').val(product);
        //     $('#complaintModal').offcanvas('show');
        // }

        function notify(text, status) {
            new Notify({
                status: status,
                title: null,
                text: text,
                effect: 'fade',
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                gap: 20,
                distance: 15,
                type: 1,
                position: 'right top'
            })
        }
    </script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Topbar -->
                <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End Topbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php echo $__env->make('layouts.pageheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme bg-white shadow-sm">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by <a href="#" target="_blank" class="fw-semibold">Incognic</a>
                                </div>
                                <div>
                                    
                                    

                                    <a href="#" target="_blank" class="footer-link me-4">Home</a>

                                    <a href="#" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Support</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
        <?php if(Myhelper::hasRole('admin')): ?>
            <div class="offcanvas offcanvas-end" id="walletloadModal" tabindex="-1" aria-hidden="true"
                data-bs-backdrop="static">
                <div class="offcanvas-header bg-primary mb-3">
                    <div class="text-center">
                        <h4 class="offcanvas-title text-white">Load Wallet</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                </div>
                <form id="walletLoadForm" action="<?php echo e(route('fundtransaction')); ?>" method="post">
                    <div class="offcanvas-body">
                        <div class="row">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="type" value="loadwallet" />
                            <div class="form-group col-md-12 my-1">
                                <label>Amount</label>
                                <input type="text" class="form-control my-1" placeholder="Enter Amount"
                                    name="amount" />
                            </div>
                            <div class="form-group col-md-12 my-1">
                                <label>Remark</label>
                                <textarea type="text" class="form-control my-1" placeholder="Enter Remark" name="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit"
                            data-loading-text="<i class='fa fa-spinner'></i> Submitting">Submit</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>


        <div class="offcanvas offcanvas-end" id="editModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

            <div class="offcanvas-header bg-primary">
                <h5 class="text-white" id="exampleModalLabel">Edit Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <form id="editForm" action="<?php echo e(route('statementUpdate')); ?>" method="post">
                <div class="offcanvas-body">
                    <div class="row">
                        <input type="hidden" name="id">
                        <input type="hidden" name="actiontype" value="">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group col-md-6 my-2">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="pending">Pending</option>
                                <option value="success">Success</option>
                                <option value="failed">Failed</option>
                                <option value="reversed">Reversed</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-2">
                            <label>Ref No</label>
                            <input type="text" name="refno" class="form-control" placeholder="Enter Ref id"
                                required="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 my-2">
                            <label>Txn Id</label>
                            <input type="text" name="txnid" class="form-control" placeholder="Enter Txn id"
                                required="">
                        </div>

                        <div class="form-group col-md-6 my-2">
                            <label>Pay Id</label>
                            <input type="text" name="payid" class="form-control" placeholder="Enter Pay id"
                                required="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Remark</label>
                            <textarea rows="3" name="remark" class="form-control" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"
                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating">Update</button>
                </div>
            </form>

        </div>


    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/jquery/jquery.js')); ?>"></script>
    
    <script src="<?php echo e(asset('theme_1/assets/vendor/js/bootstrap.js')); ?>"></script>

    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')); ?>"></script>
    

    
    
    <script src="<?php echo e(asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.js')); ?>"></script>

    <script src="<?php echo e(asset('theme_1/assets/vendor/js/menu.js')); ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    
    

    <?php if(!Request::is('flight/view')): ?>
        <script src="<?php echo e(asset('theme_1/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>
    <?php endif; ?>
    <!-- Main JS -->
    <script src="<?php echo e(asset('theme_1/assets/js/main.js')); ?>"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('')); ?>assets/js/core/jquery.validate.min.js"></script>

    
    

    <!-- Page JS -->
    
    

    <script src="<?php echo e(asset('')); ?>assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <?php echo $__env->yieldPushContent('script'); ?>


</body>

</html>
<?php /**PATH D:\wampp\www\b2btraveller\resources\views/layouts/app.blade.php ENDPATH**/ ?>