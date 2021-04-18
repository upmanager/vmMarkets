@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <div class="header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h3 class="">{{$lang->get(342)}}</h3>
            </div>
        </div>
    </div>
    <div class="body">

        <div class="row clearfix">

            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(343)}}</h4></label>
            </div>

            <div class="col-md-6 foodm">
                <div class="col-md-12 foodm">
                    <div class="form-group form-group-lg " >
                        <div id="StripeEnable" onclick="onCheckClick('StripeEnable')" style="font-weight: bold; "></div><br>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(344)}}</h5>
                    </div>
                    <div class="col-md-10 foodm">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="stripeKey" id="stripeKey" class="q-form" placeholder="" maxlength="1000" value="{{$stripeKey}}">
                                <label class="form-label">{{$lang->get(345)}}</label>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-md-12 foodm">
                <div class="col-md-2 foodm">
                    <h5>{{$lang->get(346)}}:</h5>
                </div>
                <div class="col-md-10 foodm">
                <div class="form-group form-group-lg form-float">
                    <div class="form-line">
                        <input type="text" name="stripeSecretKey" id="stripeSecretKey" class="q-form" placeholder="" maxlength="1000" value="{{$stripeSecretKey}}">
                        <label class="form-label">{{$lang->get(347)}}</label>
                    </div>
                </div>
                </div>
            </div>

            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://dashboard.stripe.com">{{$lang->get(349)}}</a>
                <img src="img/stripe.jpg" width="400px">
            </div>
        </div>

        <hr>
        <div class="row clearfix">
            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(350)}}</h4></label>
            </div>

            <div class="col-md-6 foodm">

                <div class="col-md-12 foodm">
                    <div class="form-group form-group-lg " >
                        <div id="razEnable" onclick="onCheckClick('razEnable')" style="font-weight: bold; "></div><br>
                    </div>
                </div>


                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(351)}}</h5>
                    </div>
                    <div class="col-md-10 foodm">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="razKey" id="razKey" class="q-form" placeholder="" maxlength="1000" value="{{$razKey}}">
                                <label class="form-label">{{$lang->get(352)}}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(353)}}:</h5>
                    </div>
                    <div class="col-md-10 foodm">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="razName" id="razName" class="q-form" placeholder="" maxlength="1000" value="{{$razName}}">
                            </div>
                            <p>{{$lang->get(354)}}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://dashboard.razorpay.com/">{{$lang->get(355)}}</a>
                <img src="img/razorpay.jpg" width="400px">
            </div>
        </div>

        <div class="col-md-12 foodm"><hr></div>
        <div class="col-md-12 foodm">
            <div class="form-group form-group-lg " >
                <div id="cashEnable" onclick="onCheckClick('cashEnable')" style="font-weight: bold; "></div>
            </div>
        </div>

        <div class="col-md-12 foodm"><hr></div>
        <div class="col-md-12 foodm">
            <div class="form-group form-group-lg " >
                <div id="walletEnable" onclick="onCheckClick('walletEnable')" style="font-weight: bold; "></div>
            </div>
        </div>

{{--line--}}
        <div class="col-md-12 foodm"><hr></div>

{{--payPal--}}
        <div class="row clearfix">
            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(356)}}</h4></label>
            </div>

            <div class="col-md-6 foodm">
                <div class="col-md-12">
                    <div id="payPalEnable" onclick="onCheckClick('payPalEnable')" style="font-weight: bold; "></div><br>
                    <div id="payPalSandBox" onclick="onCheckClick('payPalSandBox')" style="font-weight: bold; "></div><br>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(357)}}</h5>
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="payPalClientId" id="payPalClientId" class="q-form" placeholder="" maxlength="1000" value="{{$payPalClientId}}">
                                <label class="form-label">{{$lang->get(358)}}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(359)}}:</h5>
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="payPalSecret" id="payPalSecret" class="q-form" placeholder="" maxlength="1000" value="{{$payPalSecret}}">
                                <label class="form-label">{{$lang->get(360)}}</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://developer.paypal.com/developer/accounts/create">{{$lang->get(361)}}</a>
                <img src="img/paypal.jpg" width="400px">
            </div>
        </div>

