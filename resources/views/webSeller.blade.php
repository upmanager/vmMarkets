@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@inject('seller', 'App\Seller')
@extends('bsb.app')

@section('content')


<div class="q-card q-radius q-container">
    <div class="header q-line q-mb20">
        <h3 class="">{{$lang->get(615)}}</h3>       {{--Seller Registration Page--}}
    </div>
    <div class="d-flex flex-column justify-content-between">


        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text1" class="q-form" value="{{$seller->getText("sellerText1")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text11" class="q-form" value="{{$seller->getText("sellerText11")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text12" class="q-form" value="{{$seller->getText("sellerText12")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text13" class="q-form" value="{{$seller->getText("sellerText13")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text14" class="q-form" value="{{$seller->getText("sellerText14")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            <div class="d-flex q-mr10 flex-width-20percents align-items-end q-label">
                <b>{{$lang->get(284)}}</b> {{--TEXT--}}
            </div>
            <div class="d-flex flex-width-70percents " >
                <input type="text" id="text20" class="q-form" value="{{$seller->getText("sellerText20")}}">
            </div>
        </div>

        <div class="d-flex q-mb20">
            @include('elements.form.imagex', array('id' => '1'))
        </div>

        <div class="d-flex q-mb20">
            @include('elements.form.imagex', array('id' => '2'))
        </div>

        <div class="d-flex q-mb20">
            @include('elements.form.imagex', array('id' => '3'))
        </div>

        <div class="d-flex q-mb20">
            @include('elements.form.imagex', array('id' => '4'))
        </div>

        <div class="d-flex q-line q-mt20">
        </div>

        <div class="d-flex q-mt10 justify-content-between" >
            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()" style="height: 50px"><h4>{{$lang->get(142)}}</h4></div>
        </div>
    </div>
</div>

<script>

    function onSave(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("webSellerSaveSettings") }}',
            data: {
                sellerText1: document.getElementById("text1").value,
                sellerText11: document.getElementById("text11").value,
                sellerText12: document.getElementById("text12").value,
                sellerText13: document.getElementById("text13").value,
                sellerText14: document.getElementById("text14").value,
                sellerText20: document.getElementById("text20").value,
                sellerImage1: imageid1,
                sellerImage2: imageid2,
                sellerImage3: imageid3,
                sellerImage4: imageid4,
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

    addEditImage1('{{$seller->getImageId("sellerImage1")}}', "{{$seller->getImageFileName("sellerImage1")}}");
    addEditImage2('{{$seller->getImageId("sellerImage2")}}', "{{$seller->getImageFileName("sellerImage2")}}");
    addEditImage3('{{$seller->getImageId("sellerImage3")}}', "{{$seller->getImageFileName("sellerImage3")}}");
    addEditImage4('{{$seller->getImageId("sellerImage4")}}', "{{$seller->getImageFileName("sellerImage4")}}");

</script>

@endsection
