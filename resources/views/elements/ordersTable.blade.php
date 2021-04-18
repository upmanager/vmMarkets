@inject('lang', 'App\Lang')
@inject('userinfo', 'App\UserInfo')

    <div class="col-md-12 q-line q-pb20">
        <div class="col-md-6">
            @include('elements.search.selectStatus', array('text' => $lang->get(481), 'id' => "rest_search", 'onchange' => "onStatusSearchSelect(this)"))  {{--Filter--}}
        </div>
        <div class="col-md-6">
            @include('elements.search.textMax40', array('text' => $lang->get(480), 'id' => "users_search"))  {{--Search--}}
        </div>
    </div>

    <table id="data_table" class="table table-striped table-hover">
        <thead class="q-color-bkg-label1">
        <tr id="table_header">
            {{--header items--}}
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>{{$lang->get(43)}}</th> {{--Order ID--}}
            <th>{{$lang->get(44)}}</th> {{--Total--}}
            @if ($userinfo->getUserRoleId() == '1')
                <th>{{$lang->get(47)}}</th> {{--Market--}}
            @endif
            <th>{{$lang->get(45)}}</th> {{--Client--}}
            <th>{{$lang->get(46)}}</th> {{--Order Status--}}
            <th>{{$lang->get(48)}}</th> {{--Details--}}
            <th>{{$lang->get(49)}}</th> {{--Updated At--}}
            <th>{{$lang->get(74)}}</th> {{--Action--}}
        </tr>
        </tfoot>
        <tbody id="table_body">
            {{--users--}}
        </tbody>
    </table>

    <div align="center">
        <nav>
            <div id="paginationList" >
                {{-- pagination list--}}
            </div>
        </nav>
    </div>

