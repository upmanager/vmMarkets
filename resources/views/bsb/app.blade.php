@inject('userinfo', 'App\UserInfo')
@inject('settings', 'App\Settings')
@inject('theme', 'App\Theme')
@inject('lang', 'App\Lang')

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | {{config('app.name')}}</title>

<meta name="_token" content="{{csrf_token()}}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

    <!-- Favicon-->
    <link rel="icon" href="img/logo.png" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
{{--    <link href="css/themes/all-themes.css" rel="stylesheet" />--}}

    <!-- Demo Js -->
{{--    <script src="js/demo.js"></script>--}}

    <!-- Custom Js -->
{{--    <script src="js/admin.js"></script>--}}


    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Custom Css -->
{{--    <link href="css/style.css" rel="stylesheet">--}}

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /><!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <link href="css/markets.css" rel="stylesheet">
    @include('bsb.style', array())
    <script src="js/markets.js"></script>
    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>
    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Notify Plugin Js -->
    <script src="plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Jquery CountTo Plugin Js -->
{{--    <script src="plugins/jquery-countto/jquery.countTo.js"></script>--}}

    {{--    <!-- Jquery DataTable Plugin Js -->--}}
{{--    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>--}}
{{--    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>--}}

{{--    <!-- JQuery DataTable Css -->--}}
{{--    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">--}}

{{--    <script src="js/companion.js"></script>--}}



</head>

<body class="theme-teal" dir="{{$lang->direction()}}" style="background-color: #e8e8f2;">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Top Bar -->
    <nav class="navbar q-titlebar" style="height: 50px!important;">
        <div class="container-fluid">
            <div class="d-flex navbar-header">
                <div id="sidebar-open-button" onclick="onOpenSideBar();" class="sidebar-open" style="margin-right: 30px" hidden></div>
                <a class="q-titlebar-brand" href="home">{{config('app.name')}}</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right" style="margin-top: 8px">
                    <li class="dropdown">
                        <a href="{{route('orders')}}" role="button" style="color: white; background-color: #{{$theme->getMainColor()}}">
                            <i class="material-icons">folder_open</i>
                            <span id="countNewOrders" class="label-count">0</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{route('chat')}}"  role="button" style="color: white; background-color: #{{$theme->getMainColor()}}">
                            <i class="material-icons">chat_bubble_outline</i>
                            <span id="countChatNewMessages" class="label-count">0</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" role="button" style="color: white; background-color: #{{$theme->getMainColor()}}">
                                {{ $userinfo->getUserRole() }}
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{route('logout')}}" role="button" style="color: white; background-color: #{{$theme->getMainColor()}}">
                            <i class="material-icons">input</i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar q-color-main-bkg">
            <!-- User Info -->
            <div class="user-info">
                <div class="image d-inlin">
                    <img src="{{$userinfo->getUserAvatar()}}" width="48" height="48" alt="User" />
                </div>
                <div class="image d-inlin" style="float: right;">
                    <div onclick="onCloseSideBar();" class="sidebar-close"></div>
                </div>
                <div class="info-container" style="margin-right: 10px;">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
                    <div class="email">{{ Auth::user()->email }}</div>
                    <div class="btn-group user-helper-dropdown">
                        <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="submenu-open"></div>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="users?user_id={{ Auth::user()->id }}"><i class="material-icons" style="padding-right: 20px">person</i>
                                    <span style="vertical-align: super;">{{$lang->get(562)}}</span></a></li>  {{--Profile--}}
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="material-icons" style="padding-right: 20px">input</i>
                                    <span style="vertical-align: super;">{{$lang->get(563)}}</span></a></li>  {{--Sign Out--}}
                        </ul>
                    </div>
                </div>
            </div>

            @if ($userinfo->getUserRoleId() == 1)
                @include('menuOwner', array())
            @endif
            @if ($userinfo->getUserRoleId() == 2)
                @include('menuVendor', array())
            @endif

            <!-- Footer -->
            <div class="legal">
                <div class="q-copyright">
                    &copy; {{ $settings->getCopyright() }}
                </div>
                <div class="q-copyright">
                    <b>{{$lang->get(36)}}: </b> {{ $settings->getVersion() }}
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section id="content-section" class="content">
        <div class="container-fluid">

            <!-- upload images -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="q-card q-radius">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>
    </section>

