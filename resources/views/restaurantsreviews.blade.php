@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--03.02.2021--}}

@section('content')

<div class="q-container">

    <!-- Tabs -->

    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="home">
            @if ($texton == "green")
                <div class="alert bg-green" >
                    {{$text}}
                </div>
            @endif

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="q-line q-mb20">
                            <h3>
                                {{$lang->get(183)}}
                            </h3>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(140)}}</th>
                                        <th>{{$lang->get(136)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(89)}}</th>
                                        <th>{{$lang->get(72)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{$lang->get(68)}}</th>
                                        <th>{{$lang->get(140)}}</th>
                                        <th>{{$lang->get(136)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(89)}}</th>
                                        <th>{{$lang->get(72)}}</th>
                                        <th>{{$lang->get(74)}}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    @foreach($idata as $key => $data)
                                        <tr id="tr{{$data->id}}">
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->desc}}</td>

                                            <td>{{$data->rate}}</td>

                                            <td>
                                            @foreach($iusers as $key => $idata)
                                                @if ($idata->id == $data->user)
                                                    {{$idata->name}}
                                                @endif
                                            @endforeach
                                            </td>

                                            <td>
                                            @foreach($irestaurants as $key => $idata)
                                                @if ($idata->id == $data->restaurant)
                                                    {{$idata->name}}
                                                @endif
                                            @endforeach
                                            </td>

                                            <td>{{$data->updated_at}}</td>

                                            <td>
                                                
                                                <button type="button" class="btn btn-default waves-effect"
                                                        onclick="editItem('{{$data->id}}',
                                                            '{{$data->user}}', '{{$data->restaurant}}',
                                                            '{{$data->rate}}', '{{$data->desc}}',
                                                            )">
                                                    <img src="img/iconedit.png" width="25px">
                                                </button>
                                                
                                                <button type="button" class="btn btn-default waves-effect" onclick="showDeleteMessage('{{$data->id}}')">
                                                    <img src="img/icondelete.png" width="25px">
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

    </div>
</div>
<script type="text/javascript">

    function showDeleteMessage(id) {
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
                    url: '{{ url("restaurantsreviewdelete") }}',
                    data: {id: id},
                    success: function (data){
                        if (!data.ret)
                            return showNotification("bg-red", data.text, "bottom", "center", "", "");
                        //
                        // remove from ui
                        //
                        var table = $('#data_table').DataTable();
                        var indexes = table
                            .rows()
                            .indexes()
                            .filter( function ( value, index ) {
                                return id === table.row(value).data()[0];
                            } );
                        var page = moveToPageWithSelectedItem(id);
                        table.rows(indexes).remove().draw();
                        table.page(page).draw(false);
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

</script>

@endsection
