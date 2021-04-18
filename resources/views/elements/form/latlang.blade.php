<div class="col-md-12 " style="margin-bottom: 0px">
    <div class="col-md-3 foodm">
        <label for="lat"><h4>{{$label}}
                @if ($request == "true")
                    <span class="col-red">*</span>
                @endif
            </h4></label>
    </div>
    <div class="col-md-9 foodm">
        <input type="number" name="{{$id}}" id="{{$id}}" class="q-form" placeholder="" step="0.00000000000000001" value="{{$initvalue}}">
        <label class="form-label">{{$text}}</label>
    </div>
</div>
