@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')

<div class="q-card q-radius q-container">
    <div class="header q-line">
        <h3 class="">{{$lang->get(31)}}</h3> {{--General--}}
    </div>
    <body>
        <div class="table-responsive" style="margin-left: 5%; margin-top: 5%; margin-right: 5%;">
            <table style="margin-bottom: 5%;">
                <tbody id="tbody">

                {{--languages--}}
                <tr>
                    <td width="50%">
                        <b>{{$lang->get(380)}}:</b>
                        <div class="input-group q-mt5">
                            <select name="appLanguage" id="appLanguage" class="q-form show-tick q-mb5">
                                @if ($appLanguage == '1')
                                <option value="1" style="font-size: 16px !important;" selected>English</option>
                                @else
                                <option value="1" style="font-size: 16px !important;">English</option>
                                @endif
                                @if ($appLanguage == '2')
                                <option value="2" style="font-size: 16px !important;" selected>German</option>
                                @else
                                <option value="2" style="font-size: 16px !important;">German</option>
                                @endif
                                @if ($appLanguage == '3')
                                <option value="3" style="font-size: 16px !important;" selected>Spanish</option>
                                @else
                                <option value="3" style="font-size: 16px !important;">Spanish</option>
                                @endif
                                @if ($appLanguage == '4')
                                <option value="4" style="font-size: 16px !important;" selected>French</option>
                                @else
                                <option value="4" style="font-size: 16px !important;">French</option>
                                @endif
                                @if ($appLanguage == '5')
                                <option value="5" style="font-size: 16px !important;" selected>Korean</option>
                                @else
                                <option value="5" style="font-size: 16px !important;">Korean</option>
                                @endif
                                @if ($appLanguage == '6')
                                <option value="6" style="font-size: 16px !important;" selected>Arabic</option>
                                @else
                                <option value="6" style="font-size: 16px !important;">Arabic</option>
                                @endif
                                @if ($appLanguage == '7')
                                <option value="7" style="font-size: 16px !important;" selected>Portuguese</option>
                                @else
                                <option value="7" style="font-size: 16px !important;">Portuguese</option>
                                @endif
                            </select>
                            <label class="font-12 font-bold"><p>{{$lang->get(381)}}</p></label>
                        </div>
                    </td>
                    <td width="20%">
                    </td>
                    <td width="30%">
                        <div style="margin-left: 30px">
                            @include('elements.form.check', array('id' => "about", 'text' => $lang->get(517), 'initvalue' => $about)) {{--Enable About Us Page--}}
                            @include('elements.form.check', array('id' => "delivery", 'text' => $lang->get(518), 'initvalue' => $delivery)) {{--Enable Delivery info Page--}}
                            @include('elements.form.check', array('id' => "privacy", 'text' => $lang->get(519), 'initvalue' => $privacy)) {{--Enable Privacy Policy Page--}}
                            @include('elements.form.check', array('id' => "terms", 'text' => $lang->get(520), 'initvalue' => $terms)) {{--Enable Terms and Condition Page--}}
                            @include('elements.form.check', array('id' => "refund", 'text' => $lang->get(521), 'initvalue' => $refund)) {{--Enable Refund Policy Page--}}
                            @include('elements.form.check', array('id' => "faq", 'text' => $lang->get(522), 'initvalue' => $faq)) {{--Enable FAQ Page--}}
                        </div>
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>


                <tr>
                    <td>
                        @include('elements.form.check', array('id' => "google", 'text' => $lang->get(533), 'initvalue' => $google)) {{--Enable Google Sign In--}}
                        @include('elements.form.check', array('id' => "facebook", 'text' => $lang->get(534), 'initvalue' => $facebook)) {{--Enable Facebook Sign In--}}
                        @include('elements.form.check', array('id' => "otp", 'text' => $lang->get(540), 'initvalue' => $otp)) {{--Enable Phone Verification by SMS (OTP)--}}
                    </td>
                    <td width="20%"></td>
                    <td>
                        @include('elements.form.check', array('id' => "delivering", 'text' => $lang->get(542), 'initvalue' => $delivering)) {{--Enable Delivering--}}
                        @include('elements.form.check', array('id' => "curbsidePickup", 'text' => $lang->get(541), 'initvalue' => $curbsidePickup)) {{--Enable Curbside Pickup--}}
                        @include('elements.form.check', array('id' => "coupon", 'text' => $lang->get(543), 'initvalue' => $coupon)) {{--Enable Coupons--}}
                        @include('elements.form.check', array('id' => "deliveringTime", 'text' => $lang->get(544), 'initvalue' => $deliveringTime)) {{--Enable Delivering Time--}}
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                <tr>
                    <td colspan="2">
                        <h4 style="margin-bottom: 30px;">{{$lang->get(535)}}</h4>  {{--Default position on map in Application--}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        @include('elements.form.latlang', array('id' => "defaultLat", 'label' => $lang->get(165),
                        'text' => $lang->get(166), 'initvalue' => $defaultLat, 'request' => "false")) {{--Latitude - Insert Latitude. Example: 52.2165157 --}}
                        @include('elements.form.latlang', array('id' => "defaultLng", 'label' => $lang->get(167),
                        'text' => $lang->get(168), 'initvalue' => $defaultLng, 'request' => "false")) {{--Longitude - Insert Longitude. Example: 2.331359 --}}
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--dark mode--}}
                <tr>
                    <td>
                        <div id="dark" onclick="onCheckClick('dark')" style="font-weight: bold; "></div>
                    </td>
                    <td width="20%"></td>
                    <td>
                        <img src="img/dark.jpg" width="400px">
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--Main Color--}}
                <tr>
                    <td>
                        <b>{{$lang->get(382)}}</b>
                        <input class="q-form" type="color" value="#{{$mainColor}}" id="mainColor">
                    </td>
                    <td width="20%"></td>
                    <td>
                        <img src="img/maincolor.jpg" width="400px">
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--Radius--}}
                <tr>
                    <td>
                        <b>{{$lang->get(383)}}</b>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="number" id="radius" class="q-form" value="" min="0" max="50" step="1">
                            </div>
                            <p>{{$lang->get(384)}}</p>
                        </div>
                    </td>
                    <td width="20%"></td>
                    <td>
                        <img src="img/radius.jpg" width="400px">
                    </td>
                </tr>

                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--shadow--}}
                <tr>
                    <td>
                        <b>{{$lang->get(385)}}</b>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="number" id="shadow" class="q-form" value="" min="0" max="50" step="1">
                            </div>
                            <p>{{$lang->get(386)}}</p>
                        </div>
                    </td>
                    <td width="20%"></td>
                    <td>
                        <img src="img/shadow.jpg" width="600px">
                    </td>
                </tr>


                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--bottom bar type--}}
                <tr>
                    <td>
                        <div id="bottomBarType1" onclick="onCheckClick('bottomBarType1')" style="font-weight: bold; "></div>
                        <br>
                        <div id="bottomBarType2" onclick="onCheckClick('bottomBarType2')" style="font-weight: bold; "></div>
                    </td>
                    <td width="20%"></td>
                    <td>
                        <img src="img/btypes.jpg" width="600px">
                    </td>
                </tr>


                {{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

                {{--save button--}}
                <tr>
                    <td></td>
                    <td>
                        <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()"><h4>{{$lang->get(142)}}</h4></div>
                    </td>
                    <td>
                        @include('elements.form.info', array('title' => $lang->get(555), 'body1' => $lang->get(556), 'body2' => $lang->get(557)))  {{--Attention! - --}}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </body>
</div>

<script>

    var radius = document.getElementById('radius');
    radius.addEventListener('input',  function(e){inputHandler(e, radius, 0, 100);});
    var shadow = document.getElementById('shadow');
    shadow.addEventListener('input',  function(e){inputHandler(e, shadow, 0, 250);});

    // set initial parameters
    document.getElementById("radius").value = "{{$radius}}" ;
    document.getElementById("shadow").value = "{{$shadow}}" ;

    function onSave(){
        var mainColor = document.getElementById("mainColor").value;
        mainColor = mainColor.substring(1);
        var radius = document.getElementById("radius").value;
        var shadow = document.getElementById("shadow").value;
        var dark = "false";
        if (idStateDark)
            dark = "true";
        var bottomBarType = "type1"
        if (idbottomBarType2)
            bottomBarType = "type2"
        var appLanguage = document.getElementById("appLanguage").value;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("caLayout_changeTheme") }}',
            data: {
                appLanguage: appLanguage,
                mainColor: mainColor,
                radius: radius,
                shadow: shadow,
                dark: dark,
                bottomBarType: bottomBarType,
                about: about,
                delivery: delivery,
                privacy: privacy,
                terms: terms,
                refund: refund,
                faq: faq,
                otp: otp,
                delivering: delivering,
                curbsidePickup: curbsidePickup,
                coupon: coupon,
                deliveringTime: deliveringTime,
                google: google,
                facebook: facebook,
                defaultLat: document.getElementById("defaultLat").value,
                defaultLng: document.getElementById("defaultLng").value,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(387)}}", "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    // $(function () {
    //     $('.colorpicker').colorpicker(
    //         {format: 'hex'}
    //     );
    // });

    function inputHandler(e, parent, min, max) {
        var value = parseInt(e.target.value);
        if (value.isEmpty)
            value = 0;
        if (isNaN(value))
            value = 0;
        if (value > max)
            value = max;
        if (value < min)
            value = min;
        parent.value = value;
    }

    var idStateDark = false;
    @if ($darkMode == 'false')
    idStateDark = true;
    @endif
    onCheckClick("dark");

    idbottomBarType1 = false;
    document.getElementById("bottomBarType1").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
    idbottomBarType2 = false;
    document.getElementById("bottomBarType2").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
    @if ($bottomBarType == 'type1')
    idbottomBarType1 = true;
    document.getElementById("bottomBarType1").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
    @endif
    @if ($bottomBarType == 'type2')
    idbottomBarType2 = true;
    document.getElementById("bottomBarType2").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
    @endif

    function onCheckClick(id){
        var value = "on";
        if (id == 'dark') {
            if (idStateDark == true) value = "off"; else value = "on";
            idStateDark = !idStateDark;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(390)}}";
        }
        if (id == 'bottomBarType1') {
            if (idbottomBarType1 == true) value = "off"; else value = "on";
            idbottomBarType1 = !idbottomBarType1;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
            if (idbottomBarType1){
                idbottomBarType2 = false;
                document.getElementById("bottomBarType2").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
            }else{
                idbottomBarType2 = true;
                document.getElementById("bottomBarType2").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
            }
        }
        if (id == 'bottomBarType2') {
            if (idbottomBarType2 == true) value = "off"; else value = "on";
            idbottomBarType2 = !idbottomBarType2;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
            if (idbottomBarType2){
                idbottomBarType1 = false;
                document.getElementById("bottomBarType1").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
            }else{
                idbottomBarType1 = true;
                document.getElementById("bottomBarType1").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
            }
        }
    }


</script>

@endsection
