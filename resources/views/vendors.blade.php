@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')
<div class="q-card q-radius q-container">

    <!-- Tabs -->

    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
        <li role="presentation"><a href="#create" data-toggle="tab" ><h4>{{$lang->get(65)}}</h4></a></li>
        <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li>
    </ul>

    <div class="tab-content">

        <!-- Tab List -->
        <div role="tabpanel" class="tab-pane fade in active" id="home">
            <div class="row clearfix js-sweetalert q-container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="q-line q-mb20">
                            <h3>
                                {{$lang->get(553)}}  {{--VENDORS LIST--}}
                            </h3>
                        </div>
                        <div class="">
                            @include('elements.vendorsTable', array())
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <h3>{{$lang->get(616)}}</h3> {{--Sellers registration request--}}

                <table id="data_table" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>{{$lang->get(69)}}</th> {{--Name--}}
                        <th>{{$lang->get(191)}}</th> {{--Email--}}
                        <th>{{$lang->get(223)}}</th> {{--Date/Time--}}
                        <th>{{$lang->get(74)}}</th> {{--Action--}}
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>{{$lang->get(69)}}</th> {{--Name--}}
                        <th>{{$lang->get(191)}}</th> {{--Email--}}
                        <th>{{$lang->get(223)}}</th> {{--Date/Time--}}
                        <th>{{$lang->get(74)}}</th> {{--Action--}}
                    </tr>
                    </tfoot>
                    <tbody >
                        @foreach($sellersregs as $key => $data)
                            <tr id="tr{{$data->id}}">
                                <td>{{$data->name}}</td>
                                <td>{{$data->email}}</td>
                                <td><div class="q-font-bold q-color-second">{{$data->timeago}}</div>{{$data->updated_at}}</td>
                                <td>
                                    <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="acceptSeller('{{$data->id}}', '{{$data->name}}', '{{$data->email}}', '{{$data->password}}')">
                                        <div>{{$lang->get(617)}}</div> {{--Accept--}}
                                    </button>
                                    <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage3('{{$data->id}}')">
                                        <div>{{$lang->get(308)}}</div> {{--Delete--}}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>

        <!-- End Tab List -->

        <!-- Tab Create -->

        <div role="tabpanel" class="tab-pane fade" id="create">

            <div id="form" class="q-mt20 q-pb20">

                <div class="row clearfix ">
                    <div class="col-md-6">
                        @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "name", 'request' => "true", 'maxlength' => "40"))  {{-- Name - Insert Name --}}
                        @include('elements.form.text', array('label' => $lang->get(191), 'text' => $lang->get(193), 'id' => "email", 'request' => "true", 'maxlength' => "40"))  {{-- Email - Insert Email --}}
                        @include('elements.form.text', array('label' => $lang->get(194), 'text' => $lang->get(195), 'id' => "password", 'request' => "true", 'maxlength' => "40"))  {{-- Password - Insert Password --}}
                    </div>
                    <div class="col-md-6">
                        @include('elements.form.percent', array('label' => $lang->get(580), 'text' => $lang->get(581), 'id' => "commission", 'request' => "false",))   {{--Admin Commission-- Insert commission for this vendor in percentages--}}

                    </div>
                </div>

                @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSaveUser();"))  {{-- Save --}}

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
            if (sellerId == 0)
                clearForm();
            document.getElementById('create').appendChild(document.getElementById("form"));
            $('#role').val(4).change();
            $('.show-tick').selectpicker('refresh');
        }
        if (target == "#home") {
            clearForm();
        }
    });

    var editId = 0;

    function editItem(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("vendorGetInfo") }}',
            data: {
                id: id,
            },
            success: function (data){
                console.log(data);
                if (data.error != "0" || data.user == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                document.getElementById("tabEdit").style.display = "block";
                $('.nav-tabs a[href="#edit"]').tab('show');
                //
                var target = document.getElementById("form");
                document.getElementById('edit').appendChild(target);
                //
                document.getElementById("name").value = data.user.name;
                editId = data.user.id;
                document.getElementById("email").value = data.user.email;
                document.getElementById("commission").value = data.user.commission;
                // document.getElementById("tax").value = data.user.tax;
                //
                document.getElementById("element_password").hidden = false;
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function onSaveUser(){
        var data = {
            id: editId,
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            password: document.getElementById("password").value,
            commission: document.getElementById("commission").value,
            // tax: document.getElementById("tax").value,
        };
        console.log(data);
        if (!document.getElementById("name").value)
            return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
        if (!document.getElementById("email").value)
            return showNotification("bg-red", "{{$lang->get(200)}}", "bottom", "center", "", "");  // The `Email` field is required.
        if (!document.getElementById("password").value)
            if (editId == 0)
                return showNotification("bg-red", "{{$lang->get(482)}}", "bottom", "center", "", "");  // The `Password` field is required.

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("vendoradd") }}',
            data: data,
            success: function (data){
                console.log(data);
                if (data.error == "2")
                    return showNotification("bg-red", "{{$lang->get(484)}}", "bottom", "center", "", "");  // User with this email already exist
                if (data.error != "0" || data.user == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                if (editId != 0)
                    paginationGoPage(currentPage);
                else{
                    var text = buildOneItem(data.user);
                    var text2 = document.getElementById("table_body").innerHTML;
                    document.getElementById("table_body").innerHTML = text+text2;
                }
                $('.nav-tabs a[href="#home"]').tab('show');
                if (editId == 0)
                    showNotification("bg-teal", "{{$lang->get(483)}}", "bottom", "center", "", ""); // New user created
                else
                    showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
                console.log("onSaveUser", sellerId);
                if (sellerId != 0){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("sellerRegDelete") }}',
                        data: {id: sellerId},
                        success: function (data){
                            console.log(data);
                            if (data.error != "0") {
                                if (data.error == '2')
                                    return showNotification("bg-red", data.text, "bottom", "center", "", "");
                                return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                            }
                            document.getElementById('tr'+id).remove();
                            console.log("sellerRegDelete delete", 'tr'+sellerId);
                        },
                        error: function(e) {
                            console.log("sellerRegDelete", e);
                        }}
                    );
                }
                clearForm();

            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    function clearForm(){
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
        editId = 0;
        sellerId = 0;
        console.log("clearForm");
    }

    function showDeleteMessage3(id) {
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
                    url: '{{ url("sellerRegDelete") }}',
                    data: {id: id},
                    success: function (data){
                        console.log(data);
                        if (data.error != "0") {
                            if (data.error == '2')
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        showNotification("bg-teal", "<?php echo e($lang->get(577)); ?>", "bottom", "center", "", ""); // Deleted
                        document.getElementById('tr'+id).remove();
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    var sellerId = 0;

    function acceptSeller(id, name, email, password){
        $('.nav-tabs a[href="#create"]').tab('show');
        var target = document.getElementById("form");
        document.getElementById('create').appendChild(target);
        //
        console.log("acceptSeller", name);
        document.getElementById("name").value = name;
        sellerId = id;
        document.getElementById("email").value = email;
        document.getElementById("password").value = password;
    }


</script>

@endsection
