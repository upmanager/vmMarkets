@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

<div id="element_{{$id}}" class="col-md-12 ">
    <div class="col-md-4 q-mt10">
        <div class="form-group form-group-lg">
            <select id="markets-select" class="q-form show-tick" onchange="markets_selectFoods();" >
                <option value="0" style="font-size: 16px  !important;">{{$lang->get(558)}}</option>  {{--All--}}
                @foreach($util->getRestaurants() as $key => $data)
                    <option value="{{$data->id}}" style="font-size: 16px  !important;">{{$data->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 q-mt10" >
        <select id="products-select" class="show-tick" style="width: 100%;">
            @foreach($util->getFoods() as $key => $data)
                <option value="{{$data->id}}" data-content="<span class=''><img src='images/{{$data->filename}}' width='40px' style='margin-right: 20px;'> {{$data->name}}</span>">
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="button" onclick="on_add_foods()" class="q-btn-all q-color-second-bkg waves-effectq-btn-all waves-effect"><h5>{{$label}}</h5></button>
    </div>
</div>

<script>

    function on_add_foods(){
        var market = $('select[id=markets-select]').val();
        var product = $('select[id=products-select]').val();
        {{$onclick}}(market, product);
    }

    markets_selectFoods();

    function markets_selectFoods(){
        var market = $('select[id=markets-select]').val();
        @foreach($util->getFoods() as $key => $data)
        $('#products-select option[value="{{$data->id}}"]').hide();
            if ({{$data->restaurant}} == market || market == 0)
                $('#products-select option[value="{{$data->id}}"]').show();
        @endforeach
        $("#products-select").selectpicker('refresh');
    }

</script>
