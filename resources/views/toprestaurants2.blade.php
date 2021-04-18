@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('currency', 'App\Currency')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')
<div class="q-card q-radius q-container">
    <div class="header q-line">
        <h3 class="">{{$lang->get(185)}}</h3> {{--Top Markets Management--}}
    </div>
    <div class="body">
        <div class="row clearfix js-sweetalert">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="body">
                    <div class="col-md-6">
                        <img src="img/topr.jpg">
                    </div>
                    <div class="col-md-6">
                        @include('elements.form.greeninfo', array('title' => $lang->get(528), 'body1' => $lang->get(560), 'body2' => ""))  {{--Information - Create your own Top Market list --}}
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(72)}}</th>
                                <th>{{$lang->get(74)}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(72)}}</th>
                                <th>{{$lang->get(74)}}</th>
                            </tr>
                            </tfoot>
                            <tbody id="tbodyView">

                            @foreach($toprestaurants as $key => $data)
                                <tr id="tr{{$data->id}}">
                                    <td>{{$data->name}}</td>
                                    <td><img src="images/{{$data->image}}" height="50" style='min-height: 50px; ' alt=""></td>
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
            <div class="col-md-12">
                <div align="right">
                    <button type="button" onclick="selectFood()" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(186)}}</h5></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectFood(){
        var text = "<div id=\"div1\" style=\"height: 400px;position:relative;\">" +
            "<div id=\"div2\" style=\"max-height:100%;overflow:auto;border:1px solid grey; border-radius: 10px; height: 97%;\">" +
            "<div id=\"foodslist\" class=\"row\" style=\"position: relative; top: 10px; left: 20px; right: 10px; bottom: 20px;width: 97%; \">" +
            "<table class=\"table table-bordered\">\n" +
            "                <tbody> <thead style=\"background-color: paleturquoise;\">\n" +
            "<tr>" +
            "<th style=\"text-align: center;\">{{$lang->get(69)}}</th>" +
            "<th style=\"text-align: center;\">{{$lang->get(70)}}</th>" +
            "<th style=\"text-align: center;\">{{$lang->get(74)}}</th>" +
            "</tr>" +
            "                </thead>\n" +
            "                <tbody id=\"foods\">";
        @foreach($restaurants as $key => $data)
            text = text + "<tr><td>{{$data->name}}</td>";
            text = text + "<td><img src=\"images/{{$data->image}}\" width=\"70px\"></td>";
            text = text + "<td><div onclick=\"addToList({{$data->id}})\" class=\"q-btn-all q-color-second-bkg waves-effect\"><h5>{{$lang->get(181)}}</h5></div></td></tr>";
        @endforeach
            text = text + "                </tbody>\n" +
            "                </tbody>\n" +
            "                </table>\n</div></div></div>"
        swal({
            title: "{{$lang->get(187)}}",
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
                    url: '{{ url("topRestaurantsDelete") }}',
                    data: {id: id},
                    success: function (data){
                        console.log(data);
                        if (data.error != "0") {
                            if (data.error == '2')
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        showNotification("bg-teal", "{{$lang->get(525)}}", "bottom", "center", "", ""); // Restaurant deleted
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

    function addToList(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("topRestaurantsAdd") }}',
            data: {
                id: id,
            },
            success: function (data){
                console.log(data);
                if (data.ret) {
                    showNotification("bg-teal", "{{$lang->get(188)}}", "bottom", "center", "", "");
                    addTableWithRestaurants(data);
                }else{
                    showNotification("bg-red", data.text, "bottom", "center", "", "");
                }
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function addTableWithRestaurants(data){
        document.getElementById("tbodyView").innerHTML = "";
        data.toprestaurants.forEach(function(entry){
            var div = document.createElement("tr");
            div.id = "tr"+entry.id;
            var price = parseFloat(entry.price).toFixed(data.symbolDigits) + data.currency;
            if (data.rightSymbol)
                price = data.currency + parseFloat(entry.price).toFixed(data.symbolDigits);
            div.innerHTML = "<td>"+entry.name+"</td>\n" +
                "<td><img src=\"images/"+entry.image+"\" height=\"50\" style='min-height: 50px; ' alt=\"\"></td>\n" +
                "<td>"+entry.updated_at+"</td>\n" +
                "<td>\n" +
                "<button type=\"button\" class=\"btn btn-default waves-effect\" onclick=\"showDeleteMessage2('"+entry.id+"')\">\n" +
                "<img src=\"img/icondelete.png\" width=\"25px\">\n" +
                "</button>\n" +
                "</td>";
            document.getElementById("tbodyView").appendChild(div);
        });
    }


</script>

@endsection
