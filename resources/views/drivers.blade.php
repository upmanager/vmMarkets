@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')

{{--31.01.2021--}}

@section('content')
<div class="body">

<!-- Tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">

            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="q-line q-mb20">
                            <h3>
                                {{$lang->get(252)}}
                            </h3>
                        </div>
                        <div class="body">

                            <div class="table-responsive">

                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <div class="col-md-4" style="margin-bottom: 0px">
                                    </div>
                                    <div class="col-md-1 ">
                                        {{$lang->get(481)}} {{--Filter--}}
                                    </div>
                                    <div class="col-md-3 ">
                                        @include('elements.search.check', array('id' => "online_search", 'text' => $lang->get(253), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Online--}}
                                        @include('elements.search.check', array('id' => "offline_search", 'text' => $lang->get(492), 'initvalue' => "true", 'callback' => "onVisibleSearchSelect()"))  {{--Offline--}}
                                    </div>
                                    <div class="col-md-4" style="margin-bottom: 0px">
                                        @include('elements.search.textMax40', array('text' => $lang->get(480), 'id' => "users_search"))  {{--Search--}}
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
                                        <th>{{$lang->get(137)}}</th> {{--User--}}
                                        <th>{{$lang->get(253)}}</th> {{--Online--}}
                                        <th>{{$lang->get(39)}}</th> {{--Total Orders--}}
                                        <th>{{$lang->get(62)}}</th> {{--Earnings--}}
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>

<script type="text/javascript">

    var pages = 1;
    var currentPage = 1;
    var sortRole = 0;
    var searchText = "";
    var sort = "total";
    var sortBy = "desc";
    var sortOnline = "1";
    var sortOffline = "1";

    paginationGoPage(1);
    initPaginationLine(pages, currentPage);
    initTableHeader();

    function paginationGoPage(page){
        var data = {
            page: page,
            sortAscDesc: sortBy,
            sortBy : sort,
            role: sortRole,
            search: searchText,
            sortOnline: sortOnline,
            sortOffline: sortOffline
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("driversGoPage") }}',
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
    }

    function buildOneItem(item){
        if (item.active)
            var active = `<img src="img/iconyes.png" height="20px">`;
        else
            var active = `<img src="img/iconno.png" height="20px">`;
        return `
        <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${active}</td>
            <td>${item.count}</td>
            <td>${item.total}</td>

            <td>
                <button type="button" class="q-btn-all q-color-second-bkg waves-effect">
                    <a href="{{url('users')}}?user_id=${item.id}">
                        <div style="color: white">{{$lang->get(564)}}</div> {{--Edit--}}
                    </a>
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

    function initTableHeader(){
        var html = `
        <th>{{$lang->get(68)}} <img onclick="tableHeaderSort('id');" src="${utilGetImg('id')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Id--}}
        <th>{{$lang->get(69)}} <img onclick="tableHeaderSort('name');" src="${utilGetImg('name')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Name--}}
        <th>{{$lang->get(253)}} <img onclick="tableHeaderSort('active');" src="${utilGetImg('active')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Online--}}
        <th>{{$lang->get(39)}} <img onclick="tableHeaderSort('count');" src="${utilGetImg('count')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Total Orders--}}
        <th>{{$lang->get(62)}} <img onclick="tableHeaderSort('total');" src="${utilGetImg('total')}" class="img-fluid" style="margin-left: 10px; width: 20px; float: right;"></th> {{--Earnings--}}
        <th>{{$lang->get(74)}} </th>                                                                                                {{--Action--}}
        `;
        document.getElementById("table_header").innerHTML = html;
    }

    function utilGetImg(value){
        var img = "img/arrow_noactive.png";
        if (sort == value && sortBy == "asc") img = "img/asc_arrow.png";
        if (sort == value && sortBy == "desc") img = "img/desc_arrow.png";
        return img;
    }

    $(document).on('input', '#users_search', function(){
        searchText = document.getElementById("users_search").value;
        console.log(searchText);
        currentPage = 1;
        paginationGoPage(1);
    });

    function onVisibleSearchSelect(){
        if (online_search) sortOnline = "1"; else sortOnline = "0";
        if (offline_search) sortOffline = "1"; else sortOffline = "0";
        currentPage = 1;
        paginationGoPage(1);
    }

</script>

@endsection
