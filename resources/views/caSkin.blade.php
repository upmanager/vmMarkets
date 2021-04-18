@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@inject('theme', 'App\Theme')
@extends('bsb.app')

@section('content')

<div class="q-card q-radius q-container">
    <div class="header q-line">
        <h3 class="">{{$lang->get(613)}}</h3> {{--Application Skin--}}
    </div>
    <body>
        <div class="container">
            <div class="d-flex flex-column">
                <div class="d-flex q-mt20 q-pb20 q-line">
                    <img src="img/skins.jpg">
                </div>

                <div class="d-flex q-mt20 flex-row align-items-center">
                    <canvas id="radio1" width="25" height="25" onclick="onRadioClick(1);"></canvas>
                    <div class="q-ml10 q-font-16 q-font-bold">{{$lang->get(512)}} 1</div>  {{--Type 1--}}
                </div>
                <div class="d-flex q-mt20 flex-row align-items-center ">
                    <canvas id="radio2" width="25" height="25" onclick="onRadioClick(2);"></canvas>
                    <div class="q-ml10 q-font-16 q-font-bold">{{$lang->get(512)}} 2</div>  {{--Type 2--}}
                </div>

                <div class="d-flex q-mb20 q-pb20 q-line"></div>

                <div class="d-flex flex-row ">
                    <div class="d-flex flex-column">
                        <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()"><h4>{{$lang->get(142)}}</h4></div>
                    </div>
                    <div class="d-flex flex-column flex-width-20percents">
                    </div>
                    <div class="d-flex">
                        @include('elements.form.info', array('title' => $lang->get(555), 'body1' => $lang->get(556), 'body2' => $lang->get(557)))  {{--Attention! - --}}
                    </div>
                </div>

            </div>
        </div>
    </body>
</div>

<script>

    var arraySkin = [];

    arraySkin.push({
        id: 1,
        select:
        @if ($skin == "basic")
            true
        @else
            false
        @endif
    });
    arraySkin.push({
        id: 2,
        select:
        @if ($skin == "smarter")
            true
        @else
            false
        @endif
    });

    var selectedItem = "";

    function onRadioClick(id){
        selectedItem = id;
        arraySkin.forEach(function(item, i, arr) {
            item.select = false;
            if (item.id == id)
                item.select = true;
        });
        drawRadios();
    }

    function drawRadios(){
        arraySkin.forEach(function(item, i, arr) {
            drawRadio(`radio${item.id}`, item.select, "#{{$theme->getMainColor()}}");
        });
    }

    function drawRadio(id, check, color){
        var intElemOffsetHeight = document.getElementById(id).offsetHeight;
        var canvas = document.getElementById(id);
        if (canvas == null)
            return;
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(0, 0, intElemOffsetHeight, intElemOffsetHeight);

        ctx.beginPath();
        ctx.lineWidth=2;
        ctx.strokeStyle=color;
        ctx.arc(intElemOffsetHeight/2,intElemOffsetHeight/2,10,0,12);
        ctx.stroke();
        if (check) {
            ctx.beginPath();
            ctx.arc(intElemOffsetHeight/2, intElemOffsetHeight/2, 5, 0, 12);
            ctx.fillStyle = color;
            ctx.fill();
        }
    }
    drawRadios();

    function onSave(){
        var type = "basic";
        if (arraySkin[1].select)
            type = "smarter";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("caSkin_set") }}',
            data: {
                skin: type,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(614)}}", "bottom", "center", "", "");  // Skin Saved
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection
