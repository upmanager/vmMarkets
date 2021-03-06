@inject('utils', 'App\Util')
@inject('lang', 'App\Lang')

<div class="col-md-4 align-self-right" style="margin-top: 20px; text-align: right; margin-bottom: 0px">
    {{$text}}
</div>
<div class="col-md-8" style="margin-bottom: 0px">
    <div class="form-group form-group-lg form-float" style="margin-bottom: 0px">
        <div class="form-line" >
            <select name="{{$id}}" id="{{$id}}" class="form-control show-tick" onchange="{{$onchange}};" >
                <option value="0" selected style="font-size: 16px !important;">{{$lang->get(114)}}</option> {{--No--}}
                @foreach($utils->getRestaurants() as $key => $data)
                    <option value="{{$data->id}}" style="font-size: 16px  !important;">{{$data->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


