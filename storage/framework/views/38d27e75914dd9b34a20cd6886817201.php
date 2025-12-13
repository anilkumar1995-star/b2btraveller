<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incomeowl</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            background-color: #003d756b;
        }

        header {
            background-color: #F8F9FA;
        }

        header .navbar .navbar-brand img {
            height: 65px;
        }

        header .navbar .navbar-nav .nav-item .nav-link {
            font-weight: 500;
            padding-right: 15px;
            padding-left: 15px;
        }

        header .navbar .navbar-nav .nav-item .nav-link.active {
            color: #62BF00;
        }

        header .navbar .btn {
            background-color: #003D75 !important;
            color: #fff;
            transition: .4s;
            line-height: 0;
            padding: 20px 25px !important;
        }

        header .navbar .btn:hover {
            background-color: #62BF00 !important;
        }

        /* Form left Side */
        .main_rows {
            margin-bottom: 30px;
        }

        .form_side {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            border-radius: 10px;
            height: 100%;
            background: #fff;
        }

        .form_side .top_image img {
            width: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .form_body {
            padding: 20px;
        }

        .form_body label {
            margin-bottom: 5px;
            color: #050a198a;
            font-weight: 500;
        }

        .form_body input {
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #ddd;
            height: 42px;
            outline: none;
            border-radius: 5px;
            padding-left: 15px;
            color: #050a198a;
        }

        .form_body span {
            font-size: 11px;
            font-weight: 400;
            color: #b3adad;
        }

        .number_height {
            height: 42px;
            width: 70px;
        }

        .form_body .input-group input {
            margin-bottom: 0;
        }

        .form_body .input-group input:focus {
            border-color: #ddd;
            outline: 0;
            box-shadow: none;
        }

        .form_body .form-check-input {
            width: 16px;
            height: 16px;
        }

        .form_body .form-check label {
            font-size: 11px;
        }

        .continue_btn {
            width: 100%;
            height: 45px;
            border: none;
            background-color: #003D75;
            color: #fff;
            font-weight: 500;
            border-radius: 5px;
            transition: .4s;
        }

        .continue_btn.btn1_disabled {
            background-color: #cdcdcd;
            pointer-events: none;
        }

        .continue_btn:hover {
            background-color: #62BF00;
        }

        /* Right Side */

        .all_logos {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
        }

        .all_logos h6 {
            margin-bottom: 15px;
        }

        .all_logos h6:nth-child(1) {
            padding-left: 0px;
        }

        .all_logos h6 {
            padding-left: 10px;
        }

        .flex_imgeline {
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding-left: 10px;
            margin-bottom: 25px;
        }

        .flex_imgeline img {
            width: 32%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            border-radius: 5px;
        }
    </style>

</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.html"><img src="<?php echo e(Imagehelper::getImageUrl().json_decode(app\Models\Company::where('website', $_SERVER['HTTP_HOST'])->first(['logo']))->logo); ?>" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"> 
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto mb-2 mb-lg-0" style="opacity: 0;">
                            <!-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Service</a>
                          </li>
                          <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                              </li>
                          </li>
                          <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                              </li>
                          </li> -->

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href=""><img
                                        src="https://images.incomeowl.in/incomeowl/assets/share_link/phone.png"
                                        alt=""></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><img
                                        src="https://images.incomeowl.in/incomeowl/assets/share_link/whatsapp.png"
                                        alt=""></a>
                            </li>

                        </ul>
                        <div class="d-flex">
                            <!-- <button class="btn " type="submit">Log In</button> -->
                            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                                <!-- <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#">Service</a>
                            </li>
                            <li class="nav-item">
                              <li class="nav-item">
                                  <a class="nav-link" href="#">Blog</a>
                                </li>
                            </li>
                            <li class="nav-item">
                              <li class="nav-item">
                                  <a class="nav-link" href="#">Contact</a>
                                </li>
                            </li> -->

                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href=""><img
                                            src="https://images.incomeowl.in/incomeowl/assets/share_link/phone.png"
                                            alt=""></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href=""><img
                                            src="https://images.incomeowl.in/incomeowl/assets/share_link/whatsapp.png"
                                            alt=""></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section>
        <div class="container my-5 py-3">
            <div class="row ">
                <div class="col-md-6 main_rows">
                    <div class="form_side">
                        <div class="top_image">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/banner.png"
                                alt="">
                            <div class="form_body">
                                <form name="form1" action="" method="post">
                                    <?php echo e(csrf_field()); ?>

                                    <label for="">Customer Name</label><br>
                                    <input type="text" name="name"><br>
                                    <input type="hidden" name="link" id="link" value="">

                                    <label for="">Customer Mobile number</label><br>
                                    <div class="input-group ">
                                        <span class="input-group-text number_height"
                                            id="inputGroup-sizing-default">+91</span>
                                        <input type="text" class="form-control" maxlength="10" name="mobile"
                                            aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>
                                    <span>Mobile number should be linked with your Aadhaar card</span><br>
                                    <label class="mt-2" for="">Customer Email Id</label><br>
                                    <input type="email" name="email"><br>
                                    <label for="">Customer Pincode</label>
                                    <input type="text" name="pin" maxlength="6"> <br>

                                    <div class="form-check my-3">
                                        <input class="form-check-input" type="checkbox" name="form_checkbox"
                                            value="1" id="flexCheckChecked" onclick="myFunction()">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            By clicking "CONTINUE", I authorise IncomeOwl to securely store & use my
                                            data to call/SMS/whatsapp/email me about it's products & have accepted the
                                            terms of the privacy policy.
                                        </label>
                                    </div>
                                    <button disabled class="continue_btn btn1_disabled" type="button" name="btn1"
                                        id="btn1" onclick="formSubmit_gust('form1')"
                                        data-confirm="Are you sure?"
                                        class="btn btn-success mt-1 mb-0">Continue</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 main_rows">
                    <div class="all_logos">
                        <h6>Checkout more products</h6>
                        <h6>Credit Card</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/1.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/2.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/3.png" alt="">
                        </div>

                        <h6>Saving Account</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/4.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/5.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/6.png" alt="">
                        </div>

                        <h6>Investment</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/7.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/8.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/9.png" alt="">
                        </div>

                        <h6>Demat Account</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/10.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/11.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/12.jpg" alt="">
                        </div>

                        <h6>Subscription</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/13.png" alt="">
                        </div>

                        <h6>Personal Loan</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/14.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/15.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/16.png" alt="">
                        </div>

                        <h6>Credit Line </h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/17.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/18.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/19.png" alt="">
                        </div>

                        <h6>Instant Loan </h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/20.png" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/21.jpg" alt="">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/22.png" alt="">
                        </div>

                        <h6>UPI</h6>
                        <div class="flex_imgeline">
                            <img src="https://images.incomeowl.in/incomeowl/assets/share_link/23.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script>
<script>
    function myFunction() {
        var checkBox = document.getElementById("flexCheckChecked");
        var btn1s = document.getElementById("btn1");
        if (checkBox.checked == true) {
            btn1s.disabled = false;
            btn1s.classList.remove("btn1_disabled");
        } else {
            btn1s.disabled = true;
            btn1s.classList.add("btn1_disabled");
        }
    }

    function formSubmit_gust(aForm) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const linkValue = urlParams.get('link');
        document.getElementById("link").value = decodeURI(linkValue);


        if ($('#flexCheckChecked').is(":checked")) {

            var aFormData = $("[name='" + aForm + "']").serializeArray();

            // var $aData = "";
            // $.each(aFormData, function(i, field) {
            //   $mData += "&" + field.name + "=" + encodeURIComponent(field.value);
            // });

            var $aData = '{';
            var i;
            for (i = 0; i < aFormData.length; i++) {
                if (i != 0) {
                    $aData += ',';
                }
                $aData += '"' + aFormData[i].name + '":"';
                $aData += aFormData[i].value + '"';
            }
            $aData += '}';

            // console.log($aData);

            $.ajax({
                type: "POST",
                url: "customer_info_submit",
                data: $aData,
                contentType: 'application/json',
                success: function(data) {
                    if (data.status == "SUCCESS") {
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                            // showConfirmButton: true,
                        });
                        window.location.href = data.data.link;
                    } else {
                        // print_msgs = "";
                        Swal.fire({
                            icon: "error",
                            title: data.message || "Something went wrong",
                            showConfirmButton: true,
                            confirmButtonColor: "#5d5ad2",

                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                        });
                    }
                }
            });
        }
    }

    function myPgRediFnc(aVal1, aVal2) {
        if (aVal1 == "1") {
            window.location.reload(1);
        } else if (aVal1 == "2") {
            window.location.href = aVal2;
        } else if (aVal1 == "3") {
            window.location.href = aVal2;
        } else if (aVal1 == "4") {
            window.open(aVal2, "_blank");
        }
    }
</script>

</html>
<?php /**PATH /home/incognic/login.quick2pay.in/resources/views/affiliate/affiliate.blade.php ENDPATH**/ ?>