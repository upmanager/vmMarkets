@inject('theme', 'App\Theme')

<style>
    body{
        font-family: 'Poppins', sans-serif !important;
    }

    .btn-default:hover {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }

    .q-titlebar{
        background-color: #{{$theme->getMainColor()}};
        position: fixed;
        top: 0;
        left: 0;
        z-index: 12;
        width: 100%;
        border-radius: 0px;
    }

    .q-titlebar-brand {
        float: left;
        height: 50px;
        padding: 15px 15px;
        font-size: 18px;
        line-height: 20px;
        color: #fff;
    }
    .q-titlebar-brand:hover {
        float: left;
        height: 50px;
        padding: 15px 15px;
        font-size: 18px;
        line-height: 20px;
        color: #fff;
        text-decoration: none !important;
    }

    .q-btn-all{
        border: none;
        color: white;
        padding: .65rem 1rem;
        border-radius: {{$theme->getRadius()}}px;
        font-weight: 600;
        font-size: 13px;
        margin: 5px;
    }

    .q-color-main-bkg{
        background-color: #{{$theme->getMainColor()}} !important;
    }
    .q-color-bkg-label1{
        background-color: #{{$theme->getLabelColor()}} !important;
    }
    .q-color-second-bkg{
        background-color: #{{$theme->getSecondColor()}} !important;
    }
    .q-color-cyan-bkg{
        background-color: #17a2b8 !important;
    }
    .q-color-success-bkg{
        background-color: #1BC5BD !important;
    }
    .q-color-purple-bkg{
        background-color: #6f42c1 !important;
    }
    .q-color-bkg-label2{
        background-color: #{{$theme->getLabelColor2()}} !important;
    }

    .q-color-second{
        color: #{{$theme->getSecondColor()}};
    }

    .q-color-alert{
        background-color: #{{$theme->getAlertColor()}};
    }

    .q-color-alert2{
        color: #{{$theme->getAlertColor()}};
    }


    .q-radius{
        border-radius: {{$theme->getRadius()}}px;
    }

    .q-color-label1{
        color: #{{$theme->getLabelBkgColor()}};
    }

    .q-color-label2{
        color: #{{$theme->getLabelBkgColor2()}};
    }

    .q-label{
        display: inline-block;
        padding: .4rem .8rem;
        font-size: 13px;
        font-weight: 400;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        margin: 3px;
    }

    .q-form-label{
        padding-top: calc(.65rem + 1px);
        padding-bottom: calc(.65rem + 1px);
        margin-bottom: 0;
        font-size: inherit;
        line-height: 1.5;
    }

    .q-form{
        display: block;
        width: 100%;
        height: calc(1.5em + 1.3rem + 2px);
        padding: .65rem 1rem;
        line-height: 1.5;
        font-size: 13px;
        font-weight: 400;
        color: #3f4254;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e4e6ef;
        /*border-radius: .42rem;*/
        border-radius: {{$theme->getRadius()}}px;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    .q-form-s{
        display: block;
        width: 100%;
        height: calc(1.5em + 1.3rem + 2px);
        line-height: 1.5;
        font-size: 13px;
        font-weight: 400;
        color: #3f4254;
        background-color: #fff;
        /*border-radius: .42rem;*/
        border-radius: {{$theme->getRadius()}}px;
        background-clip: padding-box;
        border: 1px solid #e4e6ef;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .q-form:focus {
        outline: none;
        border: 1px solid #{{$theme->getSecondColor()}};
    }
    .q-form:hover {
        border: 1px solid #{{$theme->getSecondColor()}};
        background-color: white;
    }

    .q-form-select{
        display: block;
        width: 100%;
        height: calc(1.5em + 1.3rem + 4px);
        line-height: 1.5;
        border: 1px solid #e4e6ef;
        /*border-radius: .42rem;*/
        border-radius: {{$theme->getRadius()}}px;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .q-form-select:focus {
        outline: none;
        border: 1px solid #{{$theme->getSecondColor()}};
    }
    .q-form-select:hover {
        border: 1px solid #{{$theme->getSecondColor()}};
        background-color: white;
    }

    .q-form-noselect{
        border: none!important;
    }

    .btn:not(.btn-link):not(.btn-circle) {
        /*box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);*/
        /*border-radius: .42rem;*/
        border-radius: {{$theme->getRadius()}}px !important;
        border: 1px solid #e4e6ef;
        color: #3f4254;
        font-size: {{$theme->getFontSize()}};
        outline: none; }
    .btn:not(.btn-link):not(.btn-circle):hover {
        border: 1px solid #{{$theme->getSecondColor()}};
    }

    .btn-group > .btn, .btn-group-vertical > .btn {
        position: unset;
        box-shadow: none !important;
    }

    .left-no-radius{
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: {{$theme->getRadius()}}px !important;
        border-top-right-radius: {{$theme->getRadius()}}px !important;
    }


    .q-card{
        background: #fff;
        box-shadow: 0 0 30px 0 rgba(82,63,105,.05);
        border-radius: {{$theme->getRadius()}}px !important;
    }

    .q-container{
        padding: 2.25rem;
        margin-bottom: 50px;
    }

    .q-container2{
        padding: 2.25rem;
    }

    .q-line{
        border-bottom: 1px solid #ddd;
    }

    .q-li-active.active a{
        color: #222 !important;
    }

    .dropdown-toggle {
        font-size: {{$theme->getFontSize()}} !important;
    }

    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #{{$theme->getSecondColor()}};
        border-color: #{{$theme->getSecondColor()}};
    }

    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
         border-top-left-radius: {{$theme->getRadius()}}px;
         border-bottom-left-radius: {{$theme->getRadius()}}px;
    }

    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: {{$theme->getRadius()}}px;
        border-bottom-right-radius: {{$theme->getRadius()}}px;
    }

    .table > thead > tr > th,
    .table > tbody > tr > th,
    .table > tfoot > tr > th,
    .table > thead > tr > td,
    .table > tbody > tr > td,
    .table > tfoot > tr > td {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: middle;
        border-top: 1px solid #ddd;
        text-align: center;
    }

    section.content {
        margin: 100px 15px 0 315px;
        -moz-transition: 0.5s;
        -o-transition: 0.5s;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }

    /* menu */
    .sidebar-close{
        font-size: 19px;
        color: #8da3b7;
        align-self: center!important;
        margin-bottom: 8px;
    }

    .sidebar-close:hover::after{
        transform: rotate(90deg) scale(1.2);
    }
    .sidebar-close:after{
        /*content: '\1F894';*/

        display: flex;
        content: '';
        background: url(img/arrow.png) ;
        background-size: 14px auto;
        width: 14px;
        height: 14px;

        -webkit-transform: rotate(90deg) scale(1);
        -moz-transform: rotate(90deg) scale(1);
        -ms-transform: rotate(90deg) scale(1);
        -o-transform: rotate(90deg) scale(1);
        transform: rotate(90deg) scale(1);

    }
    .sidebar-close:hover {
        font-size: 19px;
        color: white;
        cursor: pointer;
    }
    .sidebar-open{
        font-size: 19px;
        color: #8da3b7;
        align-self: center!important;
        margin-bottom: 8px;
    }
    .sidebar-open:hover::after{
        transform: rotate(270deg) scale(1.2);
    }
    .sidebar-open:after{
        /*content: '\1F896';*/
        content: '';
        background: url(img/arrow.png) ;
        background-size: 14px auto;
        display: flex;
        width: 14px;
        height: 14px;
        -webkit-transform: rotate(270deg) scale(1);
        -moz-transform: rotate(270deg) scale(1);
        -ms-transform: rotate(270deg) scale(1);
        -o-transform: rotate(270deg) scale(1);
        transform: rotate(270deg) scale(1);
    }
    .sidebar-open:hover {
        font-size: 19px;
        color: white;
        cursor: pointer;
    }
    .submenu-open{
        font-size: 19px;
        color: #8da3b7;
        align-self: center!important;
        margin-bottom: 8px;
    }
    .submenu-open:after{
        /*content: '\1F897';*/
        content: '';
        display: flex;
        background: url(img/arrow.png) ;
        background-size: 14px auto;
        width: 14px;
        height: 14px;

        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -o-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    .submenu-open:hover {
        font-size: 19px;
        color: white;
        cursor: pointer;
        transform: scale(1.1);
    }

    .sidebar {
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
        font-family: "Roboto", sans-serif;
        width: 300px;
        overflow: hidden;
        display: inline-block;
        height: calc(100vh - 50px);
        position: fixed;
        top: 50px;
        left: 0;
        -webkit-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        -ms-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 11 !important; }
    .sidebar .legal {
        position: absolute;
        bottom: 0;
        width: 100%;
        border-top: 1px solid #eee;
        padding: 15px;
        overflow: hidden; }
    .sidebar .user-info {
        padding: 13px 15px 12px 15px;
        white-space: nowrap;
        position: relative;
        border-bottom: 1px solid #e9e9e9;
        background: url("img/user-img-background.jpg") no-repeat no-repeat;
        height: 135px; }
    .sidebar .user-info .image {
        margin-right: 12px;
        display: inline-block; }
    .sidebar .user-info .image img {
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;
        vertical-align: bottom !important; }
    .sidebar .user-info .info-container {
        cursor: default;
        display: block;
        position: relative;
        top: 25px; }
    .sidebar .user-info .info-container .name {
        white-space: nowrap;
        -ms-text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 14px;
        max-width: 200px;
        color: #fff; }
    .sidebar .user-info .info-container .email {
        white-space: nowrap;
        -ms-text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 12px;
        max-width: 200px;
        color: #fff; }
    .sidebar .user-info .info-container .user-helper-dropdown {
        position: absolute;
        right: -3px;
        bottom: -12px;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        box-shadow: none;
        cursor: pointer;
        color: #fff; }
    .sidebar .menu {
        position: relative;
        overflow-y: auto;
        height: 90vh; }
    .sidebar .menu .list {
        list-style: none;
        padding-left: 0; }
    .sidebar .menu .list li.active > :first-child span {
        font-weight: bold; }
    .sidebar .menu .list i.material-icons {
        margin-top: 4px; }
    .sidebar .menu .list .menu-toggle:after, .sidebar .menu .list .menu-toggle:before {
        position: absolute;
        top: calc(50% - 14px);
        right: 17px;
        font-size: 19px;
        -moz-transform: scale(0);
        -ms-transform: scale(0);
        -o-transform: scale(0);
        -webkit-transform: scale(0);
        transform: scale(0);
        -moz-transition: all 0.3s;
        -o-transition: all 0.3s;
        -webkit-transition: all 0.3s;
        transition: all 0.3s; }

    .sidebar .menu .list .menu-toggle:hover::before {
        transform: scale(1.2);
    }
    .sidebar .menu .list .menu-toggle:before {
        /*content: '\1f897';*/
        content: '';
        background: url(img/arrow.png);
        background-size: 12px auto;
        width: 12px;
        height: 12px;

        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -o-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    .sidebar .menu .list .menu-toggle:hover::after {
        transform: scale(1.2);
    }
    .sidebar .menu .list .menu-toggle:after {
        /*content: '\1f895';*/
        content: '';
        background: url(img/arrow.png) ;
        background-size: 14px auto;
        width: 14px;
        height: 14px;

        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);

        -moz-transform: scale(0);
        -ms-transform: scale(0);
        -o-transform: scale(0);
        -webkit-transform: scale(0);
        transform: scale(0); }
    .sidebar .menu .list .menu-toggle.toggled:before {
        -moz-transform: scale(0);
        -ms-transform: scale(0);
        -o-transform: scale(0);
        -webkit-transform: scale(0);
        transform: scale(0); }
    .sidebar .menu .list .menu-toggle.toggled:after {
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -o-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1) rotate(180deg); }
    .sidebar .menu .list a small {
        position: absolute;
        top: calc(50% - 7.5px);
        right: 15px; }
    .sidebar .menu .list .ml-menu {
        list-style: none;
        display: none;
        padding-left: 0; }
    .sidebar .menu .list .ml-menu span {
        font-weight: normal;
        font-size: 14px;
        margin: 3px 0 1px 6px; }
    .sidebar .menu .list .ml-menu li a {
        padding-left: 55px;
        padding-top: 7px;
        padding-bottom: 7px; }
    .sidebar .menu .list .ml-menu li.active a.toggled:not(.menu-toggle) {
        font-weight: 600;
        margin-left: 5px; }
    .sidebar .menu .list .ml-menu li .ml-menu li a {
        padding-left: 80px; }
    .sidebar .menu .list .ml-menu li .ml-menu .ml-menu li a {
        padding-left: 95px; }

    .menu-text {
        position: relative;
        display: inline-flex;
        vertical-align: middle;
        width: 100%;
        padding: 10px 13px; }
    .menu-text:hover menu-text:active menu-text:focus {
        text-decoration: none !important;}

    .menu-icon {
        margin: 7px 0 7px 12px;
        font-weight: bold;
        font-size: 14px;
        overflow: hidden; }

    div.menu li.q-menu-item a{
        color: #{{$theme->getMenuTextColorInactive()}}
    }
    div.menu li.q-menu-active a{
        text-decoration:none;
        background-color: #0E2231;
    }
    div.menu li.q-menu-item a:hover {
        text-decoration:none;
        color: #{{$theme->getMenuTextColorHover()}};
        background-color: #0E2231;
    }
    div.menu li.q-menu-active a{
        text-decoration:none;
        color: #{{$theme->getMenuTextColorHover()}}
    }
    /* sub menu */
    div.menu .ml-menu li.q-menu-item  a{
        color: #{{$theme->getMenuTextColorInactive()}};
        background-color: #{{$theme->getMainColor()}};
        font-weight: bold;
        font-size: 14px;
    }
    div.menu .ml-menu li.q-menu-item a:hover{
        color: #{{$theme->getMenuTextColorHover()}};
        background-color: #0E2231;
        font-weight: bold;
        font-size: 14px;
    }
    div.menu .ml-menu li.q-menu-active  a{
        text-decoration:none;
        color: #{{$theme->getMenuTextColorHover()}};
        background-color: #0E2231;
        font-weight: bold;
        font-size: 14px;
    }
    .q-menu-header {
        background: #{{$theme->getMainColor()}};
        color: #494b74;
        font-size: 15px;
        font-weight: 600;
        padding: 8px 16px; }

    .q-copyright {
        font-size: 13px;
        white-space: nowrap;
        color: #{{$theme->getMenuTextColorInactive()}};
        -ms-text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        font-weight: bold;
        text-decoration: none;
        overflow: hidden; }

    .btn-default:active,
    .btn-default.active,
    .open > .dropdown-toggle.btn-default {
        color: #333;
        background-color: white;
        border-color: #adadad;
    }

    .bootstrap-select {
        width: 100%!important;
        border-radius: {{$theme->getRadius()}}px !important;
    }
    .bootstrap-select .dropdown-toggle:focus {
        outline-offset: -2px;
        outline: none !important;
        border-radius: {{$theme->getRadius()}}px !important;
    }


    .nav > li > a {
        position: relative;
        display: block;
        padding-left: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    /* home screen */



    .dropzone {
        border-radius: {{$theme->getRadius()}}px !important;
    }

    .swal-wide{
        position: fixed !important;
        width:70% !important;
        border-radius: 20px !important;
        left: 30% !important;
    }

    .info{
        border-left: 2px solid red;
        padding-left: 10px;
    }

    @media (max-width: 768px) {
        #leftsidebar {
            display: none;
        }
        #content-section{
            margin: 100px 15px 0 15px
        }
    }

    .rounded {
        display: block;
        margin: 0 auto;
        height: 60px;
        width: 60px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
        background-size:cover;
    }

    /* chat */
    .container-left {
        border-radius: 6px;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        margin: 10px 0;
        font-size: 15px;
        color: #7e8299!important;
        background-color: #c9f7f5!important;
        font-weight: 500!important;
        text-align: left!important;
    }
    .container-right {
        border-radius: 6px;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        margin: 10px 0;
        font-size: 15px;
        color: #7e8299!important;
        background-color: #e1f0ff!important;
        font-weight: 500!important;
        text-align: right!important;
    }

    .dot {
        height: 20px;
        width: 20px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }

    .q-info-box .icon {
        display: inline-block;
        text-align: center;
        border-radius: {{$theme->getRadius()}}px;
        background-color: rgba(0, 0, 0, 0.12);
        width: 80px; }
    .q-info-box .icon i {
        color: #fff;
        font-size: 50px;
        line-height: 80px; }
    .q-info-box .icon .chart.chart-bar {
        height: 100%;
        line-height: 100px; }
    .q-info-box .icon .chart.chart-bar canvas {
        vertical-align: baseline !important; }
    .q-info-box .icon .chart.chart-pie {
        height: 100%;
        line-height: 123px; }
    .q-info-box .icon .chart.chart-pie canvas {
        vertical-align: baseline !important; }
    .q-info-box .icon .chart.chart-line {
        height: 100%;
        line-height: 115px; }
    .q-info-box .icon .chart.chart-line canvas {
        vertical-align: baseline !important; }
    .q-info-box .content {
        display: inline-block;
        padding: 7px 10px; }
    .q-info-box .content .text {
        font-size: 13px;
        margin-top: 11px;
        color: #555; }
    .q-info-box .content .number {
        font-weight: normal;
        font-size: 26px;
        margin-top: -4px;
        color: #555; }

    .q-info-box.hover-zoom-effect .icon {
        overflow: hidden; }
    .q-info-box.hover-zoom-effect .icon i {
        -moz-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease; }

    .q-info-box.hover-zoom-effect:hover .icon i {
        opacity: 0.4;
        -moz-transform: rotate(-32deg) scale(1.4);
        -ms-transform: rotate(-32deg) scale(1.4);
        -o-transform: rotate(-32deg) scale(1.4);
        -webkit-transform: rotate(-32deg) scale(1.4);
        transform: rotate(-32deg) scale(1.4); }

    .q-info-box.hover-expand-effect:after {
        background-color: rgba(0, 0, 0, 0.05);
        content: ".";
        position: absolute;
        left: 80px;
        top: 0;
        width: 0;
        height: 100%;
        color: transparent;
        -moz-transition: all 0.95s;
        -o-transition: all 0.95s;
        -webkit-transition: all 0.95s;
        transition: all 0.95s; }

    .q-info-box.hover-expand-effect:hover:after {
        width: 100%; }

    .q-info-box.hover-zoom-effect .icon {
        overflow: hidden;
    }

    .q-info-box .icon {
        display: inline-block;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.12);
        width: 80px;
    }

</style>
