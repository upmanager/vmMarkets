
<div id="{{$id}}" onclick="onCheckClick{{$id}}()" style="font-weight: bold; "></div>

<script>
        var {{$id}} = {{$initvalue}};
        if ({{$id}})
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_on.png\" >";
        else
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_off.png\" >";

        function onCheckClick{{$id}}(){
            var value = "on";
            if ({{$id}}) value = "off"; else value = "on";
            {{$id}} = !{{$id}};
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_"+value+".png\" >";
            {{$callback}}('{{$id}}', {{$id}});
        }

        function onSetCheck_{{$id}}(value){
            if (value == '1')
                {{$id}} = false;
            else
                {{$id}} = true;
            onCheckClick{{$id}}();
        }

</script>
