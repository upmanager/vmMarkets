@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')

@section('content')

{{--31.01.2021--}}

<div class="body q-container">

    <!-- Tabs -->

    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
        <li role="presentation"><a href="#create" data-toggle="tab" ><h4>{{$lang->get(65)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            @if ($texton == "green")
                <div class="alert bg-green" >
                    {{$text}}
                </div>
            @endif
            <div id="redzone" class="alert bg-red" hidden>
            </div>

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="header">
                            <h3>
                                {{$lang->get(281)}}
                            </h3>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{$lang->get(282)}}</th>
                                        <th>{{$lang->get(283)}}</th>
                                        <th>{{$lang->get(284)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(70)}}</th>
                                        <th>{{$lang->get(285)}}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>{{$lang->get(282)}}</th>
                                        <th>{{$lang->get(283)}}</th>
                                        <th>{{$lang->get(284)}}</th>
                                        <th>{{$lang->get(137)}}</th>
                                        <th>{{$lang->get(70)}}</th>
                                        <th>{{$lang->get(285)}}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    @foreach($idata as $key => $data)
                                        <tr id="tr{{$data->id}}">
                                            <td>{{$data->updated_at}}</td>

                                            <td>{{$data->title}}</td>

                                            <td>{{$data->text}}</td>

                                            <td>
                                                @if ($data->show == 2)
                                                    {{$lang->get(608)}}  {{--Send to All Users--}}
                                                @endif
                                                @if ($data->show != 2)
                                                    @foreach($iusers as $key => $value)
                                                        @if ($value->id == $data->user)
                                                            {{$value->name}}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($petani as $key => $dataimage)
                                                    @if ($dataimage->id == $data->image)
                                                        <img src="images/{{$dataimage->filename}}" height="50" style='min-height: 50px; ' alt="">
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>Read {{$data->countRead}} from {{$data->countAll}} users</td>
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

        <div role="tabpanel" class="tab-pane fade" id="create">
            <div class="q-card q-radius q-container">
                <div class="row clearfix">
                        @include('elements.form.selectUsers', array('label' => $lang->get(137), 'id' => "user", 'request' => "true", 'maxlength' => "100"))  {{-- User - --}}
                        @include('elements.form.text', array('label' => $lang->get(283), 'text' => $lang->get(287), 'id' => "title", 'request' => "true", 'maxlength' => "100"))  {{-- Title - Insert message title --}}
                        @include('elements.form.text', array('label' => $lang->get(288), 'text' => $lang->get(289), 'id' => "text", 'request' => "true", 'maxlength' => "200"))  {{-- Body text - Insert message text --}}
                        @include('elements.form.image', array())
                        @include('elements.form.button', array('label' => $lang->get(291), 'onclick' => "onSend();"))  {{-- Send Notification --}}
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    addEditImage('{{$defaultImageId}}', '{{$defaultImage}}');

    function onSend(){
        var data = {
            user: $('select[id=user]').val(),
            title: document.getElementById("title").value,
            text: document.getElementById("text").value,
            imageid: imageid,
        };

        if (!document.getElementById("title").value)
            return showNotification("bg-red", "{{$lang->get(565)}}", "bottom", "center", "", "");  // "The `Title` field is required.".
        if (!document.getElementById("text").value)
            return showNotification("bg-red", "{{$lang->get(566)}}", "bottom", "center", "", "");  // The `Text` field is required.

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("sendmsg") }}',
            data: data,
            success: function (data){
                console.log(data);
                if (data.error != "0")
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                window.location="{{route('notify')}}";
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }


</script>

@endsection
