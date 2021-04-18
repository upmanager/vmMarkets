@inject('lang', 'App\Lang')

<div class="table-responsive">

    <div class="col-md-12" style="margin-bottom: 10px">
        <div class="col-md-4" style="margin-bottom: 0px">
        </div>
        <div class="col-md-4" style="margin-bottom: 0px">
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
            <th>{{$lang->get(312)}}</th>    {{--Question--}}
            <th>{{$lang->get(313)}}</th>    {{--Answer--}}
            <th>{{$lang->get(73)}}</th>     {{--Published--}}
            <th>{{$lang->get(49)}}</th>     {{--Updated At--}}
            <th>{{$lang->get(74)}}</th>     {{--Action--}}
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
            url: '{{ url("faqGoPage") }}',
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

        return `
            <tr>
                <td>${item.question}</td>
                <td>${item.answer}</td>
                <td>${visible}</td>
                <td><div class="q-font-bold q-color-second">${item.timeago}</div>${item.updated_at}</td>
                <td>

                <button type="button" class="q-btn-all q-color-second-bkg waves-effect" onclick="editItem('${item.id}')">
                    {{$lang->get(564)}} {{--Edit--}}
                </button>

                <button type="button" class="q-btn-all q-color-alert waves-effect" onclick="showDeleteMessage('${item.id}', '{{ url("faqdetete") }}')">
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

    function initTableHeader(){
        var html = `
            <th>{{$lang->get(312)}}</th> {{--Question--}}
            <th>{{$lang->get(313)}}</th> {{--Answer--}}
            <th>{{$lang->get(73)}}</th> {{--Published--}}
            <th>{{$lang->get(49)}}</th> {{--Updated At--}}
            <th>{{$lang->get(74)}} </th>  {{--Action--}}
        `;
        document.getElementById("table_header").innerHTML = html;
    }

    $(document).on('input', '#element_search', function(){
        searchText = document.getElementById("element_search").value;
        currentPage = 1;
        paginationGoPage(1);
    });

</script>
