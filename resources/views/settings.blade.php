@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')
<div class="q-card q-radius q-container">
    <div class="q-line">
        <h3 class="">{{$lang->get(27)}}</h3>
    </div>

    <div class="d-flex flex-column">

{{--        <div class="d-flex q-container2">--}}
{{--            <div class="d-flex align-items-end flex-width-30percents">--}}
{{--                <b>{{$lang->get(318)}}:</b>             --}}{{--Default tax--}}
{{--            </div>--}}
{{--            <div class="d-flex flex-column q-ml20 flex-width-70percents">--}}
{{--                <input type="number" id="tax" class="form-control" value="" min="0" max="100" step="1">--}}
{{--                <p>{{$lang->get(319)}}</p>              --}}{{--Enter default tax in percents. 10 for (10%)--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="q-line"></div>--}}

        <div class="d-flex q-container2 flex-row">
            <div class="d-flex align-items-end flex-width-30percents">
                <b>{{$lang->get(320)}}:</b>             {{--Default unit of distance--}}
            </div>
            <div class="d-flex flex-column q-ml20 flex-width-70percents">
                <select name="distanceUnit" id="distanceUnit" class="q-form show-tick ">
                    @if ($distanceUnit == 'km')
                        <option value="km" style="font-size: 16px  !important;" selected>Km</option>
                        <option value="mi" style="font-size: 16px  !important;">Miles</option>
                    @else
                        <option value="mi" style="font-size: 16px  !important;" selected>Miles</option>
                        <option value="km" style="font-size: 16px  !important;">Km</option>
                    @endif
                </select>
                <p>{{$lang->get(321)}}</p>              {{--Enter the unit of distance (must restart the app to refresh it)--}}
            </div>
        </div>

        <div class="q-line"></div>

        <div class="d-flex q-container2">
            <div class="d-flex flex-width-30percents align-items-end">
                <b>{{$lang->get(468)}}:</b>             {{--"Set Time Zone",--}}
            </div>
            <div class="d-flex flex-column q-ml20 flex-width-70percents">
                <select name="timezone" id="timezone" class="q-form show-tick" data-size="5">
                    @foreach($timezonesArray as $key => $data)
                        @if ($data == $timezone)
                            <option value="{{$data}}" style="font-size: 16px  !important;" selected>{{$data}}</option>
                        @else
                            <option value="{{$data}}" style="font-size: 16px  !important;">{{$data}}</option>
                        @endif
                    @endforeach
                </select>
                <p>{{$lang->get(469)}}</p>              {{--"Select default Time Zone for Admin Panel",--}}
            </div>
        </div>

        <div class="q-line"></div>

        <div class="d-flex q-container2">
            <div class="d-flex flex-width-30percents align-items-end">
                <b>{{$lang->get(322)}}:</b>             {{--Firebase Cloud Messaging Key--}}
            </div>
            <div class="d-flex flex-column q-ml20 flex-width-70percents">
                <input type="text" id="firebase" class="q-form">
                <p>{{$lang->get(323)}}</p>              {{--Enter Firebase Cloud Messaging Key--}}
            </div>
        </div>

        <div class="q-line"></div>

        <div class="d-flex q-container2">
            <div class="d-flex flex-width-30percents align-items-end">
                <b>{{$lang->get(567)}}:</b>             {{--Google Maps Api Key:--}}
            </div>
            <div class="d-flex flex-column q-ml20 flex-width-70percents">
                <input type="text" id="mapapikey" class="q-form">
                <p>{{$lang->get(324)}}</p>              {{--Enter Google Maps Api Key--}}
                {{$lang->get(325)}}                     {{--Create your own Google Maps API key at--}}
                <a href="https://developers.google.com/maps/gmp-get-started">https://developers.google.com/maps/gmp-get-started.</a>
                <br>
            </div>
        </div>

        <div class="q-line q-mb20"></div>

        <div class="d-flex">
            <div class="d-flex flex-width-30percents">

            </div>
            <div class="d-flex flex-width-70percents">
                <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()"><h4>{{$lang->get(142)}}</h4></div>    {{--Save--}}
            </div>
        </div>

    </div>
</div>

<script>

    // var tax = document.getElementById('tax');
    // tax.addEventListener('input',  function(e){inputHandler(e, tax, 0, 100);});

    // init parameters

    {{--document.getElementById("tax").value = "{{$tax}}" ;--}}
    document.getElementById("firebase").value = "{{$firebase}}" ;
    document.getElementById("mapapikey").value = "{{$mapapikey}}" ;

    function onSave(){
        var firebase = document.getElementById("firebase").value;
        var mapapikey = document.getElementById("mapapikey").value;
        var distanceUnit = document.getElementById("distanceUnit").value;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("settingschange") }}',
            data: {
                // tax: document.getElementById("tax").value,
                distanceUnit: distanceUnit,
                firebase: firebase,
                mapapikey : mapapikey,
                timezone: document.getElementById("timezone").value,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "Settings Saved", "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection
