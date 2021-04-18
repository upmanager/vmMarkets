@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('currency', 'App\Currency')
@inject('theme', 'App\Theme')

{{--31.01.2021--}}

@section('content')
<div class="q-container">

    <!-- Tabs -->
    <ul class="nav nav-tabs q-line tab-nav-right" role="tablist">
        <li role="presentation" class="q-li-active active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
        <li id="tabView" style='display:none;' class="q-li-active" role="presentation"><a href="#view" data-toggle="tab"><h4>{{$lang->get(211)}}</h4></a></li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Tab List -->
        <div role="tabpanel" class="tab-pane fade in active" id="home">
            <div id="orders-table" class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="q-line q-mb20">
                            <h3>
                                {{$lang->get(212)}}
                            </h3>
                        </div>
                        <div class="body">
                            @include('elements.ordersTable', array())
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab View -->
        <div role="tabpanel" class="tab-pane fade" id="view">
            <div class="row clearfix js-sweetalert q-mt20 q-mb20">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="row clearfix">
                        <div class="col-md-4">
                            <table class="table">
                            <tbody>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(43)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewOrderID"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(45)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewClient"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(215)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewClientPhone"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(216)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewClientAddress"></div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(217)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewCreatedAt"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(49)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewUpdatedAt"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(48)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewMethod"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(218)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewHint"></div>
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(8)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewRestaurant"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(219)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewRestaurantAddress"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(220)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewRestaurantPhone"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:right" >
                                    <div class="font-16 font-bold">{{$lang->get(221)}}:</div>
                                </td>
                                <td style="text-align:left" >
                                    <div id="viewRestaurantMobilePhone"></div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

            </div>
        @if ($userinfo->getUserRoleId() == '2')
            <div class="col-md-12">
                <table class="table">
                    <tbody>

                    <tr>
                        <td class="text-right" >
                            <div class="font-16 font-bold q-form-label">{{$lang->get(222)}}:</div>
                        </td>
                        <td style="text-align:left" >
                            <div id="viewStatus"></div>
                        </td>

                        <td class="text-right" >
                            <div id="viewDriverText" class="font-16 font-bold q-form-label">{{$lang->get(208)}}:</div>
                        </td>
                        <td style="text-align:left" >
                            <div id="viewDriver"></div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        @endif

            <div class="col-md-5">
                <table class="table  table-bordered">
                    <tbody>
                    <thead class="q-color-bkg-label1">
                    <tr>
                        <th>{{$lang->get(222)}}</th>
                        <th>{{$lang->get(223)}}</th>
                    </tr>
                    </thead>
                    <tbody id="details">

                    </tbody>
                    </tbody>
                </table>
            </div>

            <div class="row clearfix ">
                <div class="col-md-12" style="padding: 50px">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="q-color-bkg-label1">
                        <tr>
                            <th>{{$lang->get(549)}}</th>    {{--Product--}}
                            <th>{{$lang->get(224)}}</th>    {{--Price--}}
                            <th>{{$lang->get(225)}}</th>    {{--Quantity--}}
                            <th>{{$lang->get(70)}}</th>     {{--Image--}}
                            <th>{{$lang->get(44)}}</th>     {{--Total--}}
                            <th>{{$lang->get(74)}}</th>     {{--Action--}}
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>{{$lang->get(549)}}</th>    {{--Product--}}
                            <th>{{$lang->get(224)}}</th>    {{--Price--}}
                            <th>{{$lang->get(225)}}</th>    {{--Quantity--}}
                            <th>{{$lang->get(70)}}</th>     {{--Image--}}
                            <th>{{$lang->get(44)}}</th>     {{--Total--}}
                            <th>{{$lang->get(74)}}</th>     {{--Action--}}
                        </tr>
                        </tfoot>
                        <tbody id="tbodyView">

                        </tbody>
                    </table>
                    <div class="col-md-12">
                        @if ($userinfo->getUserRoleId() == '2')
                            <div align="right">
                                <button type="button" onclick="selectFood()" class="q-btn-all q-color-second-bkg waves-effect "><h5>{{$lang->get(228)}}</h5></button> {{--Add Products--}}
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-8" >
                </div>
                <div class="col-md-4">
                    <table class="table">
                        <tbody>
                        <tr id="couponTitle">
                            <td style="text-align:right" >
                                <div class="font-16 font-bold">{{$lang->get(229)}}:</div>
                            </td>
                            <td style="text-align:left" >
                                <div id="couponName"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right" >
                                <div class="font-16 font-bold">{{$lang->get(230)}}:</div>
                            </td>
                            <td style="text-align:left" >
                                <div id="viewSubtotal"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right" >
                                <div id="viewDeliveryFeeText" class="font-16 font-bold">{{$lang->get(157)}}:</div>
                            </td>
                            <td style="text-align:left" >
                                <div id="viewDeliveryFee"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right" >
                                <div id="viewTaxText" class="font-16 font-bold">{{$lang->get(231)}}:</div>
                            </td>
                            <td style="text-align:left" >
                                <div id="viewTax"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right" >
                                <div class="font-16 font-bold">{{$lang->get(44)}}:</div>
                            </td>
                            <td style="text-align:left" >
                                <div id="viewTotal"></div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>

            </div>
         </div>
     </div>
 </div>
 </div>

