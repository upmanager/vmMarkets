@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

{{--12.02.2021--}}

<div class="q-card q-radius q-container">
    <div class="header q-line q-mb20">
        <h3 class="">{{$lang->get(604)}}</h3>       {{--Admin Panel Settings--}}
    </div>
    <div class="d-flex flex-column justify-content-between">
        <div class="d-flex q-mb20 ">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(382)}}</b> {{--Main Color--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input class="q-form" type="color" value="#{{$ap_mainColor}}" id="ap_mainColor">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(607)}}</b> {{--Second Color--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input class="q-form" type="color" value="#{{$ap_secondColor}}" id="ap_secondColor">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(606)}}</b> {{--Alert color--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input class="q-form" type="color" value="#{{$ap_alertColor}}" id="ap_alertColor">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(383)}}</b> {{--Radius--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input type="number" id="ap_radius" class="q-form" value="{{$ap_radius}}">
            </div>
        </div>

        <div class="d-flex q-line q-mt20">
        </div>

        <div class="d-flex q-mt10 justify-content-between" >
            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()" style="height: 50px"><h4>{{$lang->get(142)}}</h4></div>
            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onRestore()" style="height: 50px"><h4>{{$lang->get(605)}}</h4></div> {{--Restore settings--}}
        </div>
    </div>

    <div class="q-line q-mt50"></div>

    <form id="form" method="post" action="{{url('settingsSetLang')}}"  >
        @csrf

        <div class="d-flex q-container flex-row align-items-center ">
            <div class="d-flex flex-width-30percents align-items-end">
                <b>{{$lang->get(436)}}:</b>             {{--Select Language for Admin Panel--}}
            </div>
            <div class="d-flex flex-column q-ml20 flex-width-70percents">
                <select name="newLang" id="newLang" class="q-form bs-searchbox " >
                    @foreach($langs as $key => $data)
                        @if ($defLang == $data["file"])
                            <option value="{{$data['file']}}" selected style="font-size: 18px  !important;" >{{$data["name"]}} - {{$data["name2"]}}</option>
                        @else
                            <option value="{{$data['file']}}" style="font-size: 18px  !important;">{{$data["name"]}} - {{$data["name2"]}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="d-flex q-ml20 flex-width-30percents">
                <div class="d-flex">
                    <button type="submit" class="q-btn-all q-color-second-bkg waves-effect "><h5>{{$lang->get(437)}}</h5></button>
                </div>
            </div>
        </div>

    </form>

</div>

<script>

    function onRestore(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("apRestoreSettings") }}',
            data: {
            },
            success: function (data){
                console.log(data);
                window.location.reload(true);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function onSave(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("apSaveSettings") }}',
            data: {
                ap_mainColor: document.getElementById("ap_mainColor").value.substring(1),
                ap_secondColor: document.getElementById("ap_secondColor").value.substring(1),
                ap_alertColor: document.getElementById("ap_alertColor").value.substring(1),
                ap_radius: document.getElementById("ap_radius").value,
            },
            success: function (data){
                console.log(data);
                window.location.reload(true);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection
