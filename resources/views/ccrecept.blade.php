
<link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
    ._failed{ border-bottom: solid 4px red !important; }
._failed i{  color:red !important;  }

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 100%;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}

</style>


<div class="container">
                     <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                   <p> Thank you for your payment. we will <br>
be in contact with more details shortly </p>
            <ul class="list-group">
                <li class="list-group-item"><b>Client Ref Id : </b>{{$datas['clientRefId']}}</li>
              <li class="list-group-item"><b>Order Id : </b>{{$datas['orderId']}}</li>
              <li class="list-group-item"><b>Payment Id : </b>{{$datas['paymentId']}}</li>
                <li class="list-group-item"><b> Amount : </b>{{$datas['amount']}}</li>
              <!--<li class="list-group-item"><b>full Amount : </b>{{$datas['amount']}}</li>-->
              <li class="list-group-item"><b>UTR : </b>{{$datas['utr']}}</li>
              <li class="list-group-item"><b>Pay Mode : </b>{{$datas['payMode']}}</li>
            </ul>
            </div> 
        </div> 
    </div> 
  
 
  
    
</div> 
