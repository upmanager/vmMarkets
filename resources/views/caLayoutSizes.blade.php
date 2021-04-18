@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

{{--06.02.2021--}}

<div class="q-card q-radius q-container">
    <div class="header q-line">
        <h3 class="">{{$lang->get(415)}}</h3>
    </div>
    <div class="body">

        <div class="card">
            <body>
            <div class="table-responsive" style="margin-left: 5%; margin-top: 5%; margin-right: 5%; ">
                <table style="margin-bottom: 5%;">
                    <tbody id="tbody">

{{--Restaurants--}}
                    <tr>
                        <td>
                            <b>{{$lang->get(416)}}:</b>     {{--Market card width--}}
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="restaurantCardWidth" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(417)}}</p>
                            </div>
                            <b>{{$lang->get(418)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="restaurantCardHeight" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(417)}}</p>
                            </div>
                        </td>
                        <td width="20%"></td>
                        <td>
                            <img src="img/sizesm1.jpg" width="600px">
                        </td>
                    </tr>

{{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

{{--Top Restaurants--}}

                    <tr>
                        <td>
                            <b>{{$lang->get(419)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="topRestaurantCardHeight" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(420)}}</p>
                            </div>
                        </td>
                        <td width="20%"></td>
                        <td>
                            <img src="img/sizesm2.jpg" width="600px">
                        </td>
                    </tr>

{{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

{{--Food--}}

                    <tr>
                        <td>
                            <b>{{$lang->get(1)}}:</b>
                            <div id="FoodCardType1" onclick="onCheckClick('FoodCardType1')" style="font-weight: bold; "></div>
                            <br>
                            <div id="FoodCardType2" onclick="onCheckClick('FoodCardType2')" style="font-weight: bold; "></div>
                            <br>
                            <div id="oneInLine" onclick="onCheckClick('oneInLine')" style="font-weight: bold; "></div>
                            <br>
                            <b>{{$lang->get(421)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="dishesCardHeight" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(422)}}</p>
                            </div>
                        </td>
                        <td width="20%"></td>
                        <td>
                            <img src="img/sizesf.jpg" width="600px"><br>
                            <img src="img/sizesf2.jpg" width="600px">
                        </td>
                    </tr>

{{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

{{--Category--}}
                    <tr>
                        <td>
                            <b>{{$lang->get(90)}}:</b>
                            <div id="categoryCardCircle" onclick="onCheckClick('categoryCardCircle')" style="font-weight: bold; "></div>
                            <br>
                            <b>{{$lang->get(423)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="categoryCardWidth" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(417)}}</p>
                            </div>
                            <b>{{$lang->get(424)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="categoryCardHeight" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(417)}}</p>
                            </div>
                        </td>
                        <td width="20%"></td>
                        <td>
                            <img src="img/sizescat.jpg" width="600px">
                            <br>
                            <img src="img/sizescat2.jpg" width="600px">
                        </td>
                    </tr>

{{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

{{--text color and size--}}
                    <tr>
                        <td>
                            <b>{{$lang->get(425)}}:</b>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="number" id="restaurantCardTextSize" class="q-form" value="" min="0" max="100" step="1">
                                </div>
                                <p>{{$lang->get(426)}}</p>
                            </div>
                            <b>{{$lang->get(427)}}</b>
                                <input type="color" id="restaurantCardTextColor" value="#{{$restaurantCardTextColor}}" class="q-form" >
                        </td>
                        <td width="20%"></td>
                        <td>
                            <img src="img/sizesm3.jpg" width="600px">
                        </td>
                    </tr>

{{--line--}}        <tr><td><hr></td><td><hr></td><td><hr></td></tr>

{{--Save Button--}}
                    <tr>
                        <td></td>
                        <td>
                            <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()"><h4>{{$lang->get(142)}}</h4></div>
                        </td>
                        <td>
                            @include('elements.form.info', array('title' => $lang->get(555), 'body1' => $lang->get(556), 'body2' => $lang->get(557)))  {{--Attention! --}}
                        </td>
                    </tr>

                    </tbody>
                </table>

            </div>
            </body>

        </div>
</div>

<script>

    var restaurantCardWidth = document.getElementById('restaurantCardWidth');
    restaurantCardWidth.addEventListener('input',  function(e){inputHandler(e, restaurantCardWidth, 0, 100);});
    var restaurantCardHeight = document.getElementById('restaurantCardHeight');
    restaurantCardHeight.addEventListener('input',  function(e){inputHandler(e, restaurantCardHeight, 0, 100);});
    var dishesCardHeight = document.getElementById('dishesCardHeight');
    dishesCardHeight.addEventListener('input',  function(e){inputHandler(e, dishesCardHeight, 0, 100);});
    var categoryCardWidth = document.getElementById('categoryCardWidth');
    categoryCardWidth.addEventListener('input',  function(e){inputHandler(e, categoryCardWidth, 0, 100);});
    var categoryCardHeight = document.getElementById('categoryCardHeight');
    categoryCardHeight.addEventListener('input',  function(e){inputHandler(e, categoryCardHeight, 0, 100);});
    var topRestaurantCardHeight = document.getElementById('topRestaurantCardHeight');
    topRestaurantCardHeight.addEventListener('input',  function(e){inputHandler(e, topRestaurantCardHeight, 0, 100);});
    var restaurantCardTextSize = document.getElementById('restaurantCardTextSize');
    restaurantCardTextSize.addEventListener('input',  function(e){inputHandler(e, restaurantCardTextSize, 0, 30);});
    //document.getElementById("restaurantCardTextColor").value = "{{$restaurantCardTextColor}}" ;

    // set initial parameters
    document.getElementById("restaurantCardWidth").value = "{{$restaurantCardWidth}}" ;
    document.getElementById("restaurantCardHeight").value = "{{$restaurantCardHeight}}" ;
    document.getElementById("dishesCardHeight").value = "{{$dishesCardHeight}}" ;
    document.getElementById("categoryCardWidth").value = "{{$categoryCardWidth}}" ;
    document.getElementById("categoryCardHeight").value = "{{$categoryCardHeight}}" ;
    document.getElementById("topRestaurantCardHeight").value = "{{$topRestaurantCardHeight}}" ;
    document.getElementById("restaurantCardTextSize").value = "{{$restaurantCardTextSize}}" ;

    idFoodCardType1 = false;
    document.getElementById("FoodCardType1").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
    idFoodCardType2 = false;
    document.getElementById("FoodCardType2").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
    @if ($typeFoods == 'type1')
        idFoodCardType1 = true;
        document.getElementById("FoodCardType1").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
        document.getElementById("oneInLine").style.opacity = 1;
    @endif
    @if ($typeFoods == 'type2')
        idFoodCardType2 = true;
        document.getElementById("FoodCardType2").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
        document.getElementById("oneInLine").style.opacity = 0;
    @endif

    function onSave(){
        var restaurantCardWidth = document.getElementById("restaurantCardWidth").value;
        if (restaurantCardWidth < 20) {
            restaurantCardWidth = 20;
            document.getElementById('restaurantCardWidth').value = 20;
        }
        var restaurantCardHeight = document.getElementById("restaurantCardHeight").value;
        if (restaurantCardHeight < 20) {
            restaurantCardHeight = 20;
            document.getElementById('restaurantCardHeight').value = 20;
        }
        var dishesCardHeight = document.getElementById('dishesCardHeight').value;
        if (dishesCardHeight < 30) {
            dishesCardHeight = 30;
            document.getElementById('dishesCardHeight').value = 30;
        }
        var categoryCardWidth = document.getElementById("categoryCardWidth").value;
        if (categoryCardWidth < 20) {
            categoryCardWidth = 20;
            document.getElementById('categoryCardWidth').value = 20;
        }
        var categoryCardHeight = document.getElementById("categoryCardHeight").value;
        if (categoryCardHeight < 20) {
            categoryCardHeight = 20;
            document.getElementById('categoryCardHeight').value = 20;
        }
        var topRestaurantCardHeight = document.getElementById('topRestaurantCardHeight').value;
        if (topRestaurantCardHeight < 35) {
            topRestaurantCardHeight = 35;
            document.getElementById('topRestaurantCardHeight').value = 35;
        }
        var restaurantCardTextSize = document.getElementById('restaurantCardTextSize').value;
        if (restaurantCardTextSize < 10) {
            restaurantCardTextSize = 10;
            document.getElementById('restaurantCardTextSize').value = 10;
        }
        var restaurantCardTextColor = document.getElementById("restaurantCardTextColor").value;
        restaurantCardTextColor = restaurantCardTextColor.substring(1);

        var oneInLine = "false";
        if (idOneInLine)
            oneInLine = "true";
        var categoryCardCircle = "false";
        if (idCategoryCardCircle)
            categoryCardCircle = "true";

        var foodType = "type1"
        if (idFoodCardType2)
            foodType = "type2"

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("caLayoutSizeChange") }}',
            data: {
                restaurantCardWidth: restaurantCardWidth,
                restaurantCardHeight: restaurantCardHeight,
                dishesCardHeight: dishesCardHeight,
                oneInLine: oneInLine,
                categoryCardWidth: categoryCardWidth,
                categoryCardHeight: categoryCardHeight,
                categoryCardCircle: categoryCardCircle,
                topRestaurantCardHeight: topRestaurantCardHeight,
                restaurantCardTextSize: restaurantCardTextSize,
                restaurantCardTextColor: restaurantCardTextColor,
                typeFoods: foodType,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(568)}}", "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    var idOneInLine = false;
    @if ($oneInLine == 'false')
        idOneInLine = true;
    @endif
    var idCategoryCardCircle = false;
    @if ($categoryCardCircle == 'false')
        idCategoryCardCircle = true;
    @endif

    onCheckClick("oneInLine");
    onCheckClick("categoryCardCircle");

    function onCheckClick(id){
        var value = "on";
        if (id == 'oneInLine') {
            if (idOneInLine == true) value = "off"; else value = "on";
            idOneInLine = !idOneInLine;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(428)}}";
        }
        if (id == 'categoryCardCircle') {
            if (idCategoryCardCircle == true) value = "off"; else value = "on";
            idCategoryCardCircle = !idCategoryCardCircle;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(429)}}";
        }
        if (id == 'FoodCardType1') {
            if (idFoodCardType1 == true) value = "off"; else value = "on";
            idFoodCardType1 = !idFoodCardType1;
            console.log(value);
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
            if (idFoodCardType1){
                idFoodCardType2 = false;
                document.getElementById("FoodCardType2").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
                document.getElementById("oneInLine").style.opacity = 1;
            }else{
                idFoodCardType2 = true;
                document.getElementById("FoodCardType2").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
                document.getElementById("oneInLine").style.opacity = 0;
            }
        }
        if (id == 'FoodCardType2') {
            if (idFoodCardType2 == true) value = "off"; else value = "on";
            idFoodCardType2 = !idFoodCardType2;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(389)}}";
            if (idFoodCardType2){
                idFoodCardType1 = false;
                document.getElementById("FoodCardType1").innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
                document.getElementById("oneInLine").style.opacity = 0;
            }else{
                idFoodCardType1 = true;
                document.getElementById("FoodCardType1").innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(388)}}";
                document.getElementById("oneInLine").style.opacity = 1;
            }
        }

    }

</script>

@endsection

