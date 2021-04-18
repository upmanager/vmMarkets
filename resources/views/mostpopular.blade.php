@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')
<div class="body">

    <div class="row clearfix js-sweetalert">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="q-card q-radius q-container">
                <div class="q-line q-mb20">
                    <h3 class="">{{$lang->get(243)}}</h3>       {{--Most Popular Products - Choice of Customers--}}
                </div>
                <div class="body">
                    <img src="img/favorites.jpg" class="q-mb20">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="q-color-bkg-label1">
                            <tr>
                                @if ($role == 1)
                                    <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(244)}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                @if ($role == 1)
                                    <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(244)}}</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($idata as $key => $data)
                                <tr>
                                    @if ($role == 1)
                                        <td>{{$data->restaurantname}}</td>
                                    @endif
                                    <td>{{$data->name}}</td>
                                    <td><img src="images/{{$data->image}}" height="50"></td>
                                    <td>{{$data->result}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

            <div class="q-card q-radius q-container">
                <div class="q-line q-mb20">
                    <h5>{{$lang->get(245)}}</h5>        {{--Last added products to Favorites--}}
                </div>
                <div class="body">
                    <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                <thead class="q-color-bkg-label1">
                <tr>
                    @if ($role == 1)
                        <th>{{$lang->get(47)}}</th> {{--Market--}}
                    @endif
                    <th>{{$lang->get(69)}}</th>
                    <th>{{$lang->get(70)}}</th>
                    <th>{{$lang->get(246)}}</th>
                    <th>{{$lang->get(223)}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    @if ($role == 1)
                        <th>{{$lang->get(47)}}</th> {{--Market--}}
                    @endif
                    <th>{{$lang->get(69)}}</th>
                    <th>{{$lang->get(70)}}</th>
                    <th>{{$lang->get(246)}}</th>
                    <th>{{$lang->get(223)}}</th>
                </tr>
                </tfoot>
                <tbody>

                @foreach($data2 as $key => $data)
                    <tr>
                        @if ($role == 1)
                            <td>{{$data->restaurantname}}</td>
                        @endif
                        <td>{{$data->name}}</td>
                        <td><img src="images/{{$data->image}}" height="50"></td>
                        <td>{{$data->customername}}</td>
                        <td><div class="q-font-bold q-color-second">{{$data->timeago}}</div> {{$data->updated_at}}</td>
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

@endsection
