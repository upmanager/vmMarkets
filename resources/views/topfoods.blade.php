@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('currency', 'App\Currency')

{{-- 31.01.2021--}}

@section('content')
<div class="q-card q-radius q-container">
    <div class="header q-line">
        <h3 class="">{{$lang->get(7)}}</h3> {{--Top Products on Home Screen--}}
    </div>
    <div class="body">
        <div class="row clearfix js-sweetalert">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="body">
                        <div class="col-md-6">
                            <img src="img/top.jpg">
                        </div>
                        <div class="col-md-6">
                            @include('elements.form.greeninfo', array('title' => $lang->get(528), 'body1' => $lang->get(559), 'body2' => ""))  {{--Information - Create your own Top Trending list --}}
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>{{$lang->get(69)}}</th>
                                    <th>{{$lang->get(70)}}</th>
                                    <th>{{$lang->get(88)}}</th>
                                    <th>{{$lang->get(89)}}</th>
                                    <th>{{$lang->get(72)}}</th>
                                    <th>{{$lang->get(74)}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>{{$lang->get(69)}}</th>
                                    <th>{{$lang->get(70)}}</th>
                                    <th>{{$lang->get(88)}}</th>
                                    <th>{{$lang->get(89)}}</th>
                                    <th>{{$lang->get(72)}}</th>
                                    <th>{{$lang->get(74)}}</th>
                                </tr>
                                </tfoot>
                                <tbody id="tbodyView">

                                @foreach($topfoods as $key => $data)
                                    <tr id="tr{{$data->id}}">
                                        <td>{{$data->name}}</td>
                                        <td><img src="images/{{$data->image}}" height="50" style='min-height: 50px; ' alt=""></td>
                                        <td>{{$currency->makePrice($data->price)}}
                                        </td>
                                        <td>{{$data->restaurantName}}</td>
                                        <td>{{$data->updated_at}}</td>
                                        <td>
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
            @include('elements.addfoods', array('id' => "addfoods", 'onclick' => "selectFood", 'label' => $lang->get(120)))  {{-- Add New --}}
        </div>
    </div>
</div>

<script>
    function selectFood(market, product){
        console.log(market, product);
        addFood(product);
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
                    url: '{{ url("topfooddelete") }}',
                    data: {id: id},
                    success: function (data){
                        console.log(data);
                        if (data.error != "0") {
                            if (data.error == '2')
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        showNotification("bg-teal", "{{$lang->get(527)}}", "bottom", "center", "", ""); // Product deleted
                        var div = document.getElementById('tr'+id);
                        div.remove();
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    function addFood(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("topFoodsAdd") }}',
            data: {
                id: id,
            },
            success: function (data){
                console.log(data);
                if (data.ret) {
                    showNotification("bg-teal", "Food added", "bottom", "center", "", "");
                    addTableWithDishes(data);
                }else{
                    showNotification("bg-purple", data.text, "bottom", "center", "", "");
                }
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function addTableWithDishes(data){
        document.getElementById("tbodyView").innerHTML = "";
        data.topfoods.forEach(function(entry){
            var div = document.createElement("tr");
            div.id = "tr"+entry.id;
            var price = parseFloat(entry.price).toFixed(data.symbolDigits) + data.currency;
            if (data.rightSymbol)
                price = data.currency + parseFloat(entry.price).toFixed(data.symbolDigits);
            div.innerHTML = "<td>"+entry.name+"</td>\n" +
                "<td><img src=\"images/"+entry.image+"\" height=\"50\" style='min-height: 50px; ' alt=\"\"></td>\n" +
                "<td>"+price+"</td>\n" +
                "<td>"+entry.restaurantName+"</td>\n" +
                "<td>"+entry.updated_at+"</td>\n" +
                "<td>\n" +
                "<button type=\"button\" class=\"btn btn-default waves-effect\" onclick=\"showDeleteMessage('"+entry.id+"')\">\n" +
                "<img src=\"img/icondelete.png\" width=\"25px\">\n" +
                "</button>\n" +
                "</td>";
            document.getElementById("tbodyView").appendChild(div);
        });
    }

</script>

@endsection