{{--line--}}
        <div class="col-md-12 foodm"><hr></div>
{{--payStack--}}
        <div class="row clearfix">

            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(362)}}</h4></label>
            </div>

            <div class="col-md-6 foodm">
                <div class="col-md-12">
                    <div id="payStackEnable" onclick="onCheckClick('payStackEnable')" style="font-weight: bold; "></div><br>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(357)}}</h5>
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="payStackKey" id="payStackKey" class="q-form" placeholder="" maxlength="1000" value="{{$payStackKey}}">
                                <label class="form-label">{{$lang->get(352)}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://dashboard.paystack.com">{{$lang->get(363)}}</a>
                <img src="img/paystack.jpg" width="400px">
            </div>
        </div>

{{--line--}}
        <div class="col-md-12 foodm"><hr></div>

{{--Yandex.Kassa--}}
        <div class="row clearfix">
            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(444)}}</h4></label>     {{--"Yandex.Kassa"--}}
            </div>

            <div class="col-md-6 foodm">
                <div class="col-md-12">
                    <div id="yandexKassaEnable" onclick="onCheckClick('yandexKassaEnable')" style="font-weight: bold; "></div><br>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(449)}}</h5>        {{--"Shop Id",--}}
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="yandexKassaShopId" id="yandexKassaShopId" class="q-form" placeholder="" maxlength="1000" value="{{$yandexKassaShopId}}">
                                <label class="form-label">{{$lang->get(450)}}</label>       {{--"Insert Shop Id"--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(445)}}</h5>        {{--"Client App Key",--}}
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="yandexKassaClientAppKey" id="yandexKassaClientAppKey" class="q-form" placeholder="" maxlength="1000" value="{{$yandexKassaClientAppKey}}">
                                <label class="form-label">{{$lang->get(446)}}</label>       {{--"Insert Client App Key"--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(447)}}</h5>        {{--"Secret Key",--}}
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="yandexKassaSecretKey" id="yandexKassaSecretKey" class="q-form" placeholder="" maxlength="1000" value="{{$yandexKassaSecretKey}}">
                                <label class="form-label">{{$lang->get(448)}}</label>       {{--"Insert Secret Key"--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://developer.paypal.com/developer/accounts/create">{{$lang->get(456)}}</a>            {{--Yandex.Kassa Dashboard--}}
                <img src="img/yandex.jpg" width="400px">
            </div>
        </div>

{{--line--}}
        <div class="col-md-12 foodm"><hr></div>

{{--instamojo--}}
        <div class="row clearfix">
            <div class="col-md-12 foodm">
                <label style="margin-bottom: 30px"><h4>{{$lang->get(451)}}</h4></label>     {{--"instamojo"--}}
            </div>

            <div class="col-md-6 foodm">
                <div class="col-md-12">
                    <div id="instamojoEnable" onclick="onCheckClick('instamojoEnable')" style="font-weight: bold; "></div><br>
                    <div id="instamojoSandBoxMode" onclick="onCheckClick('instamojoSandBoxMode')" style="font-weight: bold; "></div><br>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(452)}}</h5>        {{--"Api key",--}}
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="instamojoApiKey" id="instamojoApiKey" class="q-form" placeholder="" maxlength="1000" value="{{$instamojoApiKey}}">
                                <label class="form-label">{{$lang->get(453)}}</label>       {{--"Insert Api key"--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 foodm">
                    <div class="col-md-2 foodm">
                        <h5>{{$lang->get(454)}}</h5>        {{--"Private Token",--}}
                    </div>
                    <div class="col-md-10 foodm" style="padding-left: 30px">
                        <div class="form-group form-group-lg form-float">
                            <div class="form-line">
                                <input type="text" name="instamojoPrivateToken" id="instamojoPrivateToken" class="q-form" placeholder="" maxlength="1000" value="{{$instamojoPrivateToken}}">
                                <label class="form-label">{{$lang->get(455)}}</label>       {{--"Insert Private Token"--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 foodm">
                {{$lang->get(348)}} <a href="https://developer.paypal.com/developer/accounts/create">{{$lang->get(457)}}</a>   {{--instamojo Dashboard--}}
                <img src="img/instamojo.jpg" width="400px">
            </div>
        </div>

{{--line--}}
        <div class="col-md-12 foodm"><hr></div>

{{--save--}}
        <div class="row clearfix">
            <div class="col-md-12 form-control-label">
                <div align="center">
                    <button type="button" onclick="save();" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(364)}}</h5></button>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    if ('{{$StripeEnable}}' == "true") {
        var StripeEnable = true;
        document.getElementById('StripeEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(365)}}";
    }else{
        var StripeEnable = false;
        document.getElementById('StripeEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(365)}}";
    }
    if ('{{$razEnable}}' == "true") {
        var razEnable = true;
        document.getElementById('razEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(366)}}";
    }else{
        var razEnable = false;
        document.getElementById('razEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(366)}}";
    }
    if ('{{$cashEnable}}' == "true") {
        var cashEnable = true;
        document.getElementById('cashEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(367)}}";
    }else{
        var cashEnable = false;
        document.getElementById('cashEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(367)}}";
    }
    if ('{{$payPalEnable}}' == "true"){
        var payPalEnable = true;
        document.getElementById('payPalEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(368)}}";
    }else{
        var payPalEnable = false;
        document.getElementById('payPalEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(368)}}";
    }
    if ('{{$payPalSandBox}}' == "true") {
        var payPalSandBox = true;
        document.getElementById('payPalSandBox').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(369)}}";
    }else{
        var payPalSandBox = false;
        document.getElementById('payPalSandBox').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(369)}}";
    }
    if ('{{$walletEnable}}' == "true") {
        var walletEnable = true;
        document.getElementById('walletEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(370)}}";
    }else{
        var walletEnable = false;
        document.getElementById('walletEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(370)}}";
    }
    if ('{{$payStackEnable}}' == "true") {
        var payStackEnable = true;
        document.getElementById('payStackEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(371)}}";
    }else{
        var payStackEnable = false;
        document.getElementById('payStackEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(371)}}";
    }
    if ('{{$yandexKassaEnable}}' == "true") {
        var yandexKassaEnable = true;
        document.getElementById('yandexKassaEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(458)}}";      // "Enable Yandex.Kassa Payments",
    }else{
        var yandexKassaEnable = false;
        document.getElementById('yandexKassaEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(458)}}";     // "Enable Yandex.Kassa Payments",
    }
    if ('{{$instamojoEnable}}' == "true") {
        var instamojoEnable = true;
        document.getElementById('instamojoEnable').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(459)}}";      // "Enable Instamojo Payments",
    }else{
        var instamojoEnable = false;
        document.getElementById('instamojoEnable').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(459)}}";     // "Enable Instamojo Payments",
    }
    if ('{{$instamojoSandBoxMode}}' == "true") {
        var instamojoSandBoxMode = true;
        document.getElementById('instamojoSandBoxMode').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(460)}}";      // "Enable SandBox Mode",
    }else{
        var instamojoSandBoxMode = false;
        document.getElementById('instamojoSandBoxMode').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(460)}}";     // "Enable SandBox Mode",
    }

    function onCheckClick(id){
        var value = "on";
        if (id == 'StripeEnable') {
            if (StripeEnable == true) value = "off"; else value = "on";
            StripeEnable = !StripeEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(365)}}";
        }
        if (id == 'razEnable') {
            if (razEnable == true) value = "off"; else value = "on";
            razEnable = !razEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(366)}}";
        }
        if (id == 'cashEnable') {
            if (cashEnable == true) value = "off"; else value = "on";
            cashEnable = !cashEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(367)}}";
        }
        if (id == 'walletEnable') {
            if (walletEnable == true) value = "off"; else value = "on";
            walletEnable = !walletEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(370)}}";
        }
        if (id == 'payPalEnable') {
            if (payPalEnable == true) value = "off"; else value = "on";
            payPalEnable = !payPalEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(368)}}";
        }
        if (id == 'payPalSandBox') {
            if (payPalSandBox == true) value = "off"; else value = "on";
            payPalSandBox = !payPalSandBox;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(369)}}";
        }
        if (id == 'payStackEnable') {
            if (payStackEnable == true) value = "off"; else value = "on";
            payStackEnable = !payStackEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(371)}}";
        }
        if (id == 'yandexKassaEnable') {
            if (yandexKassaEnable == true) value = "off"; else value = "on";
            yandexKassaEnable = !yandexKassaEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(458)}}";      // "Enable Yandex.Kassa Payments",
        }
        if (id == 'instamojoEnable') {
            if (instamojoEnable == true) value = "off"; else value = "on";
            instamojoEnable = !instamojoEnable;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(459)}}";     // "Enable Instamojo Payments",
        }
        if (id == 'instamojoSandBoxMode') {
            if (instamojoSandBoxMode == true) value = "off"; else value = "on";
            instamojoSandBoxMode = !instamojoSandBoxMode;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(460)}}";     // "Enable SandBox Mode",
        }
    }

    function save(){
        var stripeKey = document.getElementById("stripeKey").value;
        var stripeSecretKey = document.getElementById("stripeSecretKey").value;
        if (StripeEnable){
            if (stripeKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(372)}}", "bottom", "center", "", "");
            if (stripeSecretKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(373)}}", "bottom", "center", "", "");
        }
        var razKey = document.getElementById("razKey").value;
        var razName = document.getElementById("razName").value;
        if (razEnable){
            if (razKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(374)}}", "bottom", "center", "", "");
            if (razName.length == 0)
                return showNotification("bg-red", "{{$lang->get(375)}}", "bottom", "center", "", "");
        }
        // payPal
        var payPalClientId = document.getElementById("payPalClientId").value;
        var payPalSecret = document.getElementById("payPalSecret").value;
        if (payPalEnable){
            if (payPalClientId.length == 0)
                return showNotification("bg-red", "{{$lang->get(376)}}", "bottom", "center", "", "");
            if (payPalSecret.length == 0)
                return showNotification("bg-red", "{{$lang->get(377)}}", "bottom", "center", "", "");
        }
        // payStack
        var payStackKey = document.getElementById("payStackKey").value;
        if (payStackEnable){
            if (payStackKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(378)}}", "bottom", "center", "", "");
        }
        // yandex Kassa
        var yandexKassaShopId = document.getElementById("yandexKassaShopId").value;
        var yandexKassaClientAppKey = document.getElementById("yandexKassaClientAppKey").value;
        var yandexKassaSecretKey = document.getElementById("yandexKassaSecretKey").value;
        if (yandexKassaEnable){
            if (yandexKassaShopId.length == 0)
                return showNotification("bg-red", "{{$lang->get(461)}}", "bottom", "center", "", "");       // "The Yandex.Kassa Shop Id field is required",
            if (yandexKassaClientAppKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(462)}}", "bottom", "center", "", "");       // "The Yandex.Kassa Client App Key field is required",
            if (yandexKassaSecretKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(463)}}", "bottom", "center", "", "");       // "The Yandex.Kassa Secret Key field is required",
        }
        // instamojo
        var instamojoApiKey = document.getElementById("instamojoApiKey").value;
        var instamojoPrivateToken = document.getElementById("instamojoPrivateToken").value;
        if (instamojoEnable) {
            if (instamojoApiKey.length == 0)
                return showNotification("bg-red", "{{$lang->get(464)}}", "bottom", "center", "", "");       // "The Instamojo Private Api Key field is required",
            if (instamojoPrivateToken.length == 0)
                return showNotification("bg-red", "{{$lang->get(465)}}", "bottom", "center", "", "");       // "The Instamojo Private Token field is required",
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("paymentsSave") }}',
            data: {
                StripeEnable: StripeEnable,
                stripeKey: stripeKey,
                stripeSecretKey: stripeSecretKey,
                razEnable: razEnable,
                razKey: razKey,
                razName: razName,
                cashEnable: cashEnable,
                payPalEnable: payPalEnable,
                payPalSandBox: payPalSandBox,
                payPalClientId: payPalClientId,
                payPalSecret: payPalSecret,
                walletEnable: walletEnable,
                payStackKey: payStackKey,
                payStackEnable: payStackEnable,
                yandexKassaEnable: yandexKassaEnable,
                yandexKassaShopId: yandexKassaShopId,
                yandexKassaClientAppKey: yandexKassaClientAppKey,
                yandexKassaSecretKey: yandexKassaSecretKey,
                instamojoEnable: instamojoEnable,
                instamojoSandBoxMode: instamojoSandBoxMode,
                instamojoApiKey: instamojoApiKey,
                instamojoPrivateToken: instamojoPrivateToken,
            },
            success: function (data){
                console.log(data);
                return showNotification("bg-teal", data.text, "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection
