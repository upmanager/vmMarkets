

<div id="{{$id}}" onclick="onCheckClick{{$id}}()" style="font-weight: bold; "></div>

<script>
        var {{$id}} = {{$initvalue}};
        if ({{$id}})
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_on.png\" width=\"25px\">&nbsp{{$text}}";
        else
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_off.png\" width=\"25px\">&nbsp{{$text}}";

        function onCheckClick{{$id}}(){
            var value = "on";
            if ({{$id}}) value = "off"; else value = "on";
            {{$id}} = !{{$id}};
            document.getElementById('{{$id}}').innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp{{$text}}";
            {{$callback}};
        }

</script>
