@inject('lang', 'App\Lang')

<div class="table-responsive">

    <div class="col-md-12" style="margin-bottom: 10px">
        <div class="col-md-4" style="margin-bottom: 0px">
        </div>
        <div class="col-md-5" style="margin-bottom: 0px">
            <div class="col-md-3 ">
                {{$lang->get(481)}} {{--Filter--}}
            </div>
            <div class="col-md-9 ">
                @include('elements.search.check', array('id' => "visible_search", 'text' => $lang->get(75), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Published item--}}
                @include('elements.search.check', array('id' => "unvisible_search", 'text' => $lang->get(490), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Unpublished item--}}
            </div>
        </div>
        <div class="col-md-3" style="margin-bottom: 0px">
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
            <th>{{$lang->get(48)}}</th> {{--Details--}}
            <th>{{$lang->get(511)}}</th> {{--Is in--}}
            <th>{{$lang->get(73)}}</th> {{--Published--}}
            <th>{{$lang->get(72)}}</th> {{--Updated At--}}
            <th>{{$lang->get(74)}}</th> {{--Action--}}
        </tr>
        </tfoot>
        <tbody id="table_body">
            {{--categories--}}
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
            url: '{{ url("bannersGoPage") }}',
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
        if (item.visible)
            var visible = `<img src="img/iconyes.png" height="20px">`;
        else
            var visible = `<img src="img/iconno.png" height="20px">`;

        if (item.position == "1")
            var position = "{{$lang->get(523)}}";  // Banner 1
        if (item.position == "2")
            var position = "{{$lang->get(524)}}";  // Banner 2

        return `
            <tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>
                     <img src="images/${item.filename}" height="100px" >
                </td>
                <td>${item.detailsText}</td>
                <td>${position}</td>
                <td>${visible}</td>
                <td><div class="q-font-bold q-color-second">${item.timeago}</div>${item.updated_at}</td>
                <td>

                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="editItem('${item.id}')">
                    <div>{{$lang->get(564)}}</div> {{--Edit--}}
                </button>

                <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage('${item.id}', '{{ url("bannersDelete") }}')">
                    <div>{{$lang->get(308)}}</div> {{--Delete--}}
                </button>
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
            <th>{{$lang->get(68)}} <img onclick="tableHeaderSort('id');" src="${utilGetImg('id')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Id--}}
            <th>{{$lang->get(69)}} <img onclick="tableHeaderSort('name');" src="${utilGetImg('name')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Name--}}
            <th>{{$lang->get(70)}} </th>                                                                                                   {{--Image--}}
            <th>{{$lang->get(48)}} </th>                                                                                                    {{--Details--}}
            <th>{{$lang->get(511)}} <img onclick="tableHeaderSort('position');" src="${utilGetImg('position')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Is in--}}
            <th>{{$lang->get(73)}} <img onclick="tableHeaderSort('visible');" src="${utilGetImg('visible')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Published--}}
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
