@inject('utils', 'App\Util')
@inject('lang', 'App\Lang')

<div class="col-md-12 q-mb5" >
    <div class="col-md-4 text-right" >
        <h4>{{$label}}
            @if ($request == "true")
                <span class="q-color-alert2">*</span>
            @endif
        </h4>
    </div>
    <div class="col-md-8">
        <select name="{{$id}}" id="{{$id}}" class="q-form show-tick" >
            <option value="-1" select style="font-size: 16px !important;">{{$lang->get(286)}}</option>     {{--Send to All users--}}
            @foreach($utils-> getUsers() as $key => $data)
                <option value="{{$data->id}}" style="font-size: 16px  !important;">{{$data->name}}</option>
            @endforeach
        </select>
    </div>
</div>

