@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')
<div class="body q-container">
    <div class="row clearfix js-sweetalert">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="q-card q-radius q-container">
                <div class="q-line q-mb20">
                    <h3 class="">{{$lang->get(249)}}</h3> {{--Most Purchase Markets--}}
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>{{$lang->get(69)}}</th>  {{--Name--}}
                                <th>{{$lang->get(250)}}</th>   {{--Orders Count--}}
                                <th>{{$lang->get(38)}}</th>   {{--Total Earnings--}}
                                <th>{{$lang->get(70)}}</th>     {{--Image--}}
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>{{$lang->get(69)}}</th>  {{--Name--}}
                                <th>{{$lang->get(250)}}</th>   {{--Orders Count--}}
                                <th>{{$lang->get(38)}}</th>   {{--Total Earnings--}}
                                <th>{{$lang->get(70)}}</th>     {{--Image--}}
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($idata as $key => $data)
                                <tr >
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->result}}</td>
                                    <td>{{$data->total}}</td>
                                    <td><img src="images/{{$data->image}}" height="50"></td>
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
