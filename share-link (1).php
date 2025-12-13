<?php 
session_start();
require_once 'config/config.php';
$img_url = "https://images.incomeowl.in/incomeowl/";
$sharelink = (string) $_GET['link'];

function CompanySelfEncr($input,$key,$iv){
  $encrypted = base64_encode(openssl_encrypt($input, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
  return $encrypted;
}
function CompanySelfDcr($input,$key,$iv){
  $decrypted = openssl_decrypt(base64_decode($input), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
  return $decrypted;
}
if($sharelink){
  $selfcredCk = $db->rawQueryOne("SELECT inp1,inp2 FROM credential WHERE stat='1' AND api_name='COMPANY_SELF'");
  $key = $selfcredCk['inp1'];
  $iv = $selfcredCk['inp2'];
  $service_id = CompanySelfDcr($sharelink,$key,$iv);
  if($service_id){
    $decode_string = $service_id;
    $decode_string_arr = explode ("|", $decode_string); 

    $form_type = $decode_string_arr[0];
    $referral = $decode_string_arr[1];
    $data_info_type = $decode_string_arr[2];
  }else{
    $form_type = "";
    $referral = "";
    $data_info_type = "";
  }
}else{
  $form_type = "";
  $referral = "";
  $data_info_type = "";
}

if(($data_info_type == "Merchant" || $data_info_type == "Customer") && ($referral!="") && ($form_type!="")){
  if($data_info_type == "Merchant"){
    $retlCk = $db->rawQueryOne("SELECT name,mob,eml,pin FROM user WHERE user_name='".$referral."'");						
    if($retlCk){
        $name = $retlCk['name'];
        $mobile = $retlCk['mob'];
        $eml = $retlCk['eml'];
        $pin = $retlCk['pin'];

          $source = "WEB";  
          $credCk = $db->rawQueryOne("SELECT api_url,api_user,api_pass,api_auth,inp1,inp2 FROM credential WHERE stat='1' AND api='38' AND service='0'");
          $company=$credCk['api_user'];            

          $parameter['id'] = (string) $form_type;
          $jsonBody = json_encode($parameter);
  
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $credCk['api_url']."service_to_category");
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonBody);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Userid: '.$credCk['api_user'], 'Token: '.$credCk['api_auth'], 'Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $rsp = curl_exec($ch);
          $err = curl_error($ch);
          curl_close ($ch);
  
          $rsp_a = json_decode($rsp, true);
  
          if($rsp_a['status']==1){
              $sell_earn_id = $rsp_a['data']['sell_earn_id'];
              $sell_earn_name = $rsp_a['data']['sell_earn_name'];
              $department = $rsp_a['data']['department'];
              $department_name = $rsp_a['data']['department_name'];
              $mrcnt_expt_comm = $rsp_a['data']['merchant_expected_commission'];

              $dta['name']=(string) $name;
              $dta['mob']=(string) $mobile;
              $dta['eml']=(string) $eml;
              //$dta['age']=(string) $age;
              $dta['pin']=(string) $pin;
              //$dta['employment_type']=(string) $employment_type;
              //$dta['income_range']=(string) $income_range;
              //$dta['have_cc']=(string) $have_cc_v;
              $dta['form_type']=(string) $form_type;
              $dta['sell_earn_id']=(string) $sell_earn_id;
              $dta['sell_earn_name']=(string) $sell_earn_name;
              $dta['department']=(string) $department;
              $dta['department_name']=(string) $department_name;
              $dta['data_info_type']=(string) $data_info_type;
              $dta['mrcnt_expt_comm']=(string) $mrcnt_expt_comm;
              $dta['company']=(string) $company;
              $dta['referral']=(string) $referral;
              $dta['source']=(string) $source;
              $dta['cdtm']=date('Y-m-d H:i:s');
              $genId=$db->insert('customer_info',$dta);
              if($genId){
                  $parameter['name'] = (string) $name;
                  $parameter['mobile'] = (string) $mobile;
                  $parameter['email'] = (string) $eml;
                  //$parameter['age'] = (string) $age;
                  $parameter['pin'] = (string) $pin;
                  //$parameter['employment_type'] = (string) $employment_type;
                  //$parameter['income_range'] = (string) $income_range;
                  //$parameter['have_cc'] = (string) $have_cc_v;
                  $parameter['form_type'] = (string) $form_type;
                  $parameter['referral'] = (string) $referral;
                  $parameter['source'] = (string) $source;
                  $jsonBody = json_encode($parameter);
          
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $credCk['api_url']."customer_info_send");
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonBody);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Userid: '.$credCk['api_user'], 'Token: '.$credCk['api_auth'], 'Content-Type: application/json'));
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  $rsp2 = curl_exec($ch);
                  $err = curl_error($ch);
                  curl_close ($ch);
          
                  $rsp2_a = json_decode($rsp2, true);
          
                  if($rsp2_a['status']==1){
                      $link = $rsp2_a['data']['link'];
                      $data_to_db['link'] = $link;  
                      $data_to_db['edtm'] = date('Y-m-d H:i:s');                          
                      $db->where('id', $genId);
                      $last_id = $db->update('customer_info', $data_to_db);
                      if ($last_id) {
                        header("Location: ".$link);
                      }else{
                        echo 'Somehhing wrpng..!';
                      }                   
                  }else{
                    echo 'Somehhing wrpng.!';
                  }
              }else{
                echo 'Something wrong.';
              }
          }else{
            echo 'Invalid service link!';
          }
    }else{
      echo 'Invalid link.';
    }
  }else{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Incomeowl</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="./share-link.css">
    </head>

    <body>
      <header>
        <div class="container">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="index.html"><img src="<?php echo $img_url; ?>assets/share_link/logo.png" alt=""></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link active" aria-current="page" href=""><img src="<?php echo $img_url; ?>assets/share_link/phone.png" alt=""></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><img src="<?php echo $img_url; ?>assets/share_link/whatsapp.png" alt=""></a>
                  </li>

                </ul>
                <form class="d-flex">
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
                      <a class="nav-link active" aria-current="page" href=""><img src="<?php echo $img_url; ?>assets/share_link/phone.png" alt=""></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#"><img src="<?php echo $img_url; ?>assets/share_link/whatsapp.png" alt=""></a>
                    </li>

                  </ul>
                </form>
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
                  <img src="<?php echo $img_url; ?>assets/share_link/banner.png" alt="">
                  <div class="form_body">
                    <form name="form1" action="" method="post">
                      <label for="">Customer Name</label><br>
                      <input type="text" name="name"><br>
                      <input type="hidden" name="sharelink" value="<?php echo $sharelink ?>">

                      <label for="">Customer Mobile number</label><br>
                      <div class="input-group ">
                        <span class="input-group-text number_height" id="inputGroup-sizing-default">+91</span>
                        <input type="text" class="form-control" maxlength="10" name="mobile" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                      </div>
                      <span>Mobile number should be linked with your Aadhaar card</span><br>
                      <label class="mt-2" for="">Customer Email Id</label><br>
                      <input type="email" name="email" ><br>
                      <label for="">Customer Pincode</label>
                      <input type="text" name="pin"  maxlength="6"> <br>

                      <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" name="form_checkbox" value="1" id="flexCheckChecked" onclick="myFunction()">
                        <label class="form-check-label" for="flexCheckChecked">
                          By clicking "CONTINUE", I authorise IncomeOwl to securely store & use my data to call/SMS/whatsapp/email me about it's products & have accepted the terms of the privacy policy.
                        </label>
                      </div>
                      <button disabled class="continue_btn btn1_disabled" type="button" name="btn1" id="btn1" onclick="formSubmit_gust('form1')" data-confirm="Are you sure?" class="btn btn-success mt-1 mb-0">Continue</button>
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
                  <img src="<?php echo $img_url; ?>assets/share_link/1.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/2.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/3.png" alt="">
                </div>

                <h6>Saving Account</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/4.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/5.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/6.png" alt="">
                </div>

                <h6>Investment</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/7.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/8.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/9.png" alt="">
                </div>

                <h6>Demat Account</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/10.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/11.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/12.jpg" alt="">
                </div>

                <h6>Subscription</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/13.png" alt="">
                </div>

                <h6>Personal Loan</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/14.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/15.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/16.png" alt="">
                </div>

                <h6>Credit Line </h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/17.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/18.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/19.png" alt="">
                </div>

                <h6>Instant Loan </h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/20.png" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/21.jpg" alt="">
                  <img src="<?php echo $img_url; ?>assets/share_link/22.png" alt="">
                </div>

                <h6>UPI</h6>
                <div class="flex_imgeline">
                  <img src="<?php echo $img_url; ?>assets/share_link/23.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script>
    function myFunction() {
      var checkBox = document.getElementById("flexCheckChecked");
      var btn1s = document.getElementById("btn1");
      if (checkBox.checked == true){
        btn1s.disabled = false;
        btn1s.classList.remove("btn1_disabled");
      } else {
        btn1s.disabled = true;
        btn1s.classList.add("btn1_disabled");
      } 
    }

      function formSubmit_gust(aForm) {
        if ($('#flexCheckChecked').is(":checked")) {
          var aFormData = $("[name='" + aForm + "']").serializeArray();

          // var $aData = "";
          // $.each(aFormData, function(i, field) {
          //   $mData += "&" + field.name + "=" + encodeURIComponent(field.value);
          // });

          var $aData='{';
          var i;
          for (i = 0; i < aFormData.length; i++) {
            if(i != 0){
              $aData+=',';
            }
            $aData+='"'+aFormData[i].name+'":"';
            $aData+=aFormData[i].value+'"';         
          }
          $aData+='}';

          console.log($aData); 

          $.ajax({
            type: "POST",
            url: "api/customer_info_submit",
            data: $aData,
            contentType: 'application/json',
            success: function(msg) {          
              var data = JSON.parse(JSON.stringify(msg));
              console.log(data);          
              if (data.status == 1) {
                var page_reload = "";
                var page_reload_url = "";
                if (data.reload === 1) {
                  page_reload = 1;
                } else if (data.reload === 2) {
                  page_reload = 2;
                  page_reload_url = data.reload_url;
                } else if (data.reload === 3) {
                  page_reload = 3;
                  page_reload_url = data.reload_url;
                } else if (data.reload === 4) {
                  page_reload = 4;
                  page_reload_url = data.reload_url;
                }
                Swal.fire({
                  icon: "success",
                  title: data.message,
                  showConfirmButton: true,
                  confirmButtonColor: "#5d5ad2",
                  confirmButtonText: "<span onclick=\"myPgRediFnc('" +
                    page_reload +
                    "','" +
                    page_reload_url +
                    "')\">OK</span>",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                });
              }else{
                print_msgs = "";
                Swal.fire({
                  icon: "error",
                  title: data.message,
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
    <?php
  }
}else{
  echo 'Invalid link';
}
?>
