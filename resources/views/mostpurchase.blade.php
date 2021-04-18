@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')

<div class="body q-container">
    <div class="row clearfix js-sweetalert">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="q-card q-radius q-container">
                <div class="q-line q-mb20">
                    <h3 class="">{{$lang->get(247)}}</h3>       {{--Most Purchase Products--}}
                </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                @if ($role == 1)
                                    <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(248)}}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                @if ($role == 1)
                                    <th>{{$lang->get(47)}}</th> {{--Market--}}
                                @endif
                                <th>{{$lang->get(69)}}</th>
                                <th>{{$lang->get(70)}}</th>
                                <th>{{$lang->get(248)}}</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($idata as $key => $data)
                                <tr >
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
    </div>
</div>

@endsection

