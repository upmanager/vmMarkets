@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')
<div class="col-md-12">
    <div class="col-md-4 q-radius q-card q-mr30" style="height: 80vh; min-height: 80vh; position:relative;">
        <div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px; padding: 0px">
            <div class="col-md-3 q-form-label">
                {{$lang->get(480)}} {{--Search--}}
            </div>
            <div class="col-md-9">
                <input type="text" name="users_search" id="users_search" class="q-form " placeholder="" maxlength="40"  autocomplete="off">
            </div>
        </div>
        <div class="col-md-12" style="padding: 0px!important">
            <div class="col-md-12" >
                <div id="chat-users" style="max-height:100%; min-height: 80vh; overflow:auto;" >
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7 q-card q-radius" style="padding: 0px; margin: 0px" >
        <div style="height: 80vh; min-height: 80vh; width: 100%; position:relative;">
            <div id="messagesWindow" style="max-height:70vh; min-height: 70vh; overflow:auto;" class="q-line">
            </div>
            <div id="sendMsg" class="d-flex" style="visibility: collapse">
                <input type="text" id="messageText" class="q-form q-radius" style="margin: 10px" placeholder="{{$lang->get(293)}}">
                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="sendMsg()" style="margin: 10px">
                    {{$lang->get(571)}} {{--Send--}}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var currentId = 0;

    function selectUser(id){
        console.log(id);
        // load messages

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("getChatMessages") }}',
            data: {
                user_id: id,
            },
            success: function (data){
                console.log("selectUser");
                console.log(data);
                buildChatUsers();
                document.getElementById("sendMsg").style.visibility = "visible";
                currentId = id;
                drawMsg(data);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    function myGet() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("getChatMessages") }}',
            data: {
                user_id: currentId,
            },
            success: function (data){
                console.log(data);
                if (currentLength != data.messages.length)
                    drawMsg(data);
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    setInterval(myGet, 10000); // one time in 10 sec

    function sendMsg(){
        var text = document.getElementById("messageText").value;
        if (text == "")
            return;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("chatNewMessage") }}',
            data: {
                user_id: currentId,
                text: text,
            },
            success: function (data){
                console.log(data);
                document.getElementById("messageText").value = "";
                drawMsg(data)
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    var currentLength = 0;

    function drawMsg(data, id){
        var last = "";
        var msg = document.getElementById("messagesWindow");
        msg.innerHTML = "";

        if (data.messages == null)
            return;
        currentLength = data.messages.length;
        data.messages.forEach(function(entry){
            var now = entry.created_at.substr(0, 11);
            if (now != last) {
                var div = document.createElement("div");
                div.innerHTML = `
                    <div class="container-left" style="width:20%; margin-left: 40%; margin-right: 40%; margin-top: 10px">
                        <div style="text-align: center;">
                            <div class="font-14">`+ now +`</div>
                        </div>
                    </div>
                    `;
                last = now;
                msg.appendChild(div);
            }
            var div = document.createElement("div");
            var date = entry.created_at.substr(11,5);
            if (entry.author == "customer"){
                div.innerHTML = `
                    <div class="container-left" style="width:60%; margin-left: 2%; margin-right: 38%; ">
                                `+ entry.text +`
                                <div align="right">` + date + `</div>
                        </div>
                    `;
            }else{
                div.innerHTML = `
                        <div class="container-right" style="margin-left: 38%; margin-right: 2%; width: 60% ">
                                `+ entry.text +`
                                <div align="right">` + date + `</div>
                        </div>
                    `;
            }
            msg.appendChild(div);
        });
        msg.scrollTop = msg.scrollHeight;
    }

    buildChatUsers();

    function buildChatUsers(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("chatNewUsers") }}', // chatUsers2
            data: {
            },
            success: function (data){
                console.log(data);
                if (data.error != "0")
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                $text = "";
                data.users.forEach(function(user, i, arr) {
                    if (!user.name.toUpperCase().includes(searchText.toUpperCase()))
                        return;
                    var messages = "";
                    if (user.messages != 0)
                        messages = `<div id="user${user.id}msgCountDotAll" class="dot" style="float: right; background-color: green;">
                                     <div style="display: table; margin: 0 auto; color: white; vertical-align: middle; text-align: center;" id="user${user.id}msgCountAll">${user.messages}</div>
                                </div>`;
                    var unread = "";
                    if (user.unread != 0)
                        unread = `<div id="user${user.id}msgCountDot" class="dot" style="float: right; background-color: red; margin-right: 0px; margin-left: 5px">
                                <div style="display: table; margin: 0 auto; color: white; vertical-align: middle; text-align: center;" id="user${user.id}msgCount">${user.unread}</div>
                            </div>`;
                    var bkg = "#FFFFFF";
                    if (user.id == currentId)
                        bkg = "#cbecff";
                    $text = $text + `<div id="user${user.id}" class="col-md-12 "  onclick="selectUser(${user.id})" style="padding: 0px; cursor: pointer; background-color: ${bkg}; padding-top: 10px; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; ">
                                            <div class="d-flex align-items-center justify-content-between align-items-center">
                                                <div class="d-flex align-items-start">
                                                    <div class="d-flex image-cropper">
                                                        <img src="images/${user.image}" width="20px" class='rounded'></img>
                                                    </div>
                                                    <div class="d-flex q-ml20 q-mt10">
                                                        ${user.name}
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-vertical-start q-mt10">
                                                    ${unread}
                                                    <div style="width: 3px"></div>
                                                    ${messages}
                                                </div>
                                            </div>
                                    </div>
            `;
                });
                document.getElementById("chat-users").innerHTML = $text;
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    var searchText = "";

    $(document).on('input', '#users_search', function(){
        searchText = document.getElementById("users_search").value;
        buildChatUsers();
    });

</script>

@endsection
