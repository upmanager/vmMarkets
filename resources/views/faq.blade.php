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

        <!-- Tab List -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="home">
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="header">
                            <h3>
                                {{$lang->get(311)}}
                            </h3>
                        </div>
                        <div class="body">
                            @include('elements.faqTable', array())
                        </div>
                    </div>
                </div>
            </div>


        <div role="tabpanel" class="tab-pane fade" id="create">
            <div id="form" class="q-mt20 q-pb20">
                <div class="row clearfix">
                    <div class="col-md-6 ">

                        @include('elements.form.text', array('label' => $lang->get(312), 'text' => $lang->get(314), 'id' => "question", 'request' => "true", 'maxlength' => "50"))  {{--  --}}
                        @include('elements.form.text', array('label' => $lang->get(313), 'text' => $lang->get(315), 'id' => "answer", 'request' => "true", 'maxlength' => "300"))  {{--  --}}
                        <div class="col-md-4 " >
                        </div>
                        <div class="col-md-8 " style="margin-top: 20px">
                            @include('elements.form.check', array('id' => "published", 'text' => $lang->get(75), 'initvalue' => "true"))  {{--Published item--}}
                        </div>
                        @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSave();"))  {{-- Save --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Edit -->
        <div role="tabpanel" class="tab-pane fade" id="edit">
        </div>

    </div>
</div>

<script>

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
            url: '{{ url("faqGetInfo") }}',
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
                document.getElementById("question").value = data.data.question;
                document.getElementById("answer").value = data.data.answer;
                editId = data.data.id;
                onSetCheck_published(data.data.published);
            },
            error: function(e) {
                showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                console.log(e);
            }}
        );
    }

    var editId = 0;

    function onSave(){
        if (!document.getElementById("question").value)
            return showNotification("bg-red", "{{$lang->get(316)}}", "bottom", "center", "", "");  // The `Question` field is required.
        if (!document.getElementById("answer").value)
            return showNotification("bg-red", "{{$lang->get(317)}}", "bottom", "center", "", "");  // The `Answer` field is required.
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("faqAdd") }}',
            data: {
                id: editId,
                question: document.getElementById("question").value,
                answer: document.getElementById("answer").value,
                published: (published) ? "1" : "0",
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
        document.getElementById("question").value = "";
        document.getElementById("answer").value = "";
        published = true;
        editId = 0;
    }

</script>

@endsection
