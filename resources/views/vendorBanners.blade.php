@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

{{--06.02.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>   {{--LIST--}}
        <li role="presentation"><a href="#create" data-toggle="tab" ><h4>{{$lang->get(65)}}</h4></a></li> {{--CREATE--}}
        <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li> {{--EDIT--}}
    </ul>

    <!-- Tab List -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header q-line q-mb20">
                        <h3>
                            {{$lang->get(508)}} {{--BANNERS LIST--}}
                        </h3>
                    </div>
                    <div class="body">
                        @include('elements.bannersTableVendor', array())
                    </div>
                </div>
            </div>

        </div>
            <!-- Tab Create -->

        <div role="tabpanel" class="tab-pane fade" id="create">

            <div id="form">
                <div class="row clearfix q-mt20 q-mb20">
                    <div class="col-md-6 ">
                        @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "name", 'request' => "true", 'maxlength' => "40"))  {{-- Name - Insert Name --}}
                        @include('elements.form.selectBannerType', array('label' => $lang->get(512), 'onchange' => "onChangeType();", 'id' => "banner_type", 'request' => "true"))   {{--Type--}}
                        @include('elements.form.selectFoods', array('label' => $lang->get(1), 'onchange' => "", 'id' => "foodForBanner", 'request' => "true", 'noitem' => "false"))   {{--Product--}}
                        @include('elements.form.text', array('label' => $lang->get(515), 'text' => $lang->get(516), 'id' => "url", 'request' => "true", 'maxlength' => "1000"))  {{-- URL - Insert External Link --}}
                        <div class="col-md-4 " >
                        </div>
                        <div class="col-md-8 " style="margin-top: 20px">
                            @include('elements.form.check', array('id' => "visible", 'text' => $lang->get(75), 'initvalue' => "true"))  {{--Published item--}}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        @include('elements.form.image', array())
                    </div>
                </div>
                @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSave();"))  {{-- Save --}}
            </div>

        </div>

        <!-- Tab Edit -->

        <div role="tabpanel" class="tab-pane fade" id="edit">
        </div>

    </div>
</div>

<script type="text/javascript">

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href")
        if (target != "#edit")
            document.getElementById("tabEdit").style.display = "none";
        if (target == "#create") {
            clearForm();
            document.getElementById('create').appendChild(document.getElementById("form"));
        }
        if (target == "#home")
            clearForm();
    });

    function editItem(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("vendorBannerGetInfo") }}',
            data: {
                id: id,
            },
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                document.getElementById("tabEdit").style.display = "block";
                $('.nav-tabs a[href="#edit"]').tab('show');
                //
                var target = document.getElementById("form");
                document.getElementById('edit').appendChild(target);
                //
                document.getElementById("name").value = data.data.name;
                editId = data.data.id;
                onSetCheck_visible(data.data.visible);
                //
                addEditImage(data.data.imageid, data.data.filename);
                //
                $('#isin').val(data.data.position).change();
                $('#banner_type').val(data.data.type).change();
                if (data.data.type == 1) // food
                    $('#foodForBanner').val(data.data.details).change();
                else
                    document.getElementById('url').value = data.data.details;
                $('.show-tick').selectpicker('refresh');
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    var editId = 0;

    function onSave(){
        if (!document.getElementById("name").value)
            return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
        if (imageid == 0)
            return showNotification("bg-red", "{{$lang->get(86)}}", "bottom", "center", "", "");  // The Image field is required.

        if ($('select[id=banner_type]').val() == 1) // food
            var details = $('select[id=foodForBanner]').val();
        else
            var details = document.getElementById("url").value;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("vendorBannersAdd") }}',
            data: {
                id: editId,
                name: document.getElementById("name").value,
                image: imageid,
                type: $('select[id=banner_type]').val(),
                visible: (visible) ? "1" : "0",
                position: $('select[id=isin]').val(),
                details: details,
            },
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.data == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                if (editId != 0)
                    paginationGoPage(currentPage);
                else{
                    var text = buildOneItem(data.data);
                    var text2 = document.getElementById("table_body").innerHTML;
                    document.getElementById("table_body").innerHTML = text+text2;
                }
                $('.nav-tabs a[href="#home"]').tab('show');
                showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
                clearForm();
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function clearForm(){
        onChangeType();
        document.getElementById("name").value = "";
        document.getElementById("url").value = "";
        onSetCheck_visible(true);
        $('#isin').val(1).change();
        $('#banner_type').val(1).change();
        $('#foodForBanner').val(1).change();
        editId = 0;
        clearDropZone();
    }

    function onChangeType(){
        if ($('select[id=banner_type]').val() == 1){ // food
            document.getElementById("element_foodForBanner").hidden = false;
            document.getElementById("element_url").hidden = true;

        }else{   // external link
            document.getElementById("element_foodForBanner").hidden = true;
            document.getElementById("element_url").hidden = false;
        }
    }

    $('.show-tick').selectpicker('refresh');

</script>

@endsection