<script>


    function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
        if (colorName === null || colorName === '') { colorName = 'pastel-danger'; }
        if (colorName == "bg-teal")
            colorName = "pastel-info";
        if (colorName == "bg-red")
            colorName = "pastel-danger";
        if (text === null || text === '') { text = 'alert'; }
        if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
        if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
        var allowDismiss = true;

        $.notify({
                message: text
            },
            {
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 5000,
                placement: {
                    from: placementFrom,
                    align: placementAlign
                },
                animate: {
                    enter: animateEnter,
                    exit: animateExit
                },
            });
    }

    function inputHandler(e, parent, min, max) {
        var value = parseInt(e.target.value);
        if (value.isEmpty)
            value = 0;
        if (isNaN(value))
            value = 0;
        if (value > max)
            value = max;
        if (value < min)
            value = min;
        parent.value = value;
    }

    var lastOrders = 0;


    function getChatNewMessages() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("getChatMessagesNewCount") }}',
            data: {
            },
            success: function (data){
                console.log(data);
                if (document.getElementById("countChatNewMessages") != null)
                    document.getElementById("countChatNewMessages").innerHTML = data.count;
                document.getElementById("countNewOrders").innerHTML = data.orders;
                if (data.orders != lastOrders){
                    lastOrders = data.orders;
                    const audio = new Audio("img/sound.mp3");
                    audio.play();
                    $orders = document.getElementById("orders-table");
                    if ($orders != null){       // open orders page
                        paginationGoPage(1);
                        getChatNewMessages();
                    }
                }
                if (document.getElementById("messagesWindow") != null)
                    buildChatUsers();
            },
            error: function(e) {
                console.log(e);
            }}
        );
    }

    setInterval(getChatNewMessages, 10000); // one time in 10 sec
    getChatNewMessages();

    function moveToPageWithSelectedItem(id) {
        var itemsTable = $('#data_table').DataTable();
        var indexes = itemsTable
            .rows()
            .indexes()
            .filter( function ( value, index ) {
                return id === itemsTable.row(value).data()[0];
            } );
        var numberOfRows = itemsTable.data().length;
        var rowsOnOnePage = itemsTable.page.len();
        if (rowsOnOnePage < numberOfRows) {
            var selectedNode = itemsTable.row(indexes).node();
            var nodePosition = itemsTable.rows({order: 'current'}).nodes().indexOf(selectedNode);
            var pageNumber = Math.floor(nodePosition / rowsOnOnePage);
            itemsTable.page(pageNumber).draw(false); //move to page with the element
            return pageNumber;
        }
        return 0;
    }

    function showDeleteMessage(id, url) {
        swal({
            title: "{{$lang->get(81)}}",
            text: "{{$lang->get(82)}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{$lang->get(83)}}",
            cancelButtonText: "{{$lang->get(84)}}",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                console.log(id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: url,
                    data: {id: id},
                    success: function (data){
                        console.log(data);
                        if (data.error != "0") {
                            if (data.error == '2')
                                return showNotification("bg-red", data.text, "bottom", "center", "", "");
                            return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                        }
                        //
                        // remove from ui
                        //
                        paginationGoPage(currentPage);
                    },
                    error: function(e) {
                        console.log(e);
                    }}
                );
            } else {

            }
        });
    }

    function onCloseSideBar(){
        document.getElementById("leftsidebar").style.display = "none";
        document.getElementById("content-section").style.margin = '100px 15px 0 15px';
        document.getElementById("sidebar-open-button").hidden = false;
    }
    function onOpenSideBar(){
        document.getElementById("leftsidebar").style.display = "inline-block";
        document.getElementById("content-section").style.margin = '100px 15px 0 315px';
        document.getElementById("sidebar-open-button").hidden = true;
    }

</script>

</body>
</html>

