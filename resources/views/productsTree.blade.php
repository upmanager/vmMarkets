@inject('lang', 'App\Lang')
@extends('bsb.app')
@inject('utils', 'App\Util')

{{--06.02.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(573)}}</h4></a></li> {{--TREE--}}
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header q-line q-mb20">
                            <h3>
                                {{$lang->get(574)}}  {{--PRODUCTS TREE--}}
                            </h3>
                        </div>
                        <div class="d-flex flex-column" id="tree-list">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">

    var allCat = new Array();

    @foreach($utils->getCategories() as $key => $idata)
        allCat.push({"id": "{{$idata->id}}", "name": "{!! $idata->name !!}", "image": "{{$idata->image}}", "parent": "{{$idata->parent}}"});
    @endforeach

    var allFoods = new Array();
    @foreach($utils->getFoods() as $key => $idata)
        allFoods.push({"id": "{{$idata->id}}", "name": "{{$idata->name}}", "image": "{{$idata->filename}}", "category": "{{$idata->category}}"});
    @endforeach

    initTree();

    function initTree(){
        document.getElementById("tree-list").innerHTML = getTreeCat(0, 0);
    }

    function getTreeCat(parent, level){
        var text = "";
        allCat.forEach(function(item, i, arr) {
            console.log(item);
            if (item.parent != parent)
                return;
            var p = 80*level;
            var padding = `<div class="d-flex " style="width: ${p}px; height: 50px; background-color: white"></div>`;
            text = text + `<div class="d-flex q-mb10 align-items-center q-color-bkg-label2">
                                  ${padding}
                                <img src="images/${item.image}" height="50px" style="margin-right: 20px">
                                <div class="d-flex q-font-15" style="margin-right: 20px">
                                    {{$lang->get(68)}}: ${item.id}          {{--id--}}
                                </div>
                                <div class="d-flex q-font-20">
                                    ${item.name}
                                </div>
                            </div>
                            ${getFoods(item.id, level+1)}
                            ${getTreeCat(item.id, level+1)}
                            `;
        });
        return text;
    }

    function getFoods(parent, level){
        var text = "";
        var p = 80*level;
        var padding = `<div class="d-flex" style="width: ${p}px"></div>`;
        allFoods.forEach(function(item, i, arr) {
            if (item.category != parent)
                return;
            text = text + `<div class="d-flex q-mb10 align-items-center">
                                ${padding}
                                <img src="images/${item.image}" height="50px" style="margin-right: 20px">
                                <div class="d-flex q-font-15" style="margin-right: 20px">
                                    {{$lang->get(68)}}: ${item.id}          {{--id--}}
                                </div>
                                <div class="d-flex q-font-20">
                                    ${item.name}
                                </div>
                            </div>
                            `;
        });
        if (text == "")
            return `
                <div class="d-flex q-mb10">
                    ${padding}
                    <div class="d-flex q-color-alert2">
                        {{$lang->get(575)}}    {{--Products not found--}}
                    </div>
                </div>
            `;
        return text;
    }

</script>

@endsection
