@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

<div class="q-card q-radius q-container">

    <div class="header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h3 class="">{{$lang->get(391)}}</h3> {{--Home Screen Layout Builder--}}
            </div>
        </div>
    </div>
    <div class="body">

        <div class="card">
            <div class="header">
            </div>

            <div class="table-responsive" style="margin-left: 5%; margin-bottom: 5%; margin-right: 5%;" >
                <table>
                    <tbody id="tbody">
                    <tr id="tr_top">
                        <td><img src="img/uitop.jpg" width="250px"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    var idStateSearch = false;
    var idNearTour = false;
    var idCat = false;
    var idDish = false;
    var idReview = false;
    var idTopf = false;
    var idTopr = false;
    var idbanner1 = false;
    var idbanner2 = false;
    var idcopyright = false;
    var idcategoryDetails = false;

    appendChildToTable("{{$row1}}", "{{$row1visible}}");
    appendChildToTable("{{$row2}}", "{{$row2visible}}");
    appendChildToTable("{{$row3}}", "{{$row3visible}}");
    appendChildToTable("{{$row4}}", "{{$row4visible}}");
    appendChildToTable("{{$row5}}", "{{$row5visible}}");
    appendChildToTable("{{$row6}}", "{{$row6visible}}");
    appendChildToTable("{{$row7}}", "{{$row7visible}}");
    appendChildToTable("{{$row8}}", "{{$row8visible}}");
    appendChildToTable("{{$row9}}", "{{$row9visible}}");
    appendChildToTable("{{$row10}}", "{{$row10visible}}");
    appendChildToTable("{{$row11}}", "{{$row11visible}}");
    appendChildToTable("tr_bottom", "true");

    function appendChildToTable(id, visible){
        if (id == "topr") {
            var tr = document.createElement('tr');
            tr.id = "tr_topr";
            tr.innerHTML = oneItem("{{$lang->get(392)}}", "topr", "uitopr.jpg"); // Top Markets this week
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("topr");
            else{
                idTopr = true;
                onCheckClick("topr");
            }
        }

        if (id == "topf") {
            var tr = document.createElement('tr');
            tr.id = "tr_topf";
            tr.innerHTML = oneItem("{{$lang->get(393)}}", "topf", "uitopf.jpg"); // Top Trends this week
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("topf");
            else{
                idTopf = true;
                onCheckClick("topf");
            }
        }

        if (id == "review") {
            var tr = document.createElement('tr');
            tr.id = "tr_review";
            tr.innerHTML = oneItem("{{$lang->get(394)}}", "review", "uireview.jpg"); // Reviews
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("review");
            else{
                idReview = true;
                onCheckClick("review");
            }
        }

        if (id == "pop") {
            var tr = document.createElement('tr');
            tr.id = "tr_pop";
            tr.innerHTML = oneItem("{{$lang->get(395)}}", "pop", "uidish.jpg"); // Most Popular
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("pop");
            else{
                idDish = true;
                onCheckClick("pop");
            }
        }
        if (id == "cat") {
            var tr = document.createElement('tr');
            tr.id = "tr_cat";
            tr.innerHTML = oneItem("{{$lang->get(396)}}", "cat", "uicat.jpg"); // Categories
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("cat");
            else{
                idCat = true;
                onCheckClick("cat");
            }
        }
        if (id == "nearyou") {
            var tr = document.createElement('tr');
            tr.id = "tr_nearyou";
            tr.innerHTML = oneItem("{{$lang->get(397)}}", "nearyou", "uires.jpg"); // Markets Near Your
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("nearyou");
            else{
                idNearTour = true;
                onCheckClick("nearyou");
            }
        }
        if (id == "search") {
            var tr = document.createElement('tr');
            tr.id = "tr_search";
            tr.innerHTML = oneItem("{{$lang->get(398)}}", "search", "uisearch.jpg"); // Search bar
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("search");
            else{
                idStateSearch = true;
                onCheckClick("search");
            }
        }

        if (id == "banner1") {
            var tr = document.createElement('tr');
            tr.id = "tr_banner1";
            tr.innerHTML = oneItem("{{$lang->get(523)}}", "banner1", "banner1.jpg"); // Banner 1
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("banner1");
            else{
                idbanner1 = true;
                onCheckClick("banner1");
            }
        }
        if (id == "banner2") {
            var tr = document.createElement('tr');
            tr.id = "tr_banner2";
            tr.innerHTML = oneItem("{{$lang->get(524)}}", "banner2", "banner2.jpg"); // Banner 2
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("banner2");
            else{
                idbanner2 = true;
                onCheckClick("banner2");
            }
        }
        if (id == "copyright") {
            var tr = document.createElement('tr');
            tr.id = "tr_copyright";
            tr.innerHTML = oneItem("{{$lang->get(528)}}", "copyright", "uiinfo.jpg"); // Information
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("copyright");
            else{
                idcopyright = true;
                onCheckClick("copyright");
            }
        }
        if (id == "categoryDetails") {
            var tr = document.createElement('tr');
            tr.id = "tr_categoryDetails";
            tr.innerHTML = oneItem("{{$lang->get(529)}}", "categoryDetails", "uikat.jpg"); // Category Details
            document.getElementById("tbody").appendChild(tr);
            if (visible == "true")
                onCheckClick("categoryDetails");
            else{
                idcategoryDetails = true;
                onCheckClick("categoryDetails");
            }
        }
        if (id == "tr_bottom") {
            var tr = document.createElement('tr');
            tr.id = "tr_bottom";
            tr.innerHTML = `
                <td><img src="img/uibottom.jpg" width="250px"></td>
                <td></td>
                <td>
                    <div class="q-btn-all q-color-second-bkg waves-effect" onClick="onSave()"><h4>{{$lang->get(142)}}</h4></div>  {{--Save--}}
                </td>
                 <td></td>
                <td>
                    @include('elements.form.info', array('title' => $lang->get(555), 'body1' => $lang->get(556), 'body2' => $lang->get(557)))  {{--Attention! - --}}
                </td>
            `;
            document.getElementById("tbody").appendChild(tr);
        }
    }

    function oneItem(text, id, image){
        return `<td><img src="img/${image}" width="250px"></td>
                <td width="5%"></td>
                <td>
                    <H5>${text}</H5>
                    <div id="${id}" onclick="onCheckClick('${id}')" style="font-weight: bold; "></div>
                </td>
                <td width="5%"></td>
                <td>
                    <div class="q-btn-all q-color-second-bkg waves-effect" onclick="onUp('tr_${id}')"><i class="material-icons" style="font-size: 25px; color: white">arrow_circle_up</i></div>
                    <div class="q-btn-all q-color-second-bkg waves-effect" onclick="onDown('tr_${id}')"><i class="material-icons" style="font-size: 25px; color: white">arrow_circle_down</i></div>
                </td>`;
    }


    function onCheckClick(id){
        var value = "on";
        if (id == 'topr') {
            if (idTopr == true) value = "off"; else value = "on";
            idTopr = !idTopr;
        }
        if (id == 'topf') {
            if (idTopf == true) value = "off"; else value = "on";
            idTopf = !idTopf;
        }
        if (id == 'search') {
            if (idStateSearch == true) value = "off"; else value = "on";
            idStateSearch = !idStateSearch;
        }
        if (id == 'nearyou') {
            if (idNearTour == true) value = "off"; else value = "on";
            idNearTour = !idNearTour;
        }
        if (id == 'cat') {
            if (idCat == true) value = "off"; else value = "on";
            idCat = !idCat;
        }
        if (id == 'pop') {
            if (idDish == true) value = "off"; else value = "on";
            idDish = !idDish;
        }
        if (id == 'review') {
            if (idReview == true) value = "off"; else value = "on";
            idReview = !idReview;
        }
        if (id == 'banner1') {
            if (idbanner1 == true) value = "off"; else value = "on";
            idbanner1 = !idbanner1;
        }
        if (id == 'copyright') {
            if (idcopyright == true) value = "off"; else value = "on";
            idcopyright = !idcopyright;
        }
        if (id == 'banner2') {
            if (idbanner2 == true) value = "off"; else value = "on";
            idbanner2 = !idbanner2;
        }
        if (id == 'categoryDetails') {
            if (idcategoryDetails == true) value = "off"; else value = "on";
            idcategoryDetails = !idcategoryDetails;
        }
        console.log("id = " + id);
        document.getElementById(id).innerHTML = "<img src=\"img/check_"+value+".png\" width=\"25px\">&nbsp {{$lang->get(399)}}";
    }

    function onDown(id){
        var current = document.getElementById(id);
        var next = current.nextElementSibling;
        if (next.id != "tr_bottom")
            next.after(current);
    }

    function onUp(id){
        var current = document.getElementById(id);
        var prev = current.previousElementSibling;
        if (prev.id != "tr_top")
            prev.before(current);
    }

    function getVisible(id){
        if (id == "tr_topr")
            return idTopr;
        if (id == "tr_topf")
            return idTopf;
        if (id == "tr_search")
            return idStateSearch;
        if (id == "tr_nearyou")
            return idNearTour;
        if (id == "tr_cat")
            return idCat;
        if (id == "tr_pop")
            return idDish;
        if (id == "tr_review")
            return idReview;
        if (id == "tr_banner1")
            return idbanner1;
        if (id == "tr_banner2")
            return idbanner2;
        if (id == "tr_copyright")
            return idcopyright;
        if (id == "tr_categoryDetails")
            return idcategoryDetails;
        return true;
    }

    function onSave(){
        var id = document.getElementById("tr_top");
        var id2 = id.nextElementSibling;
        var visible1 = getVisible(id2.id);
        var id3 = id2.nextElementSibling;
        var visible2 = getVisible(id3.id);
        var id4 = id3.nextElementSibling;
        var visible3 = getVisible(id4.id);
        var id5 = id4.nextElementSibling;
        var visible4 = getVisible(id5.id);
        var id6 = id5.nextElementSibling;
        var visible5 = getVisible(id6.id);
        var id7 = id6.nextElementSibling;
        var visible6 = getVisible(id7.id);
        var id8 = id7.nextElementSibling;
        var visible7 = getVisible(id8.id);
        var id9 = id8.nextElementSibling;
        var visible8 = getVisible(id9.id);
        var id10 = id9.nextElementSibling;
        var visible9 = getVisible(id10.id);
        var id11 = id10.nextElementSibling;
        var visible10 = getVisible(id11.id);
        var id12 = id11.nextElementSibling;
        var visible11 = getVisible(id12.id);

        var row1 = id2.id.substr(3);
        var row2 = id3.id.substr(3);
        var row3 = id4.id.substr(3);
        var row4 = id5.id.substr(3);
        var row5 = id6.id.substr(3);
        var row6 = id7.id.substr(3);
        var row7 = id8.id.substr(3);
        var row8 = id9.id.substr(3);
        var row9 = id10.id.substr(3);
        var row10 = id11.id.substr(3);
        var row11 = id12.id.substr(3);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("caLayout_change") }}',
            data: {
                row1: row1,
                row2: row2,
                row3: row3,
                row4: row4,
                row5: row5,
                row6: row6,
                row7: row7,
                row8: row8,
                row9: row9,
                row10: row10,
                row11: row11,
                visible1 : visible1,
                visible2 : visible2,
                visible3 : visible3,
                visible4 : visible4,
                visible5 : visible5,
                visible6 : visible6,
                visible7 : visible7,
                visible8 : visible8,
                visible9 : visible9,
                visible10 : visible10,
                visible11 : visible11,
            },
            success: function (data){
                console.log(data);
                showNotification("bg-teal", "{{$lang->get(400)}}", "bottom", "center", "", "");
            },
            error: function(e) {
                console.log(e);
            }}
        );

    }
</script>

@endsection
