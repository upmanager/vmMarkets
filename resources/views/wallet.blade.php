@inject('userinfo', 'App\UserInfo')
@inject('currency', 'App\Currency')
@inject('lang', 'App\Lang')

@extends('bsb.app')

{{--31.01.2021--}}

@section('content')

<div class="q-card q-radius q-container">
    <!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="q-line q-mb20">
                            <h3 class="">{{$lang->get(305)}}</h3>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(294)}}</th>
                                        <th>{{$lang->get(295)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(294)}}</th>
                                        <th>{{$lang->get(295)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>
                                                <div class=\"image-cropper\">
                                                    <img src="{{$user->image}}" width="100" class='rounded'>
                                                </div>
                                            </td>
                                            <td id="balance{{$user->id}}">
                                                {{$currency->makePrice($user->balance)}}
                                            </td>
                                            <td>
                                                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="viewItem('{{$user->id}}')">
                                                    {{$lang->get(561)}} {{--View--}}
                                                </button>
                                                <button type="button" class="q-btn-all q-color-second-bkg waves-effect"
                                                        onclick="editItem('{{$user->id}}', '{{$user->balance}}')">
                                                    {{$lang->get(564)}} {{--Edit--}}
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

    </div>
</div>

<script type="text/javascript">

    function viewItem(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("walletDetails") }}',
            data: {walletId: id},
            success: function (data){
                console.log(data);
                if (data.error == '0')
                    viewItem2(id, data);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function viewItem2(id, data){
        var text = `
            <div id="div1" style="height: 400px;position:relative;">
                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid grey; border-radius: 10px; height: 97%;">
                    <div id="foodslist" class="row" style="position: relative; top: 10px; left: 20px; right: 10px; bottom: 20px;width: 97%; ">
                    <table class="table table-bordered">
                        <thead style="background-color: paleturquoise;">
                            <tr>
                                <th>{{$lang->get(68)}}</th>
                                <th>{{$lang->get(282)}}</th>
                                <th>{{$lang->get(296)}}</th>
                                <th>{{$lang->get(297)}}</th>
                                <th>{{$lang->get(295)}}</th>
                                <th>{{$lang->get(218)}}</th>
                            </tr>
                        </thead>
                        <tbody >
                        `;

        data.walletlog.forEach(function(entry){
            text = text + "<tr><td>" + entry.id + "</td>";
            text = text + "<td>" + entry.created_at + "</td>";
            text = text + "<td>" // arrive
            if (entry.arrival == "1") {
                @if ($currency->rightSymbol() == "false")
                    text = text + "{{$currency->currency()}}" + parseFloat(entry.amount).toFixed({{$currency->symbolDigits()}});
                @else
                    text = text + parseFloat(entry.amount).toFixed({{$currency->symbolDigits()}}) + "{{$currency->currency()}}";
                @endif
            }
            text = text + "</td>"
            text = text + "<td>"// lose
            if (entry.arrival != "1") {
                @if ($currency->rightSymbol() == "false")
                    text = text + "{{$currency->currency()}}" + parseFloat(entry.amount).toFixed({{$currency->symbolDigits()}});
                @else
                    text = text + parseFloat(entry.amount).toFixed({{$currency->symbolDigits()}}) + "{{$currency->currency()}}";
                @endif
            }
            text = text + "</td>"
            text = text + "<td>"// balance
            @if ($currency->rightSymbol() == "false")
                text = text + "{{$currency->currency()}}" + parseFloat(entry.total).toFixed({{$currency->symbolDigits()}});
            @else
                text = text + parseFloat(entry.total).toFixed({{$currency->symbolDigits()}}) + "{{$currency->currency()}}";
            @endif
            text = text + "</td>"
            text = text + "<td>" + entry.comment + "</td>";
            text = text + "</tr>";
        });
        text = text + `</tbody>
                    </table>
                 </div>
                 </div>
            </div>`;
        swal({
            title: "{{$lang->get(298)}}",
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

    var balanceForDialog = 0;
    var userId = 0;

    function editItem(id, balance){

        var value = document.getElementById('balance'+id).innerHTML.trim();

        @if ($currency->rightSymbol() == "false")
            value = value.substr(1);
        @else
            value = value.substring(0, value.length - 1);
        @endif
        balanceForDialog = parseFloat(value);
        userId = id;
        var text = `
            <div id="div1" style="height: 400px;position:relative;">
                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid grey; border-radius: 10px; height: 97%;">
                    <div id="foodslist" class="row" style="position: relative; top: 10px; left: 20px; right: 10px; bottom: 20px;width: 97%; ">
                    <table class="table table-bordered">
                        <tbody >
                        <tr>`;
        text = text + "<td><h5>{{$lang->get(299)}}:</h5></td>";

        text = text + "<td>";
        @if ($currency->rightSymbol() == "false")
            text = text + "{{$currency->currency()}}" + balanceForDialog.toFixed({{$currency->symbolDigits()}});
        @else
            text = text + balanceForDialog.toFixed({{$currency->symbolDigits()}}) + "{{$currency->currency()}}";
        @endif
        text = text + "</td></tr>";

        text = text + `<tr>
                        <td><h5>{{$lang->get(300)}}:</h5></td>      {{--New Balance--}}
                        <td>
                            <input type="number" id="newBalance" style="display: table-cell;" min="0" max="10000" oninput="onInput();" placeholder="{{$lang->get(301)}}">
                        </td></tr>
                        <tr><td><h5>{{$lang->get(302)}}:</h5></td>
                        <td><h5 id="diff"></h5></td></tr>
                        <tr><td><h5>{{$lang->get(218)}}:</h5></td>
                        <td>
                          <input type="text" id="comments" style="display: table-cell;" placeholder="{{$lang->get(303)}}">
                        </td>
                        </tr></tbody>
                    </table>
                 </div>
                 </div>
            </div>`;
        swal({
            title: "{{$lang->get(304)}}",
            text: text,
            confirmButtonColor: "#DD6B55",
            customClass: 'swal-wide',
            html: true
        }, function (isConfirm) {
            if (isConfirm) {
                var comments = document.getElementById('comments').value;
                console.log(comments);
                var value = parseFloat(document.getElementById('newBalance').value);
                console.log(value);
                if (!isNaN(value)){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("walletChangeBalans") }}',
                        data: {
                            comments: comments,
                            balance : value,
                            id : userId,
                        },
                        success: function (data){
                            console.log(data);
                            var text = "";
                            @if ($currency->rightSymbol() == "false")
                                text = "{{$currency->currency()}}" + parseFloat(value).toFixed({{$currency->symbolDigits()}});
                            @else
                                text = parseFloat(value).toFixed({{$currency->symbolDigits()}}) + "{{$currency->currency()}}";
                            @endif
                            document.getElementById('balance'+userId).innerHTML = text;
                        },
                        error: function(e) {
                            console.log(e);
                        }}
                    );

                }
            } else {

            }
        })
    }

    function onInput(){
        var value = parseFloat(document.getElementById('newBalance').value);
        if (value.isEmpty)
            value = 0;
        if (isNaN(value))
            value = 0;
        if (value > 10000)
            value = 10000;
        if (value < 0)
            value = 0;
        document.getElementById('newBalance').value = value;
        document.getElementById('diff').innerHTML = (value-balanceForDialog).toFixed(2);
    }

</script>

@endsection
