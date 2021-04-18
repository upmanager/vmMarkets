@inject('utils', 'App\Util')
@inject('lang', 'App\Lang')

<div class="col-md-4 text-right q-form-label">
    {{$text}}
</div>
<div class="col-md-8" >
    <select name="{{$id}}" id="{{$id}}" class="focused show-tick q-radius" onchange="{{$onchange}};">
        <option value="0" selected >{{$lang->get(114)}}</option> {{--No--}}
        @foreach($utils->getOrdersStatus() as $key => $data)
            <option value="{{$data->id}}">{{$data->status}}</option>
        @endforeach
    </select>
</div>


