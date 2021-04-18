@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--03.02.2021--}}

@section('content')

<div class="q-container">
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
                            <h3>
                                {{$lang->get(149)}}
                            </h3>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>{{$lang->get(69)}}</th>
                                        <th>{{$lang->get(70)}}</th>
                                        <th>{{$lang->get(71)}}</th>
                                        <th>{{$lang->get(150)}}</th>
                                        <th>{{$lang->get(151)}}</th>
                                        <th>{{$lang->get(152)}}</th>
                                        <th>{{$lang->get(73)}}</th>
                                        <th>{{$lang->get(72)}}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{$lang->get(69)}}</th>
                                        <th>{{$lang->get(70)}}</th>
                                        <th>{{$lang->get(71)}}</th>
                                        <th>{{$lang->get(150)}}</th>
                                        <th>{{$lang->get(151)}}</th>
                                        <th>{{$lang->get(152)}}</th>
                                        <th>{{$lang->get(73)}}</th>
                                        <th>{{$lang->get(72)}}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    @foreach($restaurants as $key => $data)
                                        <tr id="tr{{$data->id}}">
                                            <td>{{$data->name}}</td>
                                            <td>
                                                <img src="images/{{$data->filename}}" height="50" style='min-height: 50px; ' alt="">
                                            </td>

                                            <td>{{$data->desc}}</td>

                                            <td>{{$data->address}}</td>

                                            <td>{{$data->phone}}</td>

                                            <td>{{$data->mobilephone}}</td>

                                            <td>
                                                @include('elements.form.check2', array('id' => "vi" . $data->id, 'callback' => "onclickCheck", 'initvalue' => $data->published))
                                            </td>

                                            <td>{{$data->updated_at}}</td>

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
    </div>
</div>

<script>
    function onclickCheck(id, value){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("restaurantEnable") }}',
            data: {
                id: id.substr(2),
                value: (value) ? '1' : '0',
            },
            success: function (data){
                console.log(data);
                if (data.ret != '0')
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong

                showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

</script>

@endsection

