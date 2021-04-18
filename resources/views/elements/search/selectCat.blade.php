@inject('utils', 'App\Util')
@inject('lang', 'App\Lang')

<div class="col-md-4 align-self-right q-form-label " style="margin-left: 10px">
    {{$text}}
</div>
<div class="col-md-8" style="margin-bottom: 0px">
    <select name="{{$id}}" id="{{$id}}" class="q-form-s show-tick" onchange="{{$onchange}};" >
        <option value="0" selected style="font-size: 16px !important;">{{$lang->get(114)}}</option> {{--No--}}
        @foreach($utils->getCategories() as $key => $data)
            <option value="{{$data->id}}" style="font-size: 16px  !important;">{{$data->name}}</option>
        @endforeach
    </select>
</div>