<script>

    var pages = 1;
    var currentPage = 1;
    var sortRest = 0;
    var sortCat = 0;
    var searchText = "";
    var sort = "updated_at";
    var sortBy = "desc";

    paginationGoPage(1);
    initPaginationLine(pages, currentPage);
    initTableHeader();

    function paginationGoPage(page){
        var data = {
            page: page,
            sortAscDesc: sortBy,
            sortBy : sort,
            rest: sortRest,
            cat: sortCat,
            search: searchText,
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("ordersGoPage") }}',
            data: data,
            success: function (data){
                console.log(data);
                currentPage = data.page;
                pages = data.pages;
                if (data.error != "0" || data.idata == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                initUsersDataTable(data.idata);
                initPaginationLine(pages, data.page);
                initTableHeader();
            },
            error: function(e) {
                dataLoading = false;
                console.log(e);
            }}
        );
    }

    function initUsersDataTable(data){
        html = "";
        data.forEach(function (item, i, arr) {
            html += buildOneItem(item);
        });
        document.getElementById("table_body").innerHTML = html;
        $('.show-tick').selectpicker('refresh');
    }

    function buildOneItem(item){

        var text = ``;
        if (item.curbsidePickup == "true") {
            text = `<span class="q-label q-color-label2 q-color-bkg-label2 q-radius">{{$lang->get(213)}}</span>`;
            if (item.arrived == "true")
                text += `<span class="q-label q-color-label2 q-color-bkg-label2 q-radius">{{$lang->get(214)}}</span>`;
            text += "<br>";
        }
        text += `<span class="q-label q-color-label1 q-color-bkg-label1 q-radius">${item.method}</span>`;
        //
        var text2 = "";
        @foreach($iorderstatus as $key => $idata)
            if ({{$idata->id}} == item.status)
                text2 = '{{$idata->status}}';
        @endforeach
        //
        var text3 = "";
        if (item.curbsidePickup == "true"){
            @foreach($iorderstatus as $key => $idata)
                if ({{$idata->id}} != 4){
                    if ({{$idata->id}} == item.status)
                        text3 += `<option id="role${item.id}_{{$idata->id}}" value="{{$idata->id}}" selected style="font-size: 16px  !important;">{{$idata->status}}</option>`;
                    else
                        text3 += `<option id="role${item.id}_{{$idata->id}}" value="{{$idata->id}}" style="font-size: 16px  !important;">{{$idata->status}}</option>`;
                }
            @endforeach
        } else {
            @foreach($iorderstatus as $key => $idata)
                if ({{$idata->id}} == item.status)
                    text3 += `<option id="role${item.id}_{{$idata->id}}" value="{{$idata->id}}" selected style="font-size: 16px  !important;">{{$idata->status}}</option>`;
                else
                    text3 += `<option id="role${item.id}_{{$idata->id}}" value="{{$idata->id}}" style="font-size: 16px  !important;">{{$idata->status}}</option>`;
            @endforeach
        }

        return `
            <tr>
                <td>${item.id}</td>
                <td>${item.totalFull}</td>
                @if ($userinfo->getUserRoleId() == '1')
                    <td>${item.restaurantName}</td>      {{--market name--}}
                @endif
                <td>${item.name}</td>      {{--client--}}
                <td>
                @if ($userinfo->getUserRoleId() == '1')
                    ${text2}
                @else
                    <select name="role" id="role" class="form-control show-tick" onchange="checkStatus(event, ${item.id})" >
                        ${text3}
                    </select>
                @endif
                </td>
                <td>${text}</td>
                <td><div class="q-font-bold q-color-second">${item.timeago}</div>${item.updated_at}</td>
                <td>
                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="viewItem('${item.id}')">
                    <div>{{$lang->get(561)}}</div> {{--View--}}
                </button>
                <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage('${item.id}', '{{ url("orderdelete") }}')">
                    {{$lang->get(308)}}   {{--Delete--}}
                </button>
        </td>
    </tr>
    `;
    }

    function initPaginationLine(pages, page){
        var html = "<ul class=\"pagination\">";
        for (var i = 1; i <= pages; i++) {
            if (i == page)
                html += `<li class="active"><a href="javascript:void(0);" class="q-radius">${i}</a></li>`;
            else
                html += `<li><a href="javascript:void(0);" onClick="paginationGoPage(${i})" class="waves-effect">${i}</a></li>`;
        };
        html += "</ul>";
        document.getElementById("paginationList").innerHTML = html;
    }

    function tableHeaderSort(newsort){
        if (newsort == sort) {
            if (sortBy == "asc")
                sortBy = "desc";
            else
                sortBy = "asc";
        }
        else{
            sort = newsort
            sortBy = "asc";
        }
        paginationGoPage(currentPage);
    }

    function utilGetImg(value){
        var img = "img/arrow_noactive.png";
        if (sort == value && sortBy == "asc") img = "img/asc_arrow.png";
        if (sort == value && sortBy == "desc") img = "img/desc_arrow.png";
        return img;
    }

    function initTableHeader(){
        var html = `
            <th>{{$lang->get(43)}} <img onclick="tableHeaderSort('orders.id');" src="${utilGetImg('orders.id')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Id--}}
            <th>{{$lang->get(44)}} <img onclick="tableHeaderSort('orders.total');" src="${utilGetImg('orders.total')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Total--}}
        @if ($userinfo->getUserRoleId() == '1')
        <th>{{$lang->get(47)}} </th> {{--Market--}}
        @endif
            <th>{{$lang->get(45)}} <img onclick="tableHeaderSort('users.name');" src="${utilGetImg('users.name')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Client--}}
            <th>{{$lang->get(46)}} </th> {{--Order Status--}}
            <th>{{$lang->get(48)}} </th> {{--Details--}}
            <th>{{$lang->get(49)}} <img onclick="tableHeaderSort('orders.updated_at');" src="${utilGetImg('orders.updated_at')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Updated At--}}
            <th>{{$lang->get(74)}} </th>                                                                                                {{--Action--}}
        `;
        document.getElementById("table_header").innerHTML = html;
    }

    function onRestSearchSelect(object){
        sortRest = object.value;
        currentPage = 1;
        paginationGoPage(currentPage);
    }

    function onStatusSearchSelect(object){
        sortCat = object.value;
        currentPage = 1;
        paginationGoPage(currentPage);
    }

    $(document).on('input', '#users_search', function(){
        searchText = document.getElementById("users_search").value;
        console.log(searchText);
        currentPage = 1;
        paginationGoPage(1);
    });

</script>
