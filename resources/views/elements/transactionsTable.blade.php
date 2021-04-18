@inject('lang', 'App\Lang')
@inject('currency', 'App\Currency')

<div class="table-responsive">

    <div class="col-md-12" style="margin-bottom: 10px">
        <div class="col-md-4" style="margin-bottom: 0px">
        </div>
        <div class="col-md-5" style="margin-bottom: 0px">
            <div class="col-md-3 ">
                {{$lang->get(481)}} {{--Filter--}}
            </div>
            <div class="col-md-9 ">
            </div>
        </div>
        <div class="col-md-3" style="margin-bottom: 0px">
        </div>
    </div>

    <table id="data_table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr id="table_header">
            {{--header items--}}
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>{{$lang->get(597)}}</th> {{--Order Id--}}
            <th>{{$lang->get(223)}}</th> {{--Date/Time--}}
            @if (Auth::user()->role == '1') {{--admin--}}
                <th>{{$lang->get(47)}}</th> {{--Market--}}
            @endif
            <th>{{$lang->get(598)}}</th> {{--Order Total--}}
            @if (Auth::user()->role == '1') {{--admin--}}
                <th>{{$lang->get(603)}}</th> {{--Admin revenue--}}
                <th>{{$lang->get(602)}}</th> {{--Pay to Vendor--}}
            @else
                <th>{{$lang->get(599)}}</th> {{--Pay to Admin--}}
                <th>{{$lang->get(600)}}</th> {{--Take from Admin--}}
            @endif
        </tr>
        </tfoot>
        <tbody id="table_body">

        </tbody>
    </table>

    <div align="center">
        <nav>
            <div id="paginationList" >
                {{-- pagination list--}}
            </div>
        </nav>
    </div>

</div>
</div>

<script>

    var pages = 1;
    var currentPage = 1;
    var sortCat = 0;
    var sortPublished = '1';
    var sortUnPublished = '1';
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
            cat: sortCat,
            search: searchText,
            sortPublished: sortPublished,
            sortUnPublished: sortUnPublished,
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("transactionsGoPage") }}',
            data: data,
            success: function (data){
                console.log("transactionsGoPage");
                console.log(data);
                currentPage = data.page;
                pages = data.pages;
                if (data.error != "0" || data.idata == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                initDataTable(data.idata, data.commission);
                initPaginationLine(pages, data.page);
                initTableHeader();
            },
            error: function(e) {
                dataLoading = false;
                console.log(e);
            }}
        );
    }

    function initDataTable(data, commission){
        html = "";
        data.forEach(function (item, i, arr) {
            html += buildOneItem(item, commission);
        });
        document.getElementById("table_body").innerHTML = html;
    }

    function makePrice(price){
        @if ($currency->rightSymbol() == "false")
            return '{{$currency->currency()}}' + parseFloat(price).toFixed({{$currency->symbolDigits()}});
        @else
            return parseFloat(price).toFixed({{$currency->symbolDigits()}}) + '{{$currency->currency()}}';
        @endif
    }

    function buildOneItem(item, commission){
        var _total = parseFloat(item.total);
        @if (Auth::user()->role == '1') // admin
            var to_admin = _total * (item.commission/100);
        @else
            var to_admin = _total * (commission/100);
        @endif
        var pay_to_admin = makePrice(to_admin);
        var to_vendor = makePrice(_total - to_admin);
        return `
            <tr>
                <td><a href="orders?edit=${item.id}">${item.id}</a></td>
                <td><div class="q-font-bold q-color-second">${item.timeago}</div>${item.updated_at}</td>
                @if (Auth::user()->role == '1') {{--admin--}}
                    <th>${item.shopName}</th> {{--Market--}}
                @endif
                <td>${makePrice(item.total)}</td>
                @if (Auth::user()->role == '1') {{--admin--}}
                    <td>${pay_to_admin} (${item.commission}%)</td>
                @else
                    <td>${pay_to_admin} (${commission}%)</td>
                @endif

                <td>${to_vendor}</td>
                </td></tr>`;
    }

    function initPaginationLine(pages, page){
        var html = "<ul class=\"pagination\">";
        for (var i = 1; i <= pages; i++) {
            if (i == page)
                html += `<li class="active"><a href="javascript:void(0);">${i}</a></li>`;
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
            <th>{{$lang->get(597)}} <img onclick="tableHeaderSort('id');" src="${utilGetImg('id')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Order Id--}}
            <th>{{$lang->get(223)}} <img onclick="tableHeaderSort('updated_at');" src="${utilGetImg('updated_at')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Date/Time--}}
        @if (Auth::user()->role == '1') {{--admin--}}
            <th>{{$lang->get(47)}}</th> {{--Market--}}
        @endif
            <th>{{$lang->get(598)}} <img onclick="tableHeaderSort('total');" src="${utilGetImg('total')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Order total--}}
        @if (Auth::user()->role == '1') {{--admin--}}
            <th>{{$lang->get(603)}}</th> {{--Admin revenue--}}
            <th>{{$lang->get(602)}}</th> {{--Pay to Vendor--}}
        @else
            <th>{{$lang->get(599)}} </th>     {{--Pay to admin--}}
            <th>{{$lang->get(600)}} </th>     {{--Take from Admin--}}
        @endif
        `;
        document.getElementById("table_header").innerHTML = html;
    }

    function onCatSearchSelect(object){
        sortCat = object.value;
        currentPage = 1;
        paginationGoPage(currentPage);
    }

    $(document).on('input', '#element_search', function(){
        searchText = document.getElementById("element_search").value;
        currentPage = 1;
        paginationGoPage(1);
    });

    function onVisibleSearchSelect(){
        if (visible_search) sortPublished = "1"; else sortPublished = "0";
        if (unvisible_search) sortUnPublished = "1"; else sortUnPublished = "0";
        currentPage = 1;
        paginationGoPage(1);
    }

</script>
