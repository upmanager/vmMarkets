@inject('userinfo', 'App\UserInfo')
@inject('currency', 'App\Currency')
@inject('lang', 'App\Lang')
@extends('bsb.app')
@inject('settings', 'App\Settings')

{{--06.02.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
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
                                {{$lang->get(87)}}  {{--PRODUCTS LIST--}}
                            </h3>
                        </div>
                        <div class="body">
                            @include('elements.productsTable', array())
                        </div>
                    </div>
                </div>
            </div>

        <!-- End Tab List -->

        <!-- Tab Create -->
        <div role="tabpanel" class="tab-pane fade" id="create">

            <div id="form">
                <div class="row clearfix q-mt20 a-mb20">
                    <div class="col-md-6 ">
                        @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "name", 'request' => "true", 'maxlength' => "40"))  {{-- Name - Insert Name --}}
                        @include('elements.form.price', array('label' => $lang->get(88), 'text' => $lang->get(92), 'id' => "price", 'request' => "true"))  {{-- Price - Insert Price --}}
                        @include('elements.form.selectCat', array('label' => $lang->get(94), 'onchange' => "", 'id' => "category", 'request' => "true", 'noitem' => "true"))   {{--Select Category --}}
                        @include('elements.form.price', array('label' => $lang->get(96), 'text' => $lang->get(97), 'id' => "discountprice", 'request' => "false"))  {{-- Discount Price - Insert Discount Price --}}
                        @include('elements.form.text', array('label' => $lang->get(104), 'text' => $lang->get(105), 'id' => "ingredients", 'request' => "false", 'maxlength' => "500"))  {{-- Ingredients - Insert ingredients --}}
                        @include('elements.form.text', array('label' => $lang->get(71), 'text' => $lang->get(76), 'id' => "desc", 'request' => "false", 'maxlength' => "500"))  {{-- Description - Insert description --}}
                        <div class="col-md-4 ">
                        </div>
                        <div class="col-md-8 ">
                            @include('elements.form.check', array('id' => "visible", 'text' => $lang->get(75), 'initvalue' => "true"))  {{--Published item--}}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        @include('elements.form.images', array())
                        @include('elements.form.text', array('label' => $lang->get(98), 'text' => $lang->get(99), 'id' => "unit", 'request' => "false", 'maxlength' => "10"))   {{--Unit - Enter the unit of food (ex:L, ml, Kg, g)--}}
                        @include('elements.form.number', array('label' => $lang->get(100), 'text' => $lang->get(101), 'id' => "package", 'request' => "false", 'min' => "0", 'max' => "1000000"))   {{--Package - Number of item per package (ex: 1, 6, 10)--}}
                        @include('elements.form.text', array('label' => $lang->get(102), 'text' => $lang->get(103), 'id' => "weight", 'request' => "false", 'maxlength' => "20"))   {{--Weight - Insert Weight of this food default unit is gramme (g)--}}
                    </div>
                </div>
                {{--Product variants--}}
                <div class="col-md-12 mb-0">
                    <hr>
                    <div class="col-md-3 align-left">
                        @include('elements.form.button', array('label' => $lang->get(545), 'onclick' => "onProductVariants();"))  {{-- Product variants  --}}
                    </div>
                    <div id="productVariantsItems" class="col-md-12 " hidden>
                        <div class="col-md-12 ">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{$lang->get(69)}}</th> {{--Name--}}
                                    <th>{{$lang->get(70)}}</th> {{--Image--}}
                                    <th>{{$lang->get(88)}}</th> {{--Price--}}
                                    <th>{{$lang->get(96)}}</th> {{--Discount Price--}}
                                    <th>{{$lang->get(72)}}</th> {{--Updated At--}}
                                    <th>{{$lang->get(74)}}</th> {{--Action--}}
                                </tr>
                                </thead>
                                <tbody id="pv_table_body">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 " style="border-color: #2aabd2; border-style: dashed; border-width: 2px; border-radius: 10px ">
                            <div class="col-md-6 q-mt20 q-mb20">
                                @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "pv_name", 'request' => "true", 'maxlength' => "40"))  {{-- Name - Insert Name --}}
                                @include('elements.form.price', array('label' => $lang->get(88), 'text' => $lang->get(92), 'id' => "pv_price", 'request' => "true"))  {{-- Price - Insert Price --}}
                                @include('elements.form.price', array('label' => $lang->get(96), 'text' => $lang->get(97), 'id' => "pv_discountprice", 'request' => "false"))  {{-- Discount Price - Insert Discount Price --}}
                            </div>
                            <div class="col-md-6" style="margin-top: 10px">
                                @include('elements.form.image2', array())
                                @include('elements.form.button', array('label' => $lang->get(546), 'onclick' => "addVariant();"))  {{-- Add new variant  --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
                {{--Recommended products--}}
                <div class="col-md-12 mb-0">
                    <div class="col-md-3 align-left">
                        @include('elements.form.button', array('label' => $lang->get(547), 'onclick' => "onRecommendedProducts();"))  {{-- Recommended products  --}}
                    </div>
                    <div id="recommendedProductsItems" class="col-md-12 " hidden>
                        <div class="col-md-12 ">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>{{$lang->get(69)}}</th> {{--Name--}}
                                    <th>{{$lang->get(70)}}</th> {{--Image--}}
                                    <th>{{$lang->get(88)}}</th> {{--Price--}}
                                    <th>{{$lang->get(74)}}</th> {{--Action--}}
                                </tr>
                                </thead>
                                <tbody id="rp_table_body">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 " style="border-color: #2aabd2; border-style: dashed; border-width: 2px; border-radius: 10px ">
                            <div class="col-md-9 q-mt20">
                                @include('elements.form.selectFoods', array('label' => $lang->get(549), 'onchange' => "", 'id' => "foodForList", 'request' => "true", 'noitem' => "false"))   {{--Product--}}
                            </div>
                            <div class="col-md-3 q-mb20">
                                @include('elements.form.button', array('label' => $lang->get(548), 'onclick' => "addRProduct();"))  {{-- Add product  --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>

                @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSave();"))  {{-- Save --}}
            </div>

        </div>

        <!-- Tab Edit -->
        <div role="tabpanel" class="tab-pane fade" id="edit">

        </div>
    </div>
</div>

<script type="text/javascript">

    let cacheRProducts = [];
    $('.show-tick').selectpicker('refresh');

    function addRProduct(){
        var rp = $('select[id=foodForList]').val();
        if (rp == 0)
            return;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("rProductAdd") }}',
            data: {
                id: editId,
                rp: rp,
            },
            success: function (data){
                console.log("addRProduct");
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                if (editId == 0){
                    if (data.data.length != 0) {
                        cacheRProducts.push({
                            id: rp,
                            name: data.data[0].name,
                            image: data.data[0].image,
                            price: data.data[0].price,
                        });
                        console.log("cacheRProducts");
                        console.log(cacheRProducts);
                        loadAllRProducts(cacheRProducts);
                        return;
                    }
                }
                loadAllRProducts(data.data);
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function deleteRProducts(id){
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
                    url: '{{ url("rProductsDelete") }}',
                    data: {
                        id: id,
                        parent: editId,
                    },
                    success: function (data){
                        console.log(data);
                        if (data.error != "0" || data.data == null) {
                            if (data.error == "1")
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");  // demo mode
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        loadAllRProducts(data.data);
                    },
                    error: function(e) {
                        showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    function loadAllRProducts(data){
        var text = "";
        data.forEach(function(item, i, arr) {
            text += `
                    <tr>
                        <td>${item.name}</td>
                        <td><img src="images/${item.image}" height="100px" ></td>
                        <td>${item.price}</td>
                        <td>
                            <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="deleteRProducts('${item.id}')">
                                <div>{{$lang->get(308)}}</div> {{--Delete--}}
                            </button>
                        </td>
                    </tr>
                    `
        });
        document.getElementById("rp_table_body").innerHTML = text;
    }

    let cacheVariant = [];

    function addVariant(){
        var pv_name = document.getElementById("pv_name").value;
        var pv_price = document.getElementById("pv_price").value;
        if (pv_name === "")
            return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
        if (pv_price == "")
            return showNotification("bg-red", "{{$lang->get(111)}}", "bottom", "center", "", "");  // The Price field is required.
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("productVariantsAdd") }}',
            data: {
                id: editId,
                name: pv_name,
                price: pv_price,
                dprice: document.getElementById("pv_discountprice").value,
                imageid: imageid3
            },
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                if (editId == 0){
                    if (data.data.length != 0) {
                        cacheVariant.push({
                            name: data.data.name,
                            price: data.data.price,
                            cprice: data.data.cprice,
                            dprice: data.data.dprice,
                            cdprice: data.data.cdprice,
                            image: data.data.image,
                            imageid: data.data.imageid,
                            timeago: data.data.timeago
                        });
                        console.log("cacheVariant");
                        console.log(cacheVariant);
                        loadAllVariants(cacheVariant);
                        return;
                    }
                }
                loadAllVariants(data.data);
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function loadAllVariants(data){
        var text = "";
        data.forEach(function(item, i, arr) {
            text += `
                    <tr>
                        <td>${item.name}</td>
                        <td><img src="images/${item.image}" height="100px" ></td>
                        <td>${item.price}</td>
                        <td>${item.dprice}</td>
                        <td>${item.timeago}</td>
                        <td>
                            <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="deleteVariableItem('${item.id}')">
                                <div>{{$lang->get(308)}}</div> {{--Delete--}}
                            </button>
                        </td>
                    </tr>
                    `
        });
        document.getElementById("pv_table_body").innerHTML = text;
    }

    var productVariants = false;
    function onProductVariants(){
        productVariants = !productVariants;
        if (productVariants)
            document.getElementById("productVariantsItems").hidden = false;
        else
            document.getElementById("productVariantsItems").hidden = true;
    }

    var recommendedProducts = false;
    function onRecommendedProducts(){
        recommendedProducts = !recommendedProducts;
        if (recommendedProducts)
            document.getElementById("recommendedProductsItems").hidden = false;
        else
            document.getElementById("recommendedProductsItems").hidden = true;
    }

    function deleteVariableItem(id){
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
                    url: '{{ url("productVariantsDelete") }}',
                    data: {
                        id: id,
                        parent: editId,
                    },
                    success: function (data){
                        console.log(data);
                        if (data.error != "0" || data.data == null) {
                            if (data.error == "1")
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");  // demo mode
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        loadAllVariants(data.data);
                    },
                    error: function(e) {
                        showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href")
        if (target != "#edit")
            document.getElementById("tabEdit").style.display = "none";
        if (target == "#create") {
            clearForm();
            document.getElementById('create').appendChild(document.getElementById("form"));
        }
        if (target == "#home")
            clearForm();
    });

    function editItem(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("foodGetInfo") }}',
            data: {
                id: id,
            },
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                document.getElementById("tabEdit").style.display = "block";
                $('.nav-tabs a[href="#edit"]').tab('show');
                //
                var target = document.getElementById("form");
                document.getElementById('edit').appendChild(target);
                //
                document.getElementById("name").value = data.data.name;
                editId = data.data.id;
                onSetCheck_visible(data.data.published);

                document.getElementById("price").value = data.data.price;
                $('#category').val(data.data.category).change();
                // category
                // nutrition
                $('#nutrition').val(data.data.nutritions).change();
                $('#extras').val(data.data.extras).change();
                $('.show-tick').selectpicker('refresh');
                //
                document.getElementById("discountprice").value = data.data.discountprice;
                document.getElementById("ingredients").value = data.data.ingredients;
                document.getElementById("desc").value = data.data.desc;
                document.getElementById("unit").value = data.data.unit;
                document.getElementById("package").value = data.data.packageCount;
                document.getElementById("weight").value = data.data.weight;
                //
                addEditImages(data.data.images_files);
                //
                loadAllVariants(data.variants);
                if (data.variants.length != 0){
                    productVariants = true;
                    document.getElementById("productVariantsItems").hidden = false;
                }
                loadAllRProducts(data.rp)
                if (data.rp.length != 0){
                    recommendedProducts = true;
                    document.getElementById("recommendedProductsItems").hidden = false;
                }
                //
                $('#parent').val(data.data.parent).change();
                $('.show-tick').selectpicker('refresh');
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function clearForm(){
        document.getElementById("name").value = "";
        onSetCheck_visible(true);
        document.getElementById("price").value = "";
        document.getElementById("discountprice").value = "";
        document.getElementById("ingredients").value = "";
        document.getElementById("desc").value = "";
        document.getElementById("unit").value = "";
        document.getElementById("package").value = "";
        document.getElementById("weight").value = "";
        //
        document.getElementById("pv_table_body").innerHTML = "";
        document.getElementById("rp_table_body").innerHTML = "";
        productVariants = false;
        document.getElementById("productVariantsItems").hidden = true;
        recommendedProducts = false;
        document.getElementById("recommendedProductsItems").hidden = true;
        cacheRProducts = [];
        cacheVariant = [];
        //
        $('#category').val(0).change();
        $('#nutrition').val(0).change();
        $('#extras').val(0).change();
        editId = 0;
        clearDropZone();
    }

    var editId = 0;

    function onSave(){
        console.log("onSave");
        console.log(imageArray);

        let images = [];
        var imageid = 0;
        for (var i = 0; i < imageArray.length; i++){
            if (i === 0)
                imageid = imageArray[i].id;
            else
                images.push(imageArray[i].id);
        }
        let data = {
            id: editId,
            name: document.getElementById("name").value,
            image: imageid,
            moreimages: images.toString(),
            published: (visible) ? "1" : "0",
            price: document.getElementById("price").value,
            discPrice: document.getElementById("discountprice").value,
            unit: document.getElementById("unit").value,
            package: document.getElementById("package").value,
            weight: document.getElementById("weight").value,
            desc: document.getElementById("desc").value,
            ingredients: document.getElementById("ingredients").value,
            extras: $('select[id=extras]').val(),
            nutritions: $('select[id=nutrition]').val(),
            category: $('select[id=category]').val(),
            cacheRProducts : cacheRProducts,
            cacheVariant: cacheVariant,
        };
        console.log(data);
        if (!document.getElementById("name").value)
            return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
        if (!document.getElementById("price").value)
            return showNotification("bg-red", "{{$lang->get(111)}}", "bottom", "center", "", "");  // The Price field is required.
        if ($('select[id=market]').val() == "0")
            return showNotification("bg-red", "{{$lang->get(113)}}", "bottom", "center", "", "");  // The Market field is required.
        if ($('select[id=category]').val() == "0")
            return showNotification("bg-red", "{{$lang->get(112)}}", "bottom", "center", "", "");  // The Category field is required.
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("foodadd") }}',
            data: data,
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                if (editId != 0)
                    paginationGoPage(currentPage);
                else{
                    var text = buildOneItem(data.data);
                    var text2 = document.getElementById("table_body").innerHTML;
                    document.getElementById("table_body").innerHTML = text+text2;
                }
                $('.nav-tabs a[href="#home"]').tab('show');
                showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
                clearForm();
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

</script>

@endsection
