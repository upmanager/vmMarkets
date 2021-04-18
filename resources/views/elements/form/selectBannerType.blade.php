@inject('lang', 'App\Lang')

<div class="col-md-12 ">
    <div class="col-md-4 text-right">
        <label for="name"><h4>{{$label}}
                @if ($request == "true")
                    <span class="q-color-alert2">*</span>
                @endif
            </h4></label>
    </div>
    <div class="col-md-8" style="margin-bottom: 0px">
        <select name="{{$id}}" id="{{$id}}" class="form-control show-tick" onchange="{{$onchange}};" >
            <option value="1" style="font-size: 16px  !important;" selected>{{$lang->get(513)}}</option>  {{--Open Product--}}
            <option value="2" style="font-size: 16px  !important;">{{$lang->get(514)}}</option>  {{--Open External URL--}}
        </select>
    </div>
</div>
