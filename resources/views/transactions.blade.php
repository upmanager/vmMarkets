@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

{{--12.02.2021--}}

@section('content')

<div class="q-card q-radius q-container">

    <!-- Tabs -->

    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>   {{--LIST--}}
    </ul>

    <!-- Tab List -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="home">
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="q-card q-radius q-container">
                        <div class="q-line q-mb20">
                            <h3>
                                {{$lang->get(601)}} {{--TRANSACTIONS--}}
                            </h3>
                        </div>
                        <div class="body">
                            @include('elements.transactionsTable', array())
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