<script type="text/javascript">

    @if ($edit != "")
        viewItem({{$edit}});
    @endif

    function showDeleteMessage(id) {
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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("orderdelete") }}',
                    data: {id: id},
                    success: function (data){
                        if (!data.ret)
                            return showNotification("bg-red", data.text, "bottom", "center", "", "");
                        paginationGoPage(currentPage);
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
        // if (target != "#edit")
        //     document.getElementById("tabEdit").style.display = "none";
        if (target != "#view")
            document.getElementById("tabView").style.display = "none";
        console.log(target);
    });

    var dataOrder;
    var orderTotal;

    function viewItem(id) {
        // open view edit
        document.getElementById("tabView").style.display = "block";
        $('.nav-tabs a[href="#view"]').tab('show');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("orderview") }}',
            data: {id: id},
            success: function (data){
                dataOrder = data;
                console.log("dataOrder " + dataOrder);
                //
                //
                console.log(data);
                document.getElementById("viewOrderID").innerHTML = data.order.id;
                document.getElementById("viewClient").innerHTML = data.user.name;

                document.getElementById("viewClientPhone").innerHTML = data.order.phone;
                if (data.order.curbsidePickup == "true") {
                    var xtext = "<span class=\"badge bg-red\">Curbside Pickup</span>";
                    if (data.order.arrived == "true")
                        xtext = xtext + "<span class=\"badge bg-red\">Customer arrived</span>";
                    document.getElementById("viewClientAddress").innerHTML = xtext;
                }else
                    document.getElementById("viewClientAddress").innerHTML = data.order.address;

                document.getElementById("viewCreatedAt").innerHTML = data.order.created_at;
                if (data.restaurant != null)
                    document.getElementById("viewRestaurant").innerHTML = data.restaurant.name;
    @if ($userinfo->getUserRoleId() == '2')
                //
                // Drivers
                //
                if (data.order.curbsidePickup == "true") {
                    document.getElementById("viewDriverText").hidden = true;
                    document.getElementById("viewDriver").innerHTML = "";
                }else{
                    document.getElementById("viewDriverText").hidden = false;
                    document.getElementById("viewDriver").innerHTML = "";
                    var selectList = document.createElement("select");
                    selectList.options.liveSearch = true;
                    console.log("selectList.options.liveSearch " + selectList.options.liveSearch);
                    selectList.className = "show-tick";
                    selectList.onchange = function (event) {
                        console.log(event);
                        checkDriver(event, data.order.id);
                    };
                    document.getElementById("viewDriver").appendChild(selectList);
                    var option = document.createElement("option");
                    option.value = '0';
                    option.text = 'no select';
                    option.selected = true;
                    selectList.appendChild(option);

                    @foreach($idrivers as $key => $idata)
                    var option = document.createElement("option");
                    option.value = '{{$idata->id}}';
                    option.text = '{{$idata->name}}';
                    if ({{$idata->id}} == data.order.driver)
                    option.selected = true;
                    selectList.appendChild(option);
                    @endforeach
                    $('.show-tick').selectpicker('refresh')
                }
    @endif

                document.getElementById("viewUpdatedAt").innerHTML = data.order.updated_at;
                document.getElementById("viewRestaurantAddress").innerHTML = data.restaurant.address;
                if (data.driver != null)
                    document.getElementById("viewDriverFee").innerHTML = data.driver.fee;
                document.getElementById("viewRestaurantPhone").innerHTML = data.restaurant.phone;
                document.getElementById("viewRestaurantMobilePhone").innerHTML = data.restaurant.mobilephone;
    @if ($userinfo->getUserRoleId() == '2')
                //
                // Status
                //
                document.getElementById("viewStatus").innerHTML = "";
                if (data.order.curbsidePickup == "true") {
                    var selectList = document.createElement("select");
                    selectList.className = "show-tick";
                    selectList.onchange = function(event) {
                        console.log("role" + data.order.id + "_" + event.target.value);
                        checkStatus(event, data.order.id);
                        document.getElementById("role" + data.order.id + "_" + event.target.value).selected = true;
                        $('.show-tick').selectpicker('refresh')
                    };
                    document.getElementById("viewStatus").appendChild(selectList);
                    @foreach($iorderstatus as $key => $idata)
                    @if ($idata->id != 4)
                    var option = document.createElement("option");
                    option.value = '{{$idata->id}}';
                    option.text = '{{$idata->status}}';
                    if ({{$idata->id}} == data.order.status)
                    option.selected = true;
                    selectList.appendChild(option);
                    @endif
                    @endforeach
                }else{
                    var selectList = document.createElement("select");
                    selectList.className = "show-tick";
                    selectList.onchange = function(event) {
                        console.log("role" + data.order.id + "_" + event.target.value);
                        checkStatus(event, data.order.id);
                        document.getElementById("role" + data.order.id + "_" + event.target.value).selected = true;
                        $('.show-tick').selectpicker('refresh')
                    };
                    document.getElementById("viewStatus").appendChild(selectList);
                    @foreach($iorderstatus as $key => $idata)
                    var option = document.createElement("option");
                    option.value = '{{$idata->id}}';
                    option.text = '{{$idata->status}}';
                    if ({{$idata->id}} == data.order.status)
                    option.selected = true;
                    selectList.appendChild(option);
                    @endforeach
                }
    @endif
                $('.show-tick').selectpicker('refresh')

                document.getElementById("viewMethod").innerHTML = data.order.method;
                document.getElementById("viewHint").innerHTML = data.order.hint;

                //
                // details
                //
                showDetails(data.ordertimes, data.orderstatuses, data.drivers);

                //
                // table
                //
                addTableWithDishes();
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function showDetails(ordertimes, orderstatuses, drivers){
        var details = document.getElementById("details");
        details.innerHTML = "";
        ordertimes.forEach(function(entry){
            var text = "";
            orderstatuses.forEach(function(entry2){
                if (entry2.id == entry.status)
                    text = entry2.status;
            });
            if (entry.status == 8)
                text = "{{$lang->get(232)}} " + entry.comment;      // "Rejected by Driver. Comment:",
            if (entry.status == 9)
                text = "{{$lang->get(233)}}";      // "Activate by Driver",
            if (entry.status == 10)
                text = "{{$lang->get(234)}}";     // "Complete by Driver",
            if (entry.status == 12)
                text = "{{$lang->get(235)}}";       // "Customer Arrived",
            if (entry.status == 15) {
                text = "{{$lang->get(236)}} ";      // "Set Driver:",
                drivers.forEach(function(entry3){
                    if (entry3.id == entry.driver)
                        text = text + entry3.name;
                });
            }
            var div = document.createElement("tr");
            div.innerHTML = "<td>" + text + "</td>" +
                "<td>" + entry.updated_at + "</td>";
            details.appendChild(div);
        });
    }

    function makePrice(price){
        @if ($currency->rightSymbol() == "false")
            return '{{$currency->currency()}}' + parseFloat(price).toFixed({{$currency->symbolDigits()}});
        @else
            return parseFloat(price).toFixed({{$currency->symbolDigits()}}) + '{{$currency->currency()}}';
        @endif
    }

    function addTableWithDishes(){
        document.getElementById("tbodyView").innerHTML = "";
        dataOrder.ordersdetails.forEach(function(entry){
            var div = document.createElement("tr");
            div.id = "ids"+entry.id;
            var total = entry.foodprice*entry.count+entry.extrasprice*entry.extrascount;

            if (entry.count != 0) { // food
                div.innerHTML = `<td>${entry.food}</td>
                    <td>${makePrice(entry.foodprice)}</td>
                    <td>${entry.count}</td>
                    <td><img src="images/${entry.image}" width="70px"></td>
                    <td>${makePrice(total)}</td>
                    <td>
                        @if ($userinfo->getUserRoleId() == '2')
                        <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage2('${dataOrder.order.id}', '${entry.id}')">
                        {{$lang->get(308)}}   {{--Delete--}}
                        </button>
                        @endif
                    </td>`;
            }
            document.getElementById("tbodyView").appendChild(div);
        });
        calculateTotal(dataOrder.order.id);
    }

    var allCoupons = new Array();
    var _coupon;
    @foreach($coupons as $key => $idata)
    allCoupons.push([
        "{{$idata->name}}",             // 0
        "{{$idata->discount}}",         // 1
        "{{$idata->inpercents}}",       // 2
        "{{$idata->amount}}",           // 3
        "{{$idata->allRestaurants}}",   // 4
        "{{$idata->allCategory}}",      // 5
        "{{$idata->allFoods}}",         // 6
        JSON.parse("[{{$idata->restaurantsList}}]"),    // 7
        JSON.parse("[{{$idata->categoryList}}]"),       // 8
        JSON.parse("[{{$idata->foodsList}}]")           // 9
        ]);
    @endforeach
    console.log(allCoupons);

    function getSubTotal(){
        var _total = 0;
        dataOrder.ordersdetails.forEach(function(entry) {
            var total = entry.foodprice * entry.count + entry.extrasprice * entry.extrascount;
            _total += total;
        });
        if (_coupon == null)
            return _total;
        if (_total > _coupon[3]){
            var total = 0.0;
            dataOrder.ordersdetails.forEach(function(entry) {
                var price = entry.foodprice * entry.count + entry.extrasprice * entry.extrascount;
                var priceCoupon = price;
                if (_coupon[4] == '1') {        // allRestaurants
                    priceCoupon = _couponCalculate(price);
                    if (_coupon[5] != '1' && !_coupon[8].includes(entry.category))       // allCategory
                        priceCoupon = price;
                    if (_coupon[6] != '1' && !_coupon[9].includes(entry.foodid))
                        priceCoupon = price;
                }else{
                    if (_coupon[7].includes(dataOrder.order.restaurant)) {
                        priceCoupon = _couponCalculate(price);
                        if (_coupon[5] != '1' && !_coupon[8].includes(entry.category))       // allCategory
                            priceCoupon = price;
                        if (_coupon[6] != '1' && !_coupon[9].includes(entry.foodid))
                            priceCoupon = price;
                    }else {
                        priceCoupon = price;
                    }
                }
                total += priceCoupon;
            });
            if (total != _total)
                if (_coupon[2] != '1')
                    total = _total - _coupon[1];
            return total;
        }
        return _total;
    }

    function _couponCalculate(_total){
        if (_coupon[2] == '1')  // inpercents
            _total = (100-_coupon[1])/100*_total;  // discount
        else
            _total -= _coupon[1]; //discount
        return _total;
    }

    function calculateTotal(id){
        // coupons
        console.log("dataOrder "+dataOrder.toString());
        if (dataOrder.order.couponName != null){
            document.getElementById("couponTitle").hidden = false;
            document.getElementById("couponName").innerHTML = dataOrder.order.couponName;
            for (let coupon of allCoupons) {
                if (coupon[0].toUpperCase() == dataOrder.order.couponName.toUpperCase())
                    _coupon = coupon;
            }
        }else
            document.getElementById("couponTitle").hidden = true;
        //
        var subtotal = getSubTotal();
        var subtotalWithoutCoupon = 0;
        dataOrder.ordersdetails.forEach(function(entry) {
            var total = entry.foodprice * entry.count + entry.extrasprice * entry.extrascount;
            subtotalWithoutCoupon += total;
        });
        console.log(subtotal);
        @if ($currency->rightSymbol() == "false")
            var g = dataOrder.currency + subtotal.toFixed({{$currency->symbolDigits()}});
            if (subtotal != subtotalWithoutCoupon)
                g = dataOrder.currency + subtotalWithoutCoupon.toFixed({{$currency->symbolDigits()}}) + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewSubtotal").innerHTML = g;
        @else
            var g = subtotal.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency;
            if (subtotal != subtotalWithoutCoupon)
                g = subtotalWithoutCoupon.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewSubtotal").innerHTML = g;
        @endif

        var fee = dataOrder.order.fee/100*subtotal;
        if (dataOrder.order.percent == 0)
            fee = dataOrder.order.fee;
        fee = Math.floor(fee * 100) / 100 ;
        //
        var tax = dataOrder.order.tax;
        tax = tax/100*subtotal;
        //
        var tax2 = dataOrder.order.tax;
        tax2 = tax2/100*subtotalWithoutCoupon;
        //
        @if ($currency->rightSymbol() == "false")
            document.getElementById("viewDeliveryFee").innerHTML = dataOrder.currency + fee.toFixed({{$currency->symbolDigits()}});
            var g = dataOrder.currency + tax.toFixed({{$currency->symbolDigits()}});
            if (subtotal != subtotalWithoutCoupon)
                g = dataOrder.currency + tax2.toFixed({{$currency->symbolDigits()}}) + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewTax").innerHTML = g;
        @else
            document.getElementById("viewDeliveryFee").innerHTML = fee.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency;
            var g = tax.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency;
            if (subtotal != subtotalWithoutCoupon)
                g = tax2.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewTax").innerHTML = g;
        @endif

        var total = subtotal + fee + tax;
        var total2 = subtotalWithoutCoupon + fee + tax2;
        @if ($currency->rightSymbol() == "false")
            var g = dataOrder.currency + total.toFixed({{$currency->symbolDigits()}});
            if (subtotal != subtotalWithoutCoupon)
                g = dataOrder.currency + total2.toFixed({{$currency->symbolDigits()}}) + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewTotal").innerHTML = g;
        @else
            var g = total.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency;
            if (subtotal != subtotalWithoutCoupon)
                g = total2.toFixed({{$currency->symbolDigits()}}) + dataOrder.currency + ". {{$lang->get(237)}} = <span class=\"col-red\">"+ g +"</span>";
            document.getElementById("viewTotal").innerHTML = g;
        @endif
        document.getElementById("viewTaxText").innerHTML = "Tax (" + dataOrder.order.tax + "%):";
        if (dataOrder.order.percent == 1)
            document.getElementById("viewDeliveryFeeText").innerHTML = "{{$lang->get(157)}} (" + dataOrder.order.fee + "%):";
        else
            document.getElementById("viewDeliveryFeeText").innerHTML = "{{$lang->get(157)}}:";
        //
        paginationGoPage(currentPage);
    }

    function checkStatus(event, id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("changeStatus") }}',
            data: {
                id: id,
                status: event.target.value
            },
            success: function (data){
                console.log(data);
                showDetails(data.ordertimes, data.orderstatuses, data.drivers);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function checkDriver(event, id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("changeDriver") }}',
            data: {
                id: id,
                driver: event.target.value
            },
            success: function (data){
                console.log(data);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function showDeleteMessage2(orderid, id) {
        console.log(id);
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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("orderDetailsDelete") }}',
                    data: {
                        id: id,
                        orderid: orderid,
                        total: orderTotal
                    },
                    success: function (data){
                        console.log(data);
                        //
                        // remove from ui
                        //
                        var div = document.getElementById('ids'+id);
                        div.remove();
                        console.log("data ret " + data.ret);
                        if (!data.ret) {
                            document.getElementById("viewSubtotal").innerHTML = dataOrder.currency + "0";
                            document.getElementById("viewDeliveryFee").innerHTML = dataOrder.currency + "0";
                            document.getElementById("viewTax").innerHTML = dataOrder.currency + "0";
                            document.getElementById("viewTotal").innerHTML = dataOrder.currency + "0";
                            orderTotal = 0;
                            document.getElementById("total"+id).innerHTML = dataOrder.currency + "0";
                        }else {
                            dataOrder = data;
                            calculateTotal(data.order.id);
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    function selectFood(){
        var text = `<div id="div1" style="height: 400px;position:relative;">
                        <div id="div2" style="max-height:100%;overflow:auto;border:1px solid grey; border-radius: 10px; height: 97%;">
                            <div id="foodslist" class="row" style="position: relative; top: 10px; left: 20px; right: 10px; bottom: 20px;width: 97%; ">
                                <table class="table table-bordered">
                                    <tbody>
                                        <thead class="q-color-bkg-label1">
                                             <tr>
                                                <th>{{$lang->get(69)}}</th>     {{--Name--}}
                                                <th>{{$lang->get(88)}}</th>     {{--Price--}}
                                                <th>{{$lang->get(70)}}</th>     {{--Image--}}
                                                <th>{{$lang->get(238)}}</th>    {{--Count--}}
                                                <th>{{$lang->get(239)}}</th>    {{--Add--}}
                                            </tr>
                                        </thead>
                                    <tbody id="foods">`;

        dataOrder.foods.forEach(function(entry){
            var price = entry.price;
            if (entry.discountprice != 0)
                price = entry.discountprice;

            text = text + `<tr>
                            <td>${entry.name}</td>
                            <td>${makePrice(price)}</td>
                            <td><img src="images/${entry.image}" width="70px"></td>
                            <td>
                                <div onclick="increment(${entry.id})" class="q-inline q-btn-all q-color-second-bkg waves-effect "><h5 class="q-inline">+1</h5></div>
                                <h5 class="q-inline" id="count${entry.id}">1</h5>
                                <div onclick="decrement(${entry.id})" class="q-inline q-btn-all q-color-second-bkg waves-effect"><h5 class="q-inline">-1</h5></div>
                            </td>
                            <td>
                                <div onclick="addFood(${entry.id})" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(554)}}</h5></div>  {{--Add to Order--}}
                            </td>
                            </tr>`;
        });

        text = `${text}</tbody>
                    </tbody>
                </table>
                </div></div></div>`;
        swal({
            title: "{{$lang->get(240)}}",
            text: text,
            confirmButtonColor: "#{{$theme->getSecondColor()}}",
            customClass: 'swal-wide',
            html: true
        }, function (isConfirm) {
            if (isConfirm) {

            } else {

            }
        })
    }

    function addFood(id){
        var num = document.getElementById("count"+id).innerHTML;
        console.log("dataOrder.order.id " +dataOrder.order.id+ " id " + id + " num " + num);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("orderDetailsAdd") }}',
            data: {
                id: id,
                orderid: dataOrder.order.id,
                count: num,
            },
            success: function (data){
                console.log(data);
                dataOrder = data;
                addTableWithDishes();
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function increment(id){
        var num = document.getElementById("count"+id).innerHTML;
        console.log(num);
        num++;
        document.getElementById("count"+id).innerHTML = num;
    }
    function decrement(id){
        var num = document.getElementById("count"+id).innerHTML;
        console.log(num);
        num--;
        if (num == 0)
            num = 1;
        document.getElementById("count"+id).innerHTML = num;
    }

</script>

@endsection
