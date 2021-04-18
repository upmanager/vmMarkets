
<div id="element_{{$id}}">
    <div class="col-md-12">
        <div class="col-md-4 text-right" >
            <label for="{{$id}}"><h4>{{$label}}
                @if ($request == "true")
                    <span class="q-color-alert2">*</span>
                @endif
            </h4></label>
        </div>
        <div class="col-md-8" style="margin-bottom: 0px">
            <input type="number" name="{{$id}}" id="{{$id}}" class="q-form" value="0" step="0.01">
            <p class="font-12 mdl-color-text--indigo-A700">{{$text}}</p>
        </div>
    </div>
</div>


<script>

    var amount{{$id}} = document.getElementById('{{$id}}');
    amount{{$id}}.addEventListener('input',  function(e){inputHandlerDouble(e, amount{{$id}}, 0, 1000000000);});

    function inputHandlerDouble(e, parent, min, max) {
        var t = e.target.value.indexOf('.');
        var value = parseFloat(e.target.value);
        if (value.isEmpty)
            value = 0;
        if (isNaN(value))
            value = 0;
        if (value > max)
            value = max;
        if (value < min)
            value = min;
        if (t != -1) {
            var m = value.toFixed(2);
            if (m.substring(m.length - 1) == '0')
                parent.value = value.toFixed(1);
            else
                parent.value = value.toFixed(2);
        }else
            parent.value = value;
    }

</script>
