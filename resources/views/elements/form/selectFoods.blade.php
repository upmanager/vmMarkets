@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

<div id="element_{{$id}}" class="col-md-12">
    <div class="col-md-4 text-right">
        <label for="name"><h4>{{$label}}
                @if ($request == "true")
                    <span class="q-color-alert2">*</span>
                @endif
            </h4></label>
    </div>
    <div class="col-md-8">
        <select name="{{$id}}" id="{{$id}}" class="q-form-s show-tick" onchange="{{$onchange}};" style="border: none!important;">
            @if ($noitem == "true")
                <option value="0">{{$lang->get(114)}}</option>  {{--No--}}
            @endif
            @foreach($util->getFoods() as $key => $data)
                <option value="{{$data->id}}" data-content="<span><img src='images/{{$data->filename}}' width='40px' style='margin-right: 20px;'> {{$data->name}}</span>">
                        </option>
            @endforeach
        </select>
    </div>
</div>


