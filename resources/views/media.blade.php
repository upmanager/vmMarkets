@inject('userinfo', 'App\UserInfo')
@inject('settings', 'App\Settings')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')

<div class="q-card q-radius q-container">
    <div class="row clearfix q-line q-mb20">
        <div class="col-md-6 ">
            <h4 class="">{{$lang->get(25)}}</h4>  {{--Media Library--}}
        </div>
        <div class="col-md-push-6 pull-right" >
            <div style="margin-right: 30px">
                <a href="mediaSetType?medialib_type=small">
                    @if ($medialib_type == 'small')
                        <button type="button" class="q-btn-all q-color-second-bkg waves-effect">
                    @else
                        <button type="button" class="q-btn-all waves-effect">
                    @endif
                        <img src="img/tile0.png" width="25px">
                        </button>
                </a>
                <a href="mediaSetType?medialib_type=medium">
                    @if ($medialib_type == 'medium')
                        <button type="button" class="q-btn-all q-color-second-bkg waves-effect">
                    @else
                        <button type="button" class="q-btn-all waves-effect">
                    @endif
                        <img src="img/tile1.png" width="25px">
                        </button>
                </a>
                <a href="mediaSetType?medialib_type=big">
                    @if ($medialib_type == 'big')
                        <button type="button" class="q-btn-all q-color-second-bkg waves-effect">
                    @else
                        <button type="button" class="q-btn-all waves-effect">
                    @endif
                        <img src="img/tile2.png" width="25px" >
                        </button>
                </a>
            </div>
        </div>
    </div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="body">
            <div class="row clearfix">
                <div class="col-md-12">
                    @foreach($petani as $key => $data)
                        @if ($medialib_type == 'small')
                            <div id="tbl{{$data->id}}" class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        @endif
                        @if ($medialib_type == 'medium')
                            <div id="tbl{{$data->id}}" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        @endif
                        @if ($medialib_type == 'big')
                            <div id="tbl{{$data->id}}" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        @endif
                            <div class="thumbnail">
                                <div style="background-image: url('images/{{$data->filename}}'); width: auto;
                                    height: 200px; background-size: cover; background-position: center; ">
                                </div>
                                <div class="caption">
                                    <p style="overflow: hidden; white-space: nowrap;" >{{$data->shortName}}</p>
                                    <p>{{$data->updated_at}}</p>
                                    <p>
                                        <button type="button" onclick="deleteFile('{{$data->filename}}', '{{$data->id}}')" class="q-btn-all q-color-alert waves-effect">{{$lang->get(308)}}</button>
                                        @if ($data->count == 0)
                                            <button type="button" onclick="fileInfo('{{$data->id}}')" class="q-btn-all q-color-alert waves-effect">{{$lang->get(496)}}</button> {{--Image unused--}}
                                        @else
                                            <button type="button" onclick="fileInfo('{{$data->id}}')" class="q-btn-all q-color-second-bkg waves-effect">{{$lang->get(495)}}</button> {{--Image used--}}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function deleteFile(fileName, id) {
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


                console.log("delete file:", fileName);
                console.log("id:", id);

                @if ($settings->isDemoMode())
                    return showNotification("bg-red", "{{$lang->get(307)}}", "bottom", "center", "", "");
                @else
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ url("image/delete") }}',
                    data: {filename: fileName},
                    success: function (data){
                        document.getElementById("tbl" + id).remove();
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
                @endif


            } else {

            }
        });
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function fileInfo(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("imageInfo") }}',
            data: {
                id: id
            },
            success: function (data){
                console.log(data);
                fileInfoDialog(data);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function fileInfoDialog(data){
        // foods
        var foods = "";
        data.foods.forEach(function(item, i, arr) {
            foods += `<tr><td>id: ${item.id}</td><td>${item.name}</td></tr>`;
        });
        if (foods == "")
            foods = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}
        // categories
        var categories = "";
        data.categories.forEach(function(item, i, arr) {
            categories += `<tr><td>id: ${item.id}</td><td>${item.name}</td></tr>`;
        });
        if (categories == "")
            categories = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}
        // restaurants
        var restaurants = "";
        data.restaurants.forEach(function(item, i, arr) {
            restaurants += `<tr><td>id: ${item.id}</td><td>${item.name}</td></tr>`;
        });
        if (restaurants == "")
            restaurants = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}
        // banners
        var banners = "";
        data.banners.forEach(function(item, i, arr) {
            banners += `<tr><td>id: ${item.id}</td><td>${item.name}</td></tr>`;
        });
        if (banners == "")
            banners = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}
        // users
        var users = "";
        data.users.forEach(function(item, i, arr) {
            users += `<tr><td>id: ${item.id}</td><td>${item.name}</td></tr>`;
        });
        if (users == "")
            users = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}
        // orders
        var orders = "";
        data.orders.forEach(function(item, i, arr) {
            orders += `<tr><td>id: ${item.id}</td><td>${item.updated_at}</td></tr>`;
        });
        if (orders == "")
            orders = `<tr><td>{{$lang->get(493)}}</td><td></td></tr>`;  {{--No found--}}

        var text = `<div id="div1" style="height: 400px;position:relative;">
            <div id="div2" style="max-height:100%;overflow:auto;border:1px solid grey; border-radius: 10px; height: 97%;">
            <div id="foodslist" class="row" style="position: relative; top: 10px; left: 20px; right: 10px; bottom: 20px;width: 97%; ">
                <table class="table table-bordered">
                    <tbody>

                        <tr style="background-color: paleturquoise; width=50%" >
                            <td>
                                {{$lang->get(11)}}        {{--Users--}}
                            </td>
                                <td></td>
                        </tr>
                        ${users}

                        <tr style="background-color: paleturquoise; width=50%" >
                            <td>
                                {{$lang->get(3)}}        {{--Products--}}
                            </td>
                            <td></td>
                        </tr>
                        ${foods}

                        <tr style="background-color: paleturquoise; width=50%">
                            <td>
                                {{$lang->get(2)}}        {{--categories--}}
                            </td>
                            <td></td>
                        </tr>
                        ${categories}

                        <tr style="background-color: paleturquoise;">
                            <td>
                                {{$lang->get(8)}}        {{--restaurants--}}
                            </td>
                            <td></td>
                        </tr>
                        ${restaurants}

                        <tr style="background-color: paleturquoise;">
                            <td>
                                {{$lang->get(505)}}        {{--Banners--}}
                            </td>
                            <td></td>
                        </tr>
                        ${banners}

                        <tr style="background-color: paleturquoise;">
                            <td>
                                {{$lang->get(14)}}        {{--Orders--}}
                            </td>
                            <td></td>
                        </tr>
                        ${orders}

                    </tbody>
                </table>
            </div></div></div>`;

        swal({
            title: "{{$lang->get(494)}}",  // Using the picture
            text: text,
            confirmButtonColor: "#DD6B55",
            customClass: 'swal-wide',
            html: true
        }, function (isConfirm) {
            if (isConfirm) {

            } else {

            }
        })
    }

    </script>
@endsection
