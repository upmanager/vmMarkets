@inject('userinfo', 'App\UserInfo')
@inject('currency', 'App\Currency')
@inject('lang', 'App\Lang')
@extends('bsb.app')

{{--31.01.2021--}}

@section('content')
    <!-- Input Mask Plugin Js -->
    <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<div class="q-card q-radius q-container">

        <!-- Tabs -->

        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(89)}}</h4></a></li> {{--Market--}}
            <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li>
        </ul>

        <!-- Tab List -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">

                <div class="row clearfix js-sweetalert">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header q-line q-mb20 d-flex">
                                <h3 class="d-flex q-mr10">
                                    {{$lang->get(47)}}  {{--Market--}}
                                </h3>
                                <div id="start-rating" class="d-flex flex-vertical-center q-mr10">
                                </div>
                                <div class="d-flex flex-vertical-center"> {{$rating}} </div>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>{{$lang->get(69)}}</th>
                                            <th>{{$lang->get(70)}}</th>
                                            <th>{{$lang->get(71)}}</th>
                                            <th>{{$lang->get(150)}}</th>
                                            <th>{{$lang->get(151)}}</th>
                                            <th>{{$lang->get(152)}}</th>
                                            <th>{{$lang->get(73)}}</th>
                                            <th>{{$lang->get(72)}}</th>
                                            <th>{{$lang->get(74)}}</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>{{$lang->get(69)}}</th>
                                            <th>{{$lang->get(70)}}</th>
                                            <th>{{$lang->get(71)}}</th>
                                            <th>{{$lang->get(150)}}</th>
                                            <th>{{$lang->get(151)}}</th>
                                            <th>{{$lang->get(152)}}</th>
                                            <th>{{$lang->get(73)}}</th>
                                            <th>{{$lang->get(72)}}</th>
                                            <th>{{$lang->get(74)}}</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr id="tr{{$data->id}}">
                                                <td>{{$data->name}}</td>
                                                <td>
                                                    <img src="images/{{$data->image}}" height="50" style='min-height: 50px; ' alt="">
                                                </td>

                                                <td>{{$data->desc}}</td>

                                                <td>{{$data->address}}</td>

                                                <td>{{$data->phone}}</td>

                                                <td>{{$data->mobilephone}}</td>

                                                <td>
                                                    @if ($data->published == "1")
                                                        <img src="img/iconyes.png" width="40px">
                                                    @else
                                                        <img src="img/iconno.png" width="40px">
                                                    @endif
                                                </td>

                                                <td>{{$data->updated_at}}</td>

                                                <td>
                                                    <button type="button" class="q-btn-all q-color-second-bkg waves-effect"
                                                            onclick="editItem('{{$data->id}}','{{$data->name}}', '{{$data->published}}', '{{$data->imageid}}',
                                                                '{{$data->image}}', '{{$data->desc}}',
                                                                '{{$data->delivered}}', '{{$data->address}}', '{{$data->phone}}', '{{$data->mobilephone}}',
                                                                '{{$data->lat}}', '{{$data->lng}}', '{{$data->fee}}', '{{$data->percent}}', '{{$data->tax}}', '{{$data->perkm}}')">
                                                        {{$lang->get(564)}} {{--Edit--}}
                                                    </button>

                                                </td>

                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row clearfix js-sweetalert">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header q-line q-mb20 d-flex">
                                <h3>
                                    {{$lang->get(183)}}  {{--MARKET REVIEWS LIST--}}
                                </h3>
                            </div>
                            <div class="body">
                                @include('elements.marketVendorReviewsTable', array())
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- End Tab List -->

            <!-- Tab Edit -->

            <div role="tabpanel" class="tab-pane fade" id="edit">


                <div id="redalertEdit" class="alert bg-red" style='display:none;' >

                </div>

                <form id="formedit" method="post" action="{{url('marketedit')}}"  >
                    @csrf

                    <input type="hidden" id="imageidEdit" name="image"/>
                    <input type="hidden" id="editid" name="id"/>

                    <div class="row clearfix q-mt20 q-mb20">

                        <div class="col-md-6 foodm">

                            <div class="col-md-3 foodm">
                                <label for="name"><h4>{{$lang->get(69)}} <span class="q-color-alert2">*</span></h4></label>
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="text" name="name" id="nameEdit" class="q-form" placeholder="" maxlength="100">
                                    </div>
                                    <label class="foodm">{{$lang->get(91)}}</label>
                                </div>
                            </div>


                            <div class="col-md-3 foodm">
                                <label for="name"><h4>{{$lang->get(150)}}</h4></label>
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="text" name="address" id="addressEdit" class="q-form" placeholder="" maxlength="100">
                                    </div>
                                    <label class="foodm">{{$lang->get(153)}}</label>
                                </div>
                            </div>

                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(152)}}</h4></label>
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="text" name="phone" id="phoneEdit" class="q-form" placeholder="" maxlength="20">
                                    </div>
                                    <label class="foodm">{{$lang->get(154)}}</label>
                                </div>
                            </div>

                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(155)}}</h4></label>
                            </div>

                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="text" name="mobilephone" id="mobilephoneEdit" class="q-form" placeholder="" maxlength="20">
                                    </div>
                                    <label class="foodm">{{$lang->get(156)}}</label>
                                </div>
                            </div>

                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(71)}}</h4></label>
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="text" name="desc" id="descEdit" class="q-form" placeholder="" maxlength="300">
                                    </div>
                                    <label class="foodm">{{$lang->get(76)}}</label>
                                </div>
                            </div>

                            <div class="col-md-4 foodm">
                                <label><h4>{{$lang->get(157)}} <span class="col-red">*</span></h4></label>      {{--Delivery fee--}}
                            </div>
                            <div class="col-md-8 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="number" name="fee" id="feeEdit" class="q-form" placeholder="" min="0" step="0.01">
                                    </div>
                                    <label class="font-12">{{$lang->get(158)}}</label>          {{--Insert Delivery Fee--}}
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="percentEdit" name="percent" class="filled-in checkmark">
                                    <label for="percentEdit" class="foodlabel">{{$lang->get(159)}}</label>     {{--Percents--}}
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="perkmEdit" name="perkm" class="filled-in checkmark">
                                    <label for="perkmEdit" class="foodlabel">{{$lang->get(611)}}</label>     {{--per kilometer or mile--}}
                                </div>
                            </div>

                            <div class="col-md-12 info" style="margin-top: 5px; margin-left: 20px; margin-bottom: 20px">
                                <h4>{{$lang->get(160)}}</h4>        {{--Delivery fee may be in percentages from order or a given amount.--}}
                                <p>{{$lang->get(161)}}</p>      {{--If `percent` CheckBox is clear, the delivery fee in application set a given amount.--}}
                                <p id="currentEdit">{{$lang->get(162)}}: {{$currency->currency()}}0</p>     {{--Current--}}
                            </div>

                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(163)}}</h4></label>   {{--Delivery Area--}}
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="number" name="area" id="areaEdit" class="q-form" placeholder="" value="30">
                                        <label class="form-label">{{$lang->get(164)}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(550)}}</h4></label>   {{--Minimum purchase amount--}}
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="number" name="minAmount" id="minAmountEdit" class="q-form" placeholder="" value="30">
                                        <label class="form-label">{{$lang->get(551)}}</label>       {{--For ex: 100. If 0 - no Minimum purchase amount--}}
                                    </div>
                                </div>
                            </div>
                            @include('elements.form.percent', array('label' => $lang->get(582), 'text' => $lang->get(583), 'id' => "tax", 'request' => "false",))   {{--Default TAX-- Insert TAX for this vendor in percentages--}}
                        </div>

                        <div class="col-md-6 foodm">

                            <div class="col-md-3 foodm">
                                <label for="lat"><h4>{{$lang->get(165)}} <span class="q-color-alert2">*</span></h4></label>
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="number" name="lat" id="latEdit" class="q-form" placeholder="" step="0.00000000000000001">
                                    </div>
                                    <label class="foodm">{{$lang->get(166)}}</label>
                                </div>
                            </div>

                            <div class="col-md-3 foodm">
                                <label for="lng"><h4>{{$lang->get(167)}} <span class="q-color-alert2">*</span></h4></label> {{--Longitude--}}
                            </div>
                            <div class="col-md-9 foodm">
                                <div class="form-group form-group-lg form-float">
                                    <div class="form-line">
                                        <input type="number" name="lng" id="lngEdit" class="q-form" placeholder="" step="0.00000000000000001">
                                    </div>
                                    <label class="foodm">{{$lang->get(168)}}</label>
                                </div>
                            </div>


                            <div class="row clearfix">
                                <div class="col-md-2 form-control-label">
                                    <label><h4>{{$lang->get(70)}}:</h4></label>
                                    <br>
                                    <div align="center">
                                        <button type="button" onclick="fromLibraryEdit()" class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(77)}}</h5></button>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div id="dropzoneEdit" class="fallback dropzone">
                                        <div class="dz-message">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons">touch_app</i>
                                            </div>
                                            <h3>{{$lang->get(78)}}</h3>
                                        </div>
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 foodm">
                                <label><h4>{{$lang->get(169)}}:</h4></label>
                            </div>
                            <div class="col-md-9 foodm" style="margin-top: 20px;">
                                <table border="0">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h5>{{$lang->get(170)}}</h5>
                                        </td>
                                        <td></td>
                                        <td>
                                            <h5>{{$lang->get(171)}}</h5>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><h5>{{$lang->get(172)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeMonday" id="openTimeMondayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="closeTimeMonday" id="closeTimeMondayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>{{$lang->get(173)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeTuesday" id="openTimeTuesdayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="closeTimeTuesday" id="closeTimeTuesdayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="margin-top: 5px;">
                                        <td><h5>{{$lang->get(174)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeWednesday" id="openTimeWednesdayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="closeTimeWednesday" id="closeTimeWednesdayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="margin-top: 5px;">
                                        <td><h5>{{$lang->get(175)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeThursday" id="openTimeThursdayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="closeTimeThursday" id="closeTimeThursdayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>{{$lang->get(176)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeFriday" id="openTimeFridayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                                <input type="text" name="closeTimeFriday" id="closeTimeFridayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>{{$lang->get(177)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeSaturday" id="openTimeSaturdayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                                <input type="text" name="closeTimeSaturday" id="closeTimeSaturdayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>{{$lang->get(178)}}:</h5></td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                                <input type="text" name="openTimeSunday" id="openTimeSundayEdit" class="q-form time24" placeholder="Ex: 10:00">
                                            </div>
                                        </td>
                                        <td width="5%"></td>
                                        <td>
                                            <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                                <input type="text" name="closeTimeSunday" id="closeTimeSundayEdit" class="q-form time24" placeholder="Ex: 23:00">
                                            </div>
                                        </td>
                                    </tr>

                                </table>

                            </div>


                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-md-12 form-control-label">
                            <div align="center">
                                <button type="submit"  class="q-btn-all q-color-second-bkg waves-effect"><h5>{{$lang->get(142)}}</h5></button>
                            </div>
                        </div>
                    </div>


                </form>

            </div>

        </div>
        <div id="dropzone2" class="fallback dropzone" hidden>
            <div class="dz-message">
            </div>
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
        </div>



</div>

<script type="text/javascript">

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href")
        if (target != "#edit")
            document.getElementById("tabEdit").style.display = "none";
        console.log(target);
    });

    async function editItem(id, name, visible, imageid, ifile, desc,
                            delivered, address, phone, mobilephone, lat, lng,
                            fee, percent, tax, perkm) {
        document.getElementById("tabEdit").style.display = "block";
        $('.nav-tabs a[href="#edit"]').tab('show');

        document.getElementById("nameEdit").value = name;
        document.getElementById("editid").value = id;
        document.getElementById("addressEdit").value = address;
        document.getElementById("phoneEdit").value = phone;
        document.getElementById("mobilephoneEdit").value = mobilephone;
        document.getElementById("latEdit").value = lat;
        document.getElementById("lngEdit").value = lng;
        document.getElementById("descEdit").value = desc;
        document.getElementById("tax").value = tax;
        //
        document.getElementById('feeEdit').value = fee;
        document.getElementById("percentEdit").checked = percent === '1';
        document.getElementById("perkmEdit").checked = perkm === '1';
        if (percent == '1')
            currentEdit.innerHTML = "Current: "+fee+"%";
        else
            currentEdit.innerHTML = "Current: {{$currency->currency()}}"+fee;
        //
        if ({{$data->id}} == id){
            document.getElementById("openTimeMondayEdit").value = '{{$data->openTimeMonday}}';
            document.getElementById("closeTimeMondayEdit").value = '{{$data->closeTimeMonday}}';
            document.getElementById("openTimeTuesdayEdit").value = '{{$data->openTimeTuesday}}';
            document.getElementById("closeTimeTuesdayEdit").value = '{{$data->closeTimeTuesday}}';
            document.getElementById("openTimeWednesdayEdit").value = '{{$data->openTimeWednesday}}';
            document.getElementById("closeTimeWednesdayEdit").value = '{{$data->closeTimeWednesday}}';
            document.getElementById("openTimeThursdayEdit").value = '{{$data->openTimeThursday}}';
            document.getElementById("closeTimeThursdayEdit").value = '{{$data->closeTimeThursday}}';
            document.getElementById("openTimeFridayEdit").value = '{{$data->openTimeFriday}}';
            document.getElementById("closeTimeFridayEdit").value = '{{$data->closeTimeFriday}}';
            document.getElementById("openTimeSaturdayEdit").value = '{{$data->openTimeSaturday}}';
            document.getElementById("closeTimeSaturdayEdit").value = '{{$data->closeTimeSaturday}}';
            document.getElementById("openTimeSundayEdit").value = '{{$data->openTimeSunday}}';
            document.getElementById("closeTimeSundayEdit").value = '{{$data->closeTimeSunday}}';
            //
            var area = '{{$data->area}}';
            if (area == "")
                area = 30;
            document.getElementById("areaEdit").value = area;
            document.getElementById("minAmountEdit").value = '{{$data->minAmount}}';
        }

        addEditImage(imageid, ifile);
    }

    var form = document.getElementById("formedit");
    form.addEventListener("submit", checkFormEdit, true);

    function checkFormEdit(event) {
        if (!document.getElementById("nameEdit").value) {
            showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
            event.preventDefault();
            return false;
        }
        if (!document.getElementById("latEdit").value) {
            showNotification("bg-red", "{{$lang->get(179)}}", "bottom", "center", "", "");  // The Latitude field is required.
            event.preventDefault();
            return false;
        }
        if (!document.getElementById("lngEdit").value) {
            showNotification("bg-red", "{{$lang->get(180)}}", "bottom", "center", "", "");  // The Longitude field is required.
            event.preventDefault();
            return false;
        }
    }

    //
    // edit
    //
    percentEdit = document.getElementById('percentEdit');
    currentEdit = document.getElementById('currentEdit');
    feeEdit = document.getElementById('feeEdit');
    var perkmEdit = document.getElementById('perkmEdit');
    percentEdit.addEventListener('change', (event) => {
        var vl = feeEdit.value;
        if (vl == null) vl = 0;
        if (event.target.checked) {
            if (feeEdit.value > 100){
                vl = 100;
                feeEdit.value = 100;
            }
            currentEdit.innerHTML = "Current: "+vl+"%";
            perkmEdit.checked = false;
        } else {
            if (perkmEdit.checked)
                currentEdit.innerHTML = "Current: {{$currency->currency()}}" + vl + " per km or ml"
            else
                currentEdit.innerHTML = "Current: {{$currency->currency()}}"+vl;
        }
    })
    perkmEdit.addEventListener('change', (event) => {
        if (perkmEdit.checked) {
            let vl = feeEdit.value;
            percentEdit.checked = false;
            currentEdit.innerHTML = "Current: {{$currency->currency()}}" + vl + " per km or ml"
        }
    })

    feeEdit.addEventListener('input', (event) => {
        var vl = feeEdit.value;
        if (vl == null) vl = 0;
        if (percentEdit.checked) {
            if (feeEdit.value > 100){
                vl = 100;
                feeEdit.value = 100;
            }
            currentEdit.innerHTML = "Current: "+vl+"%";
        } else {
            currentEdit.innerHTML = "Current: {{$currency->currency()}}"+vl;
        }
    })

    //Time
    var $demoMaskedInput = $('.demo-masked-input');

    $demoMaskedInput.find('.time12').inputmask('hh:mm t', { placeholder: '__:__ _m', alias: 'time12', hourFormat: '12' });
    $demoMaskedInput.find('.time24').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });

    document.getElementById("start-rating").innerHTML = createRatings({{$drating}});

</script>

@include('bsb.image', array('petani' => $petani))

@endsection

