@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

{{--31.01.2021--}}

@section('content')

<!-- Ckeditor -->
<script src="plugins/ckeditor/ckeditor.js"></script>

<div class="q-card q-radius q-container">

    <div class="q-line q-mb20">
        <h3 class="">{{$lang->get(497)}}</h3> {{--Documents--}}
    </div>

    <div class="body">
        <div class="row clearfix">

            <div class="col-md-12">
                <label><h4>{{$lang->get(530)}}</h4></label> {{--Copyright--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(531), 'text' => $lang->get(532), 'id' => "copyright", 'request' => "false", 'maxlength' => "100"))  {{-- Copyright text - Insert Copyright text --}}

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                <label><h4>{{$lang->get(499)}}</h4></label> {{--"About Us",--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "about_name", 'request' => "false", 'maxlength' => "100"))  {{-- Name - Insert Name --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 form-control-label text-right">
                    <label for="ckeditor"><h4>{{$lang->get(500)}}</h4></label> {{--Context--}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-line">
                        <textarea id="ckeditor_about" name="desc">
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                <label><h4>{{$lang->get(501)}}</h4></label> {{--Terms and Condition--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "terms_name", 'request' => "false", 'maxlength' => "100"))  {{-- Name - Insert Name --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 form-control-label text-right">
                    <label for="ckeditor"><h4>{{$lang->get(500)}}</h4></label> {{--Context--}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-line">
                        <textarea id="ckeditor_terms" name="desc">
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                <label><h4>{{$lang->get(502)}}</h4></label> {{--Privacy Policy--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "policy_name", 'request' => "false", 'maxlength' => "100"))  {{-- Name - Insert Name --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 form-control-label text-right">
                    <label for="ckeditor"><h4>{{$lang->get(500)}}</h4></label> {{--Context--}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-line">
                        <textarea id="ckeditor_policy" name="desc">
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                <label><h4>{{$lang->get(503)}}</h4></label> {{--Delivery info--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "delivery_name", 'request' => "false", 'maxlength' => "100"))  {{-- Name - Insert Name --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 form-control-label text-right">
                    <label for="ckeditor"><h4>{{$lang->get(500)}}</h4></label> {{--Context--}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-line">
                        <textarea id="ckeditor_delivery" name="desc">
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                <label><h4>{{$lang->get(504)}}</h4></label> {{--Refund Policy--}}
            </div>
            @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "refund_name", 'request' => "false", 'maxlength' => "100"))  {{-- Name - Insert Name --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 form-control-label text-right">
                    <label for="ckeditor"><h4>{{$lang->get(500)}}</h4></label> {{--Context--}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-line">
                        <textarea id="ckeditor_refund" name="desc">
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-12">
                @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSave();"))  {{-- Save --}}
            </div>

        </div>
    </div>
</div>

<script>
    CKEDITOR.config.height = 100;
    CKEDITOR.replace('ckeditor_about');
    CKEDITOR.replace('ckeditor_terms');
    CKEDITOR.replace('ckeditor_policy');
    CKEDITOR.replace('ckeditor_delivery');
    CKEDITOR.replace('ckeditor_refund');

    CKEDITOR.instances['ckeditor_about'].setData(`{!! $util->getDoc("about_text") !!}`);
    CKEDITOR.instances['ckeditor_terms'].setData(`{!! $util->getDoc("terms_text") !!}`);
    CKEDITOR.instances['ckeditor_policy'].setData(`{!! $util->getDoc("privacy_text") !!}`);
    CKEDITOR.instances['ckeditor_delivery'].setData(`{!! $util->getDoc("delivery_text") !!}`);
    CKEDITOR.instances['ckeditor_refund'].setData(`{!! $util->getDoc("refund_text") !!}`);

    document.getElementById("copyright").value = `{{$util->getDoc("copyright_text")}}`;
    document.getElementById("about_name").value = `{{$util->getDoc("about_text_name")}}`;
    document.getElementById("terms_name").value = `{{$util->getDoc("terms_text_name")}}`;
    document.getElementById("policy_name").value = `{{$util->getDoc("privacy_text_name")}}`;
    document.getElementById("delivery_name").value = `{{$util->getDoc("delivery_text_name")}}`;
    document.getElementById("refund_name").value = `{{$util->getDoc("refund_text_name")}}`;

    function onSave(){
        var data = {
            copyright: document.getElementById("copyright").value,
            about: document.getElementById("about_name").value,
            terms: document.getElementById("terms_name").value,
            policy: document.getElementById("policy_name").value,
            delivery: document.getElementById("delivery_name").value,
            refund: document.getElementById("refund_name").value,
            about_text: CKEDITOR.instances["ckeditor_about"].getData(),
            terms_text: CKEDITOR.instances["ckeditor_terms"].getData(),
            privacy_text: CKEDITOR.instances["ckeditor_policy"].getData(),
            delivery_text: CKEDITOR.instances["ckeditor_delivery"].getData(),
            refund_text: CKEDITOR.instances["ckeditor_refund"].getData(),
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("docsave") }}',
            data: data,
            success: function (data){
                console.log(data);
                if (data.error != "0")
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

</script>


@endsection
