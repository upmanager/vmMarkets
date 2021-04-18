@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

{{--06.02.2021--}}

<div class="q-card q-radius q-container">
    <div class="header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h3 class="">{{$lang->get(401)}}</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="d-flex flex-column">

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(402)}}</b> {{--Title Bar Color--}}
                    <input class="q-form" type="color" value="#{{$titleBarColor}}" id="titleBarColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/colorm1.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(403)}}</b> {{--Icons Color--}}
                    <input class="q-form" type="color" value="#{{$iconColorWhiteMode}}" id="iconColorWhiteMode">
                </div>
                <img class="q-mb10 q-mt10" src="img/colorm2.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(404)}}</b> {{--Markets Title Color--}}
                    <input class="q-form" type="color" value="#{{$restaurantTitleColor}}" id="restaurantTitleColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/colorm3.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(405)}}</b> {{--Restaurants Background Color--}}
                    <input class="q-form" type="color" value="#{{$restaurantBackgroundColor}}" id="restaurantBackgroundColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/colorm4.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(406)}}</b> {{--Most Popular Title Color--}}
                    <input class="q-form" type="color" value="#{{$dishesTitleColor}}" id="dishesTitleColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/mptitle.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(407)}}</b> {{--Most Popular Background Color--}}
                    <input class="q-form" type="color" value="#{{$dishesBackgroundColor}}" id="dishesBackgroundColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/mpback.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(408)}}</b> {{--Categories Title Color--}}
                    <input class="q-form" type="color" value="#{{$categoriesTitleColor}}" id="categoriesTitleColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/cattitle.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(409)}}</b> {{--Categories Background Title Color--}}
                    <input class="q-form" type="color" value="#{{$categoriesBackgroundColor}}" id="categoriesBackgroundColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/catback.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(410)}}</b> {{--Reviews Title Color--}}
                    <input class="q-form" type="color" value="#{{$reviewTitleColor}}" id="reviewTitleColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/revcolor.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(411)}}</b> {{--Reviews Background Title Color--}}
                    <input class="q-form" type="color" value="#{{$reviewBackgroundColor}}" id="reviewBackgroundColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/revbk.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(412)}}</b> {{--Search Title Color--}}
                    <input class="q-form" type="color" value="#{{$searchBackgroundColor}}" id="searchBackgroundColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/search.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row align-items-center q-line">
                <div class="d-flex flex-column flex-width-30percents">
                    <b>{{$lang->get(413)}}</b> {{--Bottom Bar Color--}}
                    <input class="q-form" type="color" value="#{{$bottomBarColor}}" id="bottomBarColor">
                </div>
                <img class="q-mb10 q-mt10" src="img/colorbb.jpg" width="400px" style="margin-left: 50px">
            </div>

            <div class="d-flex flex-row">
                <div class="d-flex flex-width-30percents q-mt10">
                    <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()" style="height: 50px"><h4>{{$lang->get(142)}}</h4></div>
                </div>
                <div class="d-flex flex-width-70percents q-mt10">
                    @include('elements.form.info', array('title' => $lang->get(555), 'body1' => $lang->get(556), 'body2' => $lang->get(557)))  {{--Attention! --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function onSave(){
        var iconColorWhiteMode = document.getElementById("iconColorWhiteMode").value;
        iconColorWhiteMode = iconColorWhiteMode.substring(1);
        var restaurantTitleColor = document.getElementById("restaurantTitleColor").value;
        restaurantTitleColor = restaurantTitleColor.substring(1);
        var restaurantBackgroundColor = document.getElementById("restaurantBackgroundColor").value;
        restaurantBackgroundColor = restaurantBackgroundColor.substring(1);
        var dishesBackgroundColor = document.getElementById("dishesBackgroundColor").value;
        dishesBackgroundColor = dishesBackgroundColor.substring(1);
        var dishesTitleColor = document.getElementById("dishesTitleColor").value;
        dishesTitleColor = dishesTitleColor.substring(1);
        var categoriesTitleColor = document.getElementById("categoriesTitleColor").value;
        categoriesTitleColor = categoriesTitleColor.substring(1);
        var categoriesBackgroundColor = document.getElementById("categoriesBackgroundColor").value;
        categoriesBackgroundColor = categoriesBackgroundColor.substring(1);
        var searchBackgroundColor = document.getElementById("searchBackgroundColor").value;
        searchBackgroundColor = searchBackgroundColor.substring(1);
        var reviewTitleColor = document.getElementById("reviewTitleColor").value;
        reviewTitleColor = reviewTitleColor.substring(1);
        var reviewBackgroundColor = document.getElementById("reviewBackgroundColor").value;
        reviewBackgroundColor = reviewBackgroundColor.substring(1);
        var bottomBarColor = document.getElementById("bottomBarColor").value;
        bottomBarColor = bottomBarColor.substring(1);
        var titleBarColor = document.getElementById("titleBarColor").value;
        titleBarColor = titleBarColor.substring(1);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("caLayout_changeColors") }}',
            data: {
                iconColorWhiteMode: iconColorWhiteMode,
                restaurantTitleColor: restaurantTitleColor,
                restaurantBackgroundColor : restaurantBackgroundColor,
                dishesBackgroundColor: dishesBackgroundColor,
                dishesTitleColor: dishesTitleColor,
                categoriesTitleColor : categoriesTitleColor,
                categoriesBackgroundColor : categoriesBackgroundColor,
                searchBackgroundColor : searchBackgroundColor,
                reviewTitleColor : reviewTitleColor,
                reviewBackgroundColor : reviewBackgroundColor,
                bottomBarColor : bottomBarColor,
                titleBarColor : titleBarColor,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(414)}}", "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection
