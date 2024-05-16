<div class="row">
    <div class="col-6" style="font-size: 14px">
        <strong>Office Address</strong>
        <br>
        {{authUserServiceType()->getAddress()['address']}}
        <br>
        {{authUserServiceType()->getAddress()['address2']}}
        <br>
        {{authUserServiceType()->getAddress()['address3']}}
        <br>
        <strong>PHONE : {{authUserServiceType()->getAddress()['phone']}}</strong>
        <br>
        <strong>MOBILE : {{authUserServiceType()->getAddress()['mobile']}}</strong>
    </div>
    <div class="col-6 float-right">
        <h4 class="text-right" style="font-size: 14px;margin-top: 12px!important;z-index: 9999">
            <span class="float-left" style="font-size: 26px;text-align: left;margin-left: 190px;color: #8e7920; font-weight: bold;">ARCF</span>
            <br><br>
            <div style="margin-right: 55px;!important;">{{authUserServiceType()->getShortLabel()}}</div>
        </h4>
        <h4 class="text-right" style="font-size: 14px;margin-top: 20px!important;font-weight: bold;margin-right: 80px;"> <span>Email: {{authUserServiceType()->getAddress()['email']}}</span></h4>
        <img src="{{authUserServiceType()->getLogoUrl()}}" alt="{{authUserServiceType()->getLabel()}}" class="float-right" style="width: 100px; margin-top: -130px;margin-right: 295px;z-index: 1">
    </div>

    <div class="col-12" style="border-top: 2px solid gray"></div>
</div>
<h1 class="text-center text-decoration-underline" style="font-size: 38px;">{{@$title}}</h1>
{{--<h3 style="text-align: center">{{@authUser()->service_type->getLabel()}}</h3>--}}
