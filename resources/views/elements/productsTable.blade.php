@inject('lang', 'App\Lang')
@inject('userinfo', 'App\UserInfo')

<!-- Add icon library -->

<div class="table-responsive">

    <div class="col-md-12" style="margin-bottom: 10px">
        <div class="col-md-4" style="margin-bottom: 0px">
            <div class="col-md-3 ">
                {{$lang->get(481)}} {{--Filter--}}
            </div>
            <div class="col-md-9 ">
                @include('elements.search.check', array('id' => "visible_search", 'text' => $lang->get(75), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Published item--}}
                @include('elements.search.check', array('id' => "unvisible_search", 'text' => $lang->get(490), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Unpublished item--}}
            </div>
        </div>
        <div class="col-md-4" style="margin-bottom: 0px">
            @include('elements.search.selectCat', array('text' => $lang->get(90), 'id' => "cat_search", 'onchange' => "onCatSearchSelect(this)"))  {{--Category--}}
        </div>
        <div class="col-md-4" style="margin-bottom: 0px">
            @include('elements.search.textMax40', array('text' => $lang->get(480), 'id' => "element_search"))  {{--Search--}}
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
            <th>{{$lang->get(68)}}</th> {{--Id--}}
            <th>{{$lang->get(69)}}</th> {{--Name--}}
            <th>{{$lang->get(70)}}</th> {{--Image--}}
            <th>{{$lang->get(88)}}</th> {{--Price--}}
            <th>{{$lang->get(96)}}</th> {{--Discount Price--}}
            @if ($userinfo->getUserRoleId() == '1')
                <th>{{$lang->get(89)}}</th> {{--Market--}}
            @endif
            <th>{{$lang->get(90)}}</th> {{--Category--}}
            <th>{{$lang->get(73)}}</th> {{--Published--}}
            <th>{{$lang->get(72)}}</th> {{--Updated At--}}
            <th>{{$lang->get(74)}}</th> {{--Action--}}
        </tr>
        </tfoot>
        <tbody id="table_body">
            {{--foods--}}
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
    var sortRest = 0;
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
            rest: sortRest,
            search: searchText,
            sortPublished: sortPublished,
            sortUnPublished: sortUnPublished,
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("foodsGoPage") }}',
            data: data,
            success: function (data){
                console.log(data);
                currentPage = data.page;
                pages = data.pages;
                if (data.error != "0" || data.idata == null)
                    return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                initDataTable(data.idata);
                initPaginationLine(pages, data.page);
                initTableHeader();
            },
            error: function(e) {
                dataLoading = false;
                console.log(e);
            }}
        );
    }

    function initDataTable(data){
        html = "";
        data.forEach(function (item, i, arr) {
            html += buildOneItem(item);
        });
        document.getElementById("table_body").innerHTML = html;
    }



    function buildOneItem(item){
        if (item.published)
            var visible = `<img src="img/iconyes.png" height="20px">`;
        else
            var visible = `<img src="img/iconno.png" height="20px">`;

        var rating = createRatings(item.drating);
        return `
            <tr>
                <td>${item.id}</td>
                <td>${item.name} <br> ${rating}
                    ${item.rating}
                </td>
                <td>
                     <img src="images/${item.filename}" height="100px" >
                </td>
                <td>${item.priceFull}</td>
                <td>${item.discountPriceFull}</td>
            @if ($userinfo->getUserRoleId() == '1')
                <td>${item.restaurantName}</td>
            @endif
                <td>${item.categoryName}</td>
                <td>${visible}</td>
                <td><div class="q-font-bold q-color-second">${item.timeago}</div>${item.updated_at}</td>
                <td>

                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="editItem('${item.id}')">
                    {{$lang->get(564)}} {{--Edit--}}
                </button>

                <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage('${item.id}', '{{ url("fooddelete") }}')">
                    <div>{{$lang->get(308)}}</div> {{--Delete--}}
                </button>

        </td>
    </tr>
    `;
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
            <th>{{$lang->get(68)}} <img onclick="tableHeaderSort('id');" src="${utilGetImg('id')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Id--}}
            <th>{{$lang->get(69)}} <img onclick="tableHeaderSort('name');" src="${utilGetImg('name')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Name--}}
            <th>{{$lang->get(70)}} </th>                                                                                                   {{--Image--}}
            <th>{{$lang->get(88)}} <img <img onclick="tableHeaderSort('price');" src="${utilGetImg('price')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Price--}}
            <th>{{$lang->get(96)}} <img <img onclick="tableHeaderSort('discountprice');" src="${utilGetImg('discountprice')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Discount Price--}}
        @if ($userinfo->getUserRoleId() == '1')
            <th>{{$lang->get(89)}} <img <img onclick="tableHeaderSort('restaurant');" src="${utilGetImg('restaurant')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Market--}}
        @endif
            <th>{{$lang->get(90)}} <img <img onclick="tableHeaderSort('category');" src="${utilGetImg('category')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--<Category>--}}
            <th>{{$lang->get(73)}} <img onclick="tableHeaderSort('published');" src="${utilGetImg('published')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Published--}}
            <th>{{$lang->get(72)}} <img onclick="tableHeaderSort('updated_at');" src="${utilGetImg('updated_at')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Updated At--}}
            <th>{{$lang->get(74)}} </th>                                                                                                {{--Action--}}
        `;
        document.getElementById("table_header").innerHTML = html;
    }

    function onCatSearchSelect(object){
        sortCat = object.value;
        currentPage = 1;
        paginationGoPage(currentPage);
    }

    function onRestSearchSelect(object){
        sortRest = object.value;
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
