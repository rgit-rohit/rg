<?php
$root='./';
include_once($root."config/config.inc.php");
$log_page_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$_SESSION[PRE.'category']='Presale'; // category define


if(!isset($_SESSION[PRE.'category'])){
    header('location:connect');
}else{
    $category  = $_SESSION[PRE.'category']; 
}
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Connect Wallet</title>
        <?php include($root.'includes/common_head.php');?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
        <style type="text/css">
            .pt-35{padding-top: 35px;}
            .plus_minus_btn {color: #fff;font-size: 20px;border: 1px solid #fff;border-radius: 10px;text-align: center;cursor: pointer;}
            .number_box{background: transparent;color: #fff; font-size: 20px;border: none;border-radius: 10px;text-align: center;width: inherit;}
            .btn_mint{background-color: #99ff17;font-size: 18px; padding:5px 20px;border-radius: 10px;color:black;cursor: pointer; }
            .font-size-32{font-size: 32px;}
            .text-bold{font-weight: bold;}
            .color-green{color: #99ff17;}
            .color-pink{color: #f7a197;}
            .number_box::-webkit-outer-spin-button,.number_box::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
            .color-yellow{color: #ffa300;}
            .color-black{color: black;}
            .mint-wallet-id{padding: 5px 0;font-family: BegumSans-Medium;font-size: 22px;font-weight: 100;}
            #text_message {font-size:20px;font-weight: 100;}
            #hash_value{font-size:16px; padding: 0 40px;text-decoration: underline;}
            #myModal {position: absolute;left: 50%;top: 50%;transform: translate(-50%, -45%);}
            .modal {right:  auto; }
            .modal-dialog{max-width: 1200px;}
            .left-card p{margin-bottom: 4px;}
            .text-black{color:black;}
            #parallelogram {padding: 0 20px; -webkit-transform: skew(20deg);-moz-transform: skew(20deg);-o-transform: skew(20deg); background:#27273d;overflow: hidden; position: relative;margin-left: -35px;}
            .parallelogram {padding: 0 20px;margin-left: -15px;background: yellow;}
            .card-red{background: #770505!important;}
            .ml-15{margin-left: 15px;}
        </style>
    </head>
    <body>
        <main class="profile">  
            <?php include($root.'includes/header.php');?>
            <br><br><br>
            <section class="new_header" style="margin-top:0">
               <!-- <h4 class="text-center pt-35 text-bold">HOOTY OWLS MEGA SALE</h4>  -->
            </section>
            <section class="new_header_two">
               <h5 class="text-center color-yellow mint-wallet-id" id="mint_wallet_id_display">Wallet ID :<?php echo $wallet_id;?></h5> <br>
                <input type="hidden" id="mint_wallet_id" value="<?php echo $wallet_id;?>"> 
                 <input type="hidden" id="new_mint_wallet_id" value=""> 
                <input type="hidden" id="log_page_url" value="<?php echo $log_page_url;?>"> 
            </section>
            <section class="main_content pb-20">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card left-card" style="min-height: 216px;" >
                            <div class="row">
                                <div class="col-sm-8 col-md-7 ">
                                    <div class="parallelogram">
                                        <p class="text-black text-bold">SUPPLY <span class=" text-bold " id="">&nbsp;&nbsp; <span id="total_minted">xxx/xxx</span></span></p> 
                                    </div>
                                </div>
                                <div class="col-sm-4  col-md-4">
                                    <div id="parallelogram">
                                        <p class="text-black" >&nbsp;&nbsp; </p> 
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row  ">
                                    <div class="col-md-12 ">
                                        
                                        <div id="loader1_connection">
                                            <p >Connecting to Wallet</p>
                                        </div>

                                        <div class="loader" id="loader1" style="margin-top:15%!important; display: block;">
                                            <img src="images/loader_new.gif">
                                        </div> 
                                        <div class="row" id="free_block" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 text-center">
                                                        <p class="color-yellow text-center">QUANTITY</p>  
                                                        <div class="row ">
                                                            <div class="col-md-3 ml-15">
                                                                <div class="value-button plus_minus_btn" id="decrease" onclick="decreaseValueF()" value="Decrease Value">-</div>
                                                            </div>
                                                            <div class="col-md-3 ml-15">
                                                                <input type="number" id="number_f" class="number_box text-bold" name="mint_qty" value="1" min="1" disabled=""/>
                                                            </div>
                                                            <div class="col-md-3 ml-15">
                                                                <div class="value-button plus_minus_btn" id="increase" onclick="increaseValueF()" value="Increase Value">+</div>
                                                            </div>
                                                        </div> 
                                                        <!--<p class="text-center text-success " style="font-size: 13px;padding-top: 1px; display: none;" id="cashback_text_f"><i class="fa fa-check"></i>  &nbsp;&nbsp;Eligible for Cashback </p> -->
                                                        </div>
                                                    <div class="col-md-6 text-center">
                                                        <input type="hidden"   id="available_free_mint" value="1"> 
                                                        <input type="hidden"   id="default_mint_price_full_f" value="3500000000000000">  
                                                        <input type="hidden"   id="total_price_dynamic_f"> 
                                                        <p class="text-center color-yellow">TOTAL PRICE </p> 
                                                        <p class=" text-bold text-center" style="padding-top: 3px;" id="dy_eth_val_f"><span id="dy_eth_val_default_f"></span></p>
                                                        <!--<p class="text-center" style="font-size: 13px;padding-top: 3px;"><span id="available_free_mint_2">1</span> FREE, additional <span id="dy_eth_val_default_f_2"></span> ETH</p>-->
                                                    </div>   
                                                </div>
                                                <div>&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center" style="padding-top: 5px;">
                                                        <a href="javascript:void(0);" id="mint_dynamic_f" onclick="call_dynamic_mint_f(document.getElementById('mint_wallet_id').textContent);">
                                                        <img src="<?php echo $root;?>images/mint.png"></a> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="row" id="paid_block" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 text-center">
                                                        <p class="color-yellow text-center">QUANTITY</p>  
                                                        <div class="row ">
                                                            <div class="col-md-3 ml-15">
                                                                <div class="value-button plus_minus_btn" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                                            </div>
                                                            <div class="col-md-3 ml-15">
                                                                <input type="number" id="number" class="number_box text-bold" name="mint_qty" value="1" min="1" disabled=""/>
                                                            </div>
                                                            <div class="col-md-3 ml-15">
                                                                <div class="value-button plus_minus_btn" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                                            </div>
                                                        </div> 
                                                        <!--<p class="text-center text-success " style="font-size: 13px;padding-top: 1px; display: none;" id="cashback_text"><i class="fa fa-check"></i>  &nbsp;&nbsp;Eligible for Cashback </p> -->
                                                        </div>
                                                    <div class="col-md-6 text-center">
                                                        <input type="hidden"   id="default_mint_price_full" value="3500000000000000">  
                                                        <input type="hidden"   id="total_price_dynamic"> 
                                                        <p class="text-center color-yellow">TOTAL PRICE </p> 
                                                        <p class=" text-bold text-center" style="padding-top: 3px;" id="dy_eth_val"><span id="dy_eth_val_default"></span></p>
                                                    </div>   
                                                </div>
                                                <div class="row">&nbsp;</div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center" style="padding-top: 5px;">
                                                        <a href="javascript:void(0);" id="mint_dynamic_f" onclick="call_dynamic_mint(document.getElementById('mint_wallet_id').textContent);">
                                                        <img src="<?php echo $root;?>images/mint.png"></a> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!--
                    <div class="col-md-5">
                        <div class="card" style="min-height: 216px;">
                            <div class="card-body">
                                
                                <div id="loader2_connection">
                                    <p >Connecting to Wallet</p>
                                </div>

                                <div class="loader" id="loader2" style="margin-top:22%!important; display: block;">
                                    <img src="images/loader_new.gif">
                                </div>

                                <div class="row" id="free_cashback_block" style="display: none;">
                                    <div class="col-md-12 " style="padding-top: 5px;">
                                        <p class="color-yellow ">CASHBACK OFFERS</p>
                                        
                                        <p class="" id=" ">Mint <span id="cashback_5_free"></span> (<span class="available_free_mint_no"></span> Free + 5 Paid) and get $5 cashback</p> 
                                        <p class="" id=" ">Mint <span id="cashback_10_free"></span> (<span class="available_free_mint_no"></span> Free + 10 Paid) and get $10 cashback</p>
                                        <p class="mb-4" id=" ">Mint <span id="cashback_20_free"></span> (<span class="available_free_mint_no"></span> Free + 20 Paid) and get $20 cashback</p>

                                    </div>
                                </div>
                                <div class="row" id="paid_cashback_block" style="display: none;">
                                    <div class="col-md-12 " style="padding-top: 5px;">
                                        <p class="color-yellow ">CASHBACK OFFERS</p>
                                        <p class="" id=" ">Mint 5 and get $5 cashback</p> 
                                        <p class="" id=" ">Mint 10 and get $10 cashback</p>
                                        <p class="mb-4" id=" ">Mint 20 and get $20 cashback</p>
                                    </div>  
                                </div> 
                            </div>
                        </div>
                    </div>
-->

                </div> 
            </div>
            </section>
        </main>
        <?php include($root.'includes/footer.php');?>
        <div id="myModal" class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: #1c1423;">
                  <div class="modal-header" style="border: none;">
                    <span class="close color-green"></span>
                    <h4 class="modal-title"></h4>
                  </div>
                  <div class="modal-body">
                    <p id="text_message" class=" text-center color-pink"></p>
                    <div id="hash_value" class="text-center"></div>
                  </div>
                  <div class="modal-footer" style="border: none;">
                    <!-- <span class="close"><img src="<?php echo $root;?>images/close.png"></span> -->
                  </div>
                </div>
            </div>
        </div>
    </body>
<script src="<?php echo $root;?>js/mint_custom.js"></script>
<script type="text/javascript">
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
  modal.style.display = "none";
}
// autoload to display price===================
window.onload=function() {
    get_wallet_connection();
}

function get_wallet_connection(){
    //alert('Hello');
    // Connect metamask to our site. get user's address
    var account=null;
     
    (async ()=>{
        if(window.ethereum){
            await window.ethereum.send('eth_requestAccounts');
            window.web3 = new Web3(window.ethereum); 
            var accounts = await web3.eth.getAccounts();
            account = accounts[0]; 
             
            // document.getElementById('wallet_id').innerHTML = '<h5 class="">'+account+'</h5>';
            document.getElementById('mint_wallet_id').innerHTML = account;
            document.getElementById('new_mint_wallet_id').value = account;
            document.getElementById('mint_wallet_id_display').innerHTML = 'Wallet ID : '+account;
            document.getElementById('loader1_connection').innerHTML = '';
            //document.getElementById('loader2_connection').innerHTML = '';
            
            //check condition for redirct
            is_token_exist(account);
        }
    })(); 
}
</script>
</html>
