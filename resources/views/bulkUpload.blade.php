@inject('lang', 'App\Lang')
@extends('bsb.app')
@inject('utils', 'App\Util')

{{--10.02.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(584)}}</h4></a></li> {{--Bulk Upload--}}
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header q-line q-mb20">
                            <h3>
                                {{$lang->get(592)}}  {{--UPLOAD PRODUCTS--}}
                            </h3>
                        </div>
                        <div class="d-flex flex-column">

                            @include('elements.form.csv', array('label' => $lang->get(588), 'request' => "true",
                                    'id' => "image", 'label2' => $lang->get(585), 'deleteText' => $lang->get(586),
                                    'error1' => $lang->get(587),))   {{-- Upload CSV file with data - Drop CSV file here or click to upload.. - Delete - You can not upload more then one file. --}}

                            @include('elements.form.button', array('label' => $lang->get(589), 'onclick' => "onUpload();"))  {{-- Upload  --}}

                            <div class="d-flex q-line q-mb20 q-mt20"></div>
                            <div class="d-flex q-font-bold q-font-20">{{$lang->get(593)}}</div>     {{--Important!--}}
                            <div class="d-flex q-font-15 ">{{$lang->get(594)}}</div>  {{--You can find example csv file in csv folder. Also you can find example ods file (for Open Office calc)--}}
                            <div class="d-flex q-font-15 q-mb20">{{$lang->get(595)}}</div>  {{--All images need upload to server, to public/images folder--}}
                            <img src="img/bulk.jpg">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    function onUpload(){
        if (dropZoneFileName == "")
            return showNotification("bg-red", "{{$lang->get(590)}}", "bottom", "center", "", "");  // Select CSV file
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("csvProcess") }}',
            data: {
                file: dropZoneFileName,
            },
            success: function (data){
                console.log(data);
                if (data.error != "0")
                    return showNotification("bg-red", data.text, "bottom", "center", "", "");  // demo mode
                showNotification("pastel-info", "{{$lang->get(591)}} " + data.count, "bottom", "center", "", "");  // Number of products added
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

</script>

@endsection
