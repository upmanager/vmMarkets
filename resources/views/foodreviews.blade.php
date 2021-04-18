@inject('userinfo', 'App\UserInfo')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

{{--06.02.2021--}}

<div class="q-card q-radius q-container">

<!-- Tabs -->

    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
    </ul>

    <!-- Tab List -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header q-line q-mb20">
                            <h3>
                                {{$lang->get(134)}}     {{--PRODUCTS REVIEWS LIST--}}
                            </h3>
                        </div>
                        <div class="body">
                            @include('elements.productReviewsTable', array())
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
