@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--03.02.2021--}}

@section('content')

<!-- ChartJs -->
<script src="plugins/chartjs/Chart.bundle.js"></script>

<div class="q-container">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div id="orders" class="q-info-box q-color-second-bkg hover-zoom-effect q-radius">
                <div class="icon">
                    <i class="material-icons">payment</i>
                </div>
                <div class="content">
                    <div class="q-font-30 q-font-bold">{{$currency}}{{$earning}}</div>
                    <div class="q-font-15">{{$lang->get(38)}}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div id="orders4" class="q-info-box q-color-cyan-bkg hover-zoom-effect q-radius">
                <div class="icon">
                    <i class="material-icons">assessment</i>
                </div>
                <div class="content">
                    <div class="q-font-30 q-font-bold">{{$orderscount}}</div>
                    <div class="q-font-15">{{$lang->get(39)}}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div id="users" class="q-info-box q-color-success-bkg hover-zoom-effect q-radius">
            <div class="icon">
                <i class="material-icons">person_outline</i>
            </div>
            <div class="content">
                <div class="q-font-30 q-font-bold">{{$userscount}}</div>
                <div class="q-font-15">{{$lang->get(40)}}</div>
            </div>
        </div>
        </div>

        @if (Auth::user()->role == 1)
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="restaurants" class="q-info-box q-color-purple-bkg hover-zoom-effect q-radius">
                    <div class="icon">
                        <i class="material-icons">restaurant</i>
                    </div>
                    <div class="content">
                        <div class="q-font-30 q-font-bold">{{$restaurantsCount}}</div>
                        <div class="q-font-15">{{$lang->get(41)}}</div>
                    </div>
                </div>
            </div>
        @endif

        <div id="orders2" class="col-md-12 q-mb20">
            <div class="q-card">
                <div class="q-container">
                    <canvas id="line_chart" height="50"></canvas>
                </div>
            </div>
        </div>

        <div id="orders3" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="q-card q-container">
                <div class="table_header">
                    <div class="q-line q-mb20">
                        <h3>
                            {{$lang->get(42)}}  {{--last 10 orders--}}
                        </h3>
                    </div>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{$lang->get(43)}}</th>
                                @if (Auth::user()->role == 1)
                                <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(44)}}</th>
                                <th>{{$lang->get(45)}}</th>
                                <th>{{$lang->get(46)}}</th>
                                <th>{{$lang->get(48)}}</th>
                                <th>{{$lang->get(49)}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>{{$lang->get(43)}}</th>
                                @if (Auth::user()->role == 1)
                                <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(44)}}</th>
                                <th>{{$lang->get(45)}}</th>
                                <th>{{$lang->get(46)}}</th>
                                <th>{{$lang->get(48)}}</th>
                                <th>{{$lang->get(49)}}</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($iorders as $key => $data)
                                @if ($data->send == 1)
                                    <tr id="tr{{$data->id}}">
                                        <td>{{$data->id}}</td>
                                        @if (Auth::user()->role == 1)
                                        <td>{{$data->restaurantName}}</td>
                                        @endif
                                        <td id="total{{$data->id}}">{{$currency}}{{$data->total}}</td>
                                        <td>
                                            @foreach($iusers as $key => $idata)
                                                @if ($idata->id == $data->user)
                                                    {{$idata->name}}
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach($iorderstatus as $key => $idata)
                                                @if ($idata->id == $data->status)
                                                    {{$idata->status}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($data->curbsidePickup == "true")
                                                <span class="q-label q-color-label2 q-color-bkg-label2 q-radius">{{$lang->get(213)}}</span> {{--curbsidePickup--}}
                                            @endif
                                            @if ($data->arrived == "true")
                                                    <span class="q-label q-color-label2 q-color-bkg-label2 q-radius">{{$lang->get(214)}}</span><br> {{--customer arrived--}}
                                            @else
                                                <br>
                                            @endif
                                            <span class="q-label q-color-label1 q-color-bkg-label1 q-radius">{{$data->method}}</span>
                                        </td>
                                        <td>{{$data->updated_at}}</td>
                                    </tr>
                                @endif

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));

    function getChartJs(type) {
        var config = null;

        if (type === 'line') {
            config = {
                type: 'line',
                data: {
                    labels: ["{{$lang->get(50)}}", "{{$lang->get(51)}}", "{{$lang->get(52)}}", "{{$lang->get(53)}}",
                        "{{$lang->get(54)}}", "{{$lang->get(55)}}", "{{$lang->get(56)}}", "{{$lang->get(57)}}",
                        "{{$lang->get(58)}}", "{{$lang->get(59)}}", "{{$lang->get(60)}}", "{{$lang->get(61)}}"],
                    datasets: [{
                        label: "{{$lang->get(62)}}",
                        data: [{{$e1}}, {{$e2}}, {{$e3}}, {{$e4}}, {{$e5}}, {{$e6}}, {{$e7}}, {{$e8}}, {{$e9}}, {{$e10}}, {{$e11}}, {{$e12}}],
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: false
                }
            }
        }
        return config;
    }

    var orders = document.getElementById('orders');
    orders.style.cursor = 'pointer';
    orders.onclick = function() {
        window.location='orders';
    };

    var orders2 = document.getElementById('orders2');
    orders2.style.cursor = 'pointer';
    orders2.onclick = function() {
        window.location='orders';
    };

    var orders3 = document.getElementById('orders3');
    orders3.style.cursor = 'pointer';
    orders3.onclick = function() {
        window.location='orders';
    };

    var orders4 = document.getElementById('orders4');
    orders4.style.cursor = 'pointer';
    orders4.onclick = function() {
        window.location='orders';
    };

    @if (Auth::user()->role == 1)
        var users = document.getElementById('users');
        users.style.cursor = 'pointer';
        users.onclick = function() {
            window.location='users';
        };

        var restaurants = document.getElementById('restaurants');
        if (restaurants != null) {
            restaurants.style.cursor = 'pointer';
            restaurants.onclick = function () {
                window.location = 'restaurants';
            };
        }
    @endif

</script>
@endsection
