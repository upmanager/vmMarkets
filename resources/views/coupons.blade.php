@inject('userinfo', 'App\UserInfo')
@inject('currency', 'App\Currency')
@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')

<!-- Multi Select Css -->
<link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">
<!-- Multi Select Plugin Js -->
<script src="plugins/multi-select/js/jquery.multi-select.js"></script>

<div class="q-card q-radius q-container">

    <!-- Tabs -->

    <ul id="tabs" class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
        <li role="presentation"><a href="#create" data-toggle="tab" ><h4>{{$lang->get(65)}}</h4></a></li>
        <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header q-line q-mb20">
                            <h3>
                                {{$lang->get(255)}}
                            </h3>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(256)}}</th>
                                        <th>{{$lang->get(257)}}</th>
                                        <th>{{$lang->get(258)}}</th>
                                        <th>{{$lang->get(259)}}</th>
                                        <th>{{$lang->get(260)}}</th>
                                        <th>{{$lang->get(73)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(256)}}</th>
                                        <th>{{$lang->get(257)}}</th>
                                        <th>{{$lang->get(258)}}</th>
                                        <th>{{$lang->get(259)}}</th>
                                        <th>{{$lang->get(260)}}</th>
                                        <th>{{$lang->get(73)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody id="table">

                                        @foreach($coupons as $key => $data)
                                            <tr id="tr{{$data->id}}">
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>

                                                <td>
                                                    @if ($data->inpercents == '1')
                                                        {{$data->discount}}%
                                                    @else
                                                        {{$currency->makePrice($data->discount)}}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{$data->amount}}
                                                </td>

                                                <td>
                                                    {{$data->dateStart}}
                                                </td>

                                                <td>
                                                    {{$data->dateEnd}}
                                                </td>

                                                <td>
                                                    @if ($data->published == "1")
                                                        <img src="img/iconyes.png" width="40px">
                                                    @else
                                                        <img src="img/iconno.png" width="40px">
                                                    @endif
                                                </td>

                                                <td>

                                                    <button type="button" class="q-btn-all q-color-second-bkg waves-effect"
                                                            onclick="editItem('{{$data->id}}')">
                                                        {{$lang->get(564)}} {{--Edit--}}
                                                    </button>

                                                    <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage2('{{$data->id}}')">
                                                        <div>{{$lang->get(308)}}</div> {{--Delete--}}
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- End Tab List -->

        <!-- Tab Create -->

        <div role="tabpanel" class="tab-pane fade" id="create">

            <div id="form" class="row clearfix">

                <div class="col-md-12 foodm q-mt20 q-mb20">

                    <div class="col-md-12 foodm">
                        <div class="col-md-6 foodm">
                            @include('elements.form.text', array('label' => $lang->get(256), 'text' => $lang->get(91), 'id' => "name", 'request' => "true", 'maxlength' => "40"))  {{-- Coupon code - Insert Name --}}
                        </div>
                        <div class="col-md-6 foodm">
                            <div id="published" style="display:inline-block;font-weight: bold; margin-left: 50px" onclick="onCheckClick('published')"  ></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-5">
                            @include('elements.form.number', array('label' => $lang->get(257), 'text' => $lang->get(261), 'id' => "discount", 'request' => "false", 'min' => "0", 'max' => "1000000"))   {{--Discount - Number of item per package (ex: 1, 6, 10)--}}
                        </div>
                        <div class="col-md-2 foodm">
                            <div id="inpercents" onclick="onCheckClick('inpercents')" style="font-weight: bold; "></div>
                        </div>
                        <div class="col-md-5">
                            @include('elements.form.number', array('label' => $lang->get(262), 'text' => $lang->get(263), 'id' => "amount", 'request' => "false", 'min' => "0", 'max' => "1000000"))   {{-- --}}
                        </div>
                    </div>

                    @include('elements.form.text', array('label' => $lang->get(71), 'text' => $lang->get(76) . ". " . $lang->get(264), 'id' => "desc", 'request' => "false", 'maxlength' => "250"))  {{-- Description --}}

                    <div class="col-md-12 foodm">
                        <div class="col-md-2 foodm">
                            <h4 align="right">{{$lang->get(265)}}: </h4>
                        </div>
                        <div class="col-md-3">
                            <input id="datetime1" type="datetime-local" class="q-form">
                        </div>
                        <div class="col-md-2 foodm">
                            <h4 align="right">{{$lang->get(266)}}: <span class="q-color-alert2">*</span></h4>
                        </div>
                        <div class="col-md-3 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input id="datetime2" type="datetime-local" class="q-form">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 foodm" style="margin-top: 20px;">
                        <hr>
                        <div class="col-md-12 foodm">
                            <div class="col-md-6 foodm">
                                <label for="categoryGroup"><h4>{{$lang->get(268)}}</h4></label>
                            </div>
                            <div class="col-md-6">
                                <div id="allCategoryGroup" style="font-weight: bold;" onclick="onCheckClick('allCategoryGroup')"  ></div>
                            </div>
                        </div>
                        <select id="categoryGroup" class="ms" multiple="multiple">
                            <optgroup label="{{$lang->get(396)}}">    <!--Categories-->
                                @foreach($categories as $key => $idata)
                                    <option value="{{$idata->id}}" style="font-size: 16px  !important;">{{$idata->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>


                    <div class="col-md-12 foodm" style="margin-top: 20px;">
                        <hr>
                        <div class="col-md-12 foodm">
                            <div class="col-md-6 foodm">
                                <label for="foodsGroup"><h4>{{$lang->get(269)}}</h4></label>        {{--Coupon for Products--}}
                            </div>
                            <div class="col-md-6 foodm">
                                <div id="allFoodsGroup" style="font-weight: bold;" onclick="onCheckClick('allFoodsGroup')"  ></div>
                            </div>
                        </div>
                        <div class="col-md-12 foodm">
                            <select id="foodsGroup" class="ms" multiple="multiple">
                                <optgroup label="{{$lang->get(3)}}">    <!--Products-->
                                    @foreach($foods as $key => $idata)
                                        <option value="{{$idata->id}}" style="font-size: 16px  !important;">{{$idata->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-md-12 form-control-label">
                        <hr>
                        <div align="center">
                            <button type="button" onclick="save();" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(270)}}</h5></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tab Edit -->

        <div role="tabpanel" class="tab-pane fade" id="edit">

        </div>


    </div>
</div>

<script type="text/javascript">
    var restaurants = new Array();
    var categories = new Array();
    var foods = new Array();
    var allFoods = new Array();
    @foreach($foods as $key => $idata)
        allFoods.push(["{{$idata->id}}", "{{$idata->name}}", "{{$idata->restaurant}}"])
    @endforeach

    // multi-select
    $('#restaurantsGroup').multiSelect({
        afterSelect: function(values){
            console.log("Select value: "+values);
            restaurants.push(values);
            console.log("Restaurants All value: "+restaurants);
            restaurantsInitFoods();
        },
        afterDeselect: function(values){
            console.log("Deselect value: "+values);
            restaurants = restaurants.filter(p => {
                return p[0] != values[0];
            })
            console.log("Restaurants All value: "+restaurants);
            restaurantsInitFoods();
        }
    });
    $('#categoryGroup').multiSelect({
        afterSelect: function(values){
            console.log("Select value: "+values);
            categories.push(values);
            console.log("Categories All value: "+categories);
        },
        afterDeselect: function(values){
            console.log("Deselect value: "+values);
            categories = categories.filter(p => p[0] != values[0]);
            console.log("Categories All value: "+categories);
        }
    });
    $('#foodsGroup').multiSelect({
        afterSelect: function(values){
            console.log("Select value: "+values);
            foods.push(values);
            console.log("foods All value: "+categories);
        },
        afterDeselect: function(values){
            console.log("Deselect value: "+values);
            foods = foods.filter(p => p[0] != values[0]);
            console.log("foods All value: "+foods);
        }
    });
    var listener100 = function (e) {
        inputHandler(e, discount, 0, 100);
    };
    var listener10000 = function (e) {
        inputHandler(e, discount, 0, 10000);
    };
    // discount.addEventListener('input',  listener100);
    var published = true;
    var inpercents = true;
    var allRestaurants = true;
    var allCategoryGroup = true;
    var allFoodsGroup = true;

    // document.getElementById('inpercents').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbspDiscount In percents";
    function onCheckClick(id){
        var value = "on";
        if (id == 'published') {
            if (published) value = "off"; else value = "on";
            published = !published;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(271)}}";
        }
        if (id == 'allCategoryGroup') {
            if (allCategoryGroup) value = "off"; else value = "on";
            allCategoryGroup = !allCategoryGroup;
            if (!allCategoryGroup)
                document.getElementById("ms-categoryGroup").hidden=false;
            else
                document.getElementById("ms-categoryGroup").hidden=true;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(273)}}";
        }
        if (id == 'allFoodsGroup') {
            if (allFoodsGroup) value = "off"; else value = "on";
            allFoodsGroup = !allFoodsGroup;
            if (!allFoodsGroup)
                document.getElementById("ms-foodsGroup").hidden=false;
            else
                document.getElementById("ms-foodsGroup").hidden=true;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(274)}}";    {{--Coupon for All products--}}
        }
        if (id == 'inpercents') {
            if (inpercents == true){
                value = "off";
                discount.removeEventListener('input', listener100);
                discount.addEventListener('input',  listener10000);
            }  else {
                value = "on";
                discount.removeEventListener('input', listener10000);
                discount.addEventListener('input',  listener100);
                if (document.getElementById('discount').value > 100)
                    document.getElementById('discount').value = 100;
            }
            inpercents = !inpercents;
            document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(275)}}";
        }
    }

    function restaurantsInitFoods(){
        var f = allFoods;
        document.getElementById("foodsGroup").innerHTML = "";

        var optionGroup = document.createElement("optgroup");
        optionGroup.setAttribute("label","Foods");
        optionGroup.setAttribute("value","1");
        optionGroup.setAttribute("id","theid");

        for (var i = 0; i < f.length; i++) {
            var option = document.createElement("option");
            option.setAttribute("value",f[i][0]);
            option.innerHTML=f[i][1];
            optionGroup.append(option);
            document.getElementById("foodsGroup").append(optionGroup);
        }
        $('#foodsGroup').data('multiselect').refresh();
        foods = [];
        if (!allFoodsGroup)
            document.getElementById("ms-foodsGroup").hidden=false;
        else
            document.getElementById("ms-foodsGroup").hidden=true;
    }

    var amount = document.getElementById('amount');
    amount.addEventListener('input',  function(e){inputHandlerDouble(e, amount, 0, 10000000);});

    function inputHandlerDouble(e, parent, min, max) {
        var t = e.target.value.indexOf('.');
        var value = parseFloat(e.target.value);
        if (value.isEmpty)
            value = 0;
        if (isNaN(value))
            value = 0;
        if (value > max)
            value = max;
        if (value < min)
            value = min;
        if (t != -1) {
            var m = value.toFixed(2);
            if (m.substring(m.length - 1) == '0')
                parent.value = value.toFixed(1);
            else
                parent.value = value.toFixed(2);
        }else
            parent.value = value;
    }

    function showDeleteMessage2(id) {
        swal({
            title: "{{$lang->get(81)}}",
            text: "{{$lang->get(82)}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{$lang->get(83)}}",
            cancelButtonText: "{{$lang->get(84)}}",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                console.log(id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("coupondelete") }}',
                    data: {id: id},
                    success: function (data){
                        console.log(data);
                        if (data.error != "0") {
                            if (data.error == '2')
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        // remove from table
                        // var table = $('#data_table').DataTable();
                        // var indexes = table
                        //     .rows()
                        //     .indexes()
                        //     .filter( function ( value, index ) {
                        //         return data.id === table.row(value).data()[0];
                        //     } );
                        // var page = moveToPageWithSelectedItem(id);
                        // table.rows(indexes).remove().draw();
                        // table.page(page).draw(false);
                        //document.getElementById("data_table").
                        window.location.reload(true);
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href")
        if (target != "#edit") {
            document.getElementById("tabEdit").style.display = "none";
            var target = document.getElementById("form");
            document.getElementById('create').appendChild(target);
            clearForm();
        }
        console.log(target);
    });

    var editItemFlag = false;
    var editItemId = 0;

    async function editItem(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("couponedit") }}',
            data: {id: id},
            success: function (data){
                console.log(data);
                if (data.ret == 401)
                    return window.location="{{route('/')}}";

                document.getElementById("tabEdit").style.display = "block";
                $('.nav-tabs a[href="#edit"]').tab('show');
                var target = document.getElementById("form");
                document.getElementById('edit').appendChild(target);
                //
                document.getElementById("name").value = data.name;
                if (data.published == '1') {
                    published = true;
                    document.getElementById('published').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(271)}}";
                }else{
                    published = false;
                    document.getElementById('published').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(271)}}";
                }
                if (data.allCategory == '1'){
                    allCategoryGroup = true;
                    document.getElementById('allCategoryGroup').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(273)}}";
                    document.getElementById("ms-categoryGroup").hidden=true;
                }else{
                    allCategoryGroup = false;
                    document.getElementById('allCategoryGroup').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(273)}}";
                    document.getElementById("ms-categoryGroup").hidden=false;
                }
                if (data.allFoods == '1'){
                    allFoodsGroup = true;
                    document.getElementById('allFoodsGroup').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(274)}}";
                    document.getElementById("ms-foodsGroup").hidden=true;
                }else{
                    allFoodsGroup = false;
                    document.getElementById('allFoodsGroup').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(274)}}";
                    document.getElementById("ms-foodsGroup").hidden=false;
                }
                document.getElementById("discount").value = data.discount;
                if (data.inpercents == '1'){
                    inpercents = true;
                    document.getElementById('inpercents').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(275)}}";
                    document.getElementById("discount").addEventListener('input',  listener100);
                }else{
                    inpercents = false;
                    document.getElementById('inpercents').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp {{$lang->get(275)}}";
                    document.getElementById("discount").addEventListener('input',  listener10000);
                }
                document.getElementById("amount").value = data.amount;
                document.getElementById("desc").value = data.desc;
                document.getElementById("datetime1").setAttribute("value", data.dateStart);
                document.getElementById("datetime2").value = data.dateEnd;
                restaurants2 = JSON.parse("[" + data.restaurantsList + "]");
                for (let i = 0; i < restaurants2.length; i++)
                    $('#restaurantsGroup').multiSelect('select', restaurants2[i].toString());
                categories2 = JSON.parse("[" + data.categoryList + "]");
                for (let i = 0; i < categories2.length; i++)
                    $('#categoryGroup').multiSelect('select', categories2[i].toString());
                foods2 = JSON.parse("[" + data.foodsList + "]");
                for (let i = 0; i < foods2.length; i++)
                    $('#foodsGroup').multiSelect('select', foods2[i].toString());
                editItemFlag = true;
                editItemId = data.id;
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function save(){
        console.log("save");
        var name = document.getElementById("name").value;
        if (name.length == 0)
            return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");
        var discount = document.getElementById("discount").value;
        if (discount.length == 0)
            return showNotification("bg-red", "{{$lang->get(276)}}", "bottom", "center", "", "");
        var amount = document.getElementById("amount").value;
        var desc = document.getElementById("desc").value;
        var dateStart = document.getElementById("datetime1").value;
        var dateEnd = document.getElementById("datetime2").value;
        if (dateEnd.length == 0)
            return showNotification("bg-red", "{{$lang->get(277)}}", "bottom", "center", "", "");
        var allRestaurantsText = "";
        var allCategoryGroupText = "";
        var allFoodsGroupText = "";
        if (!allCategoryGroup)
            allCategoryGroupText = categories.toString();
        if (!allFoodsGroup)
            allFoodsGroupText = foods.toString();
        var discount2 = discount;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("couponsAdd") }}',
            data: {
                name: name,
                published: published,
                discount: discount,
                inpercents: inpercents,
                amount: amount,
                desc: desc,
                dateStart: dateStart,
                dateEnd: dateEnd,
                allRestaurants: allRestaurants,
                allCategoryGroup: allCategoryGroup,
                allFoodsGroup: allFoodsGroup,
                restaurantsList: allRestaurantsText,
                categoryList: allCategoryGroupText,
                foodsList: allFoodsGroupText,
                edit: editItemFlag,
                editid: editItemId,
            },
            success: function (data){
                console.log(data);
                if (data.error == 1)
                    return showNotification("bg-red", "{{$lang->get(278)}}", "bottom", "center", "", "");   {{--"The start time is greater than the end time",--}}
                if (data.error == 6)
                    return showNotification("bg-red", "{{$lang->get(279)}}", "bottom", "center", "", "");   {{--The End time less than now--}}
                window.location.reload(true);
                return;
                var div = document.createElement("tr");
                //var buttons = addButtonsToExtra(currentGroupId, eid, name, eimage, eprice, desc);
                var buttons = "";
                var disc = discount2 + "%";
                if (inpercents == '0') {
                    disc = parseFloat(discount2).toFixed({{$currency->symbolDigits()}});
                    if ({{$currency->rightSymbol()}} == "false")
                        disc = disc + '{{$currency->currency()}}';
                    else
                        disc = '{{$currency->currency()}}' + disc;
                }
                // add or replace item to table
                var table = $('#data_table').DataTable();
                // delete if exist
                var pub = "<img src=\"img/iconyes.png\" width=\"40px\">";
                if (!published)
                    pub = "<img src=\"img/iconno.png\" width=\"40px\">";

                var indexes = table.rows()
                    .indexes()
                    .filter( function ( value, index ) {
                        return data.id === table.row(value).data()[0];
                    } );
                table.rows(indexes).remove().draw();
                // add
                table.row.add( [
                    data.id,
                    name,
                    disc,
                    amount,
                    dateStart,
                    dateEnd,
                    pub,
                    "<button type=\"button\" class=\"btn btn-default waves-effect\"\n" +
                    "       onclick=\"editItem("+ data.id +")\">\n" +
                    "       <img src=\"img/iconedit.png\" width=\"25px\">\n" +
                    "       </button>\n" +
                    "       <button type=\"button\" class=\"btn btn-default waves-effect\" onclick=\"showDeleteMessage("+ data.id +")\">\n" +
                    "       <img src=\"img/icondelete.png\" width=\"25px\">\n" +
                    "       </button>"
                ] ).draw( false );
                // go to tab "list"
                $('#tabs a[href="#home"]').tab('show');
                // clear form
                clearForm();
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    clearForm();

    function clearForm(){
        document.getElementById("name").value = "";
        published = true;
        document.getElementById('published').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(271)}}";
        allRestaurants = true;
        allCategoryGroup = true;
        document.getElementById('allCategoryGroup').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(273)}}";
        document.getElementById("ms-categoryGroup").hidden=true;
        allFoodsGroup = true;
        document.getElementById('allFoodsGroup').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(274)}}";
        document.getElementById("ms-foodsGroup").hidden=true;
        document.getElementById("discount").value = "";
        document.getElementById("discount").addEventListener('input',  listener100);
        inpercents = true;
        document.getElementById('inpercents').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp {{$lang->get(275)}}";
        document.getElementById("amount").value = "0";
        document.getElementById("desc").value = "";
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if(dd < 10) dd='0' + dd;
        if(mm < 10) mm='0' + mm;
        today = yyyy + '-' + mm + '-' + dd + "T00:00";
        console.log("today " + today);
        document.getElementById("datetime1").setAttribute("value", today);
        document.getElementById("datetime2").value = "";
        restaurants = new Array();
        categories = new Array();
        foods = new Array();
        $('#foodsGroup').data('multiselect').deselect_all();
        $('#categoryGroup').data('multiselect').deselect_all();
    }
</script>

@endsection
