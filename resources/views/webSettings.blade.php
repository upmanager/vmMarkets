@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

{{--16.02.2021--}}

<div class="q-card q-radius q-container">
    <div class="header q-line q-mb20">
        <h3 class="">{{$lang->get(609)}}</h3>       {{--Web Site Settings--}}
    </div>
    <div class="d-flex flex-column justify-content-between">
        <div class="d-flex q-mb20 ">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(382)}}</b> {{--Main Color--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input class="q-form" type="color" value="#{{$web_mainColor}}" id="web_mainColor">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(610)}}</b> {{--Main Color Hover--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input class="q-form" type="color" value="#{{$web_mainColorHover}}" id="web_mainColorHover">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(383)}}</b> {{--Radius--}}
            </div>
            <div class="d-flex " style="width: 200px">
                <input type="number" id="web_radius" class="q-form" value="{{$web_radius}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            @include('elements.form.image', array())
        </div>

        <div class="d-flex q-line q-mt20">
        </div>

        <div class="d-flex q-mt10 justify-content-between" >
            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()" style="height: 50px"><h4>{{$lang->get(142)}}</h4></div>
            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onRestore()" style="height: 50px"><h4>{{$lang->get(605)}}</h4></div> {{--Restore settings--}}
        </div>
    </div>
</div>

<script>

    function onRestore(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("webRestoreSettings") }}',
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
            url: '{{ url("webSaveSettings") }}',
            data: {
                web_mainColor: document.getElementById("web_mainColor").value.substring(1),
                web_mainColorHover: document.getElementById("web_mainColorHover").value.substring(1),
                web_radius: document.getElementById("web_radius").value,
                web_logo: imageid
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    addEditImage('{{$web_logo}}', "{{$web_filename}}");

</script>

@endsection
