@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

{!! Form::open(['route' => ['coupons.confirm', $raffle], 'class' => 'form-horizontal']) !!}
<div class="col-xs-6 col-md-8 col-sm-12 col-md-offset-2">

    <div class="panel panel-default">
      <!-- Default panel contents -->

      <div class="panel-body">
        
        <p class="lead">Casi listos! Necesitamos algunos datos de contacto en caso de resultar ganador.</p>

        <div class="form-group">
        {!! Form::label('name', 'Tu Nombre completo', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
          {!! Form::text('name', '', ['class' => 'form-control input-lg', 'placeholder' => 'Juan Perez']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('email', 'Tu email', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
          {!! Form::text('email', '', ['class' => 'form-control input-lg', 'placeholder' => 'juanperez@ejemplo.com']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('tel', 'Tu teléfono', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
        {!! Form::text('tel', '', ['class' => 'form-control input-lg', 'placeholder' => '1568088592']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('city', 'Ciudad', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
        {!! Form::text('city', 'Villa Martelli, Buenos Aires', ['class' => 'form-control input-lg', 'placeholder' => 'Buenos Aires']) !!}
        </div>
        </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)
            <li class="list-group-item list-group-item-success">N° {{ $coupon }}</li>
        @endforeach
      </ul>

      <div class="panel-footer">

        {!! Button::success("Confirmar Rifas (\$ {$price})")
                    ->block()
                    ->large()
                    ->prependIcon('<i class="fa fa-shopping-cart" aria-hidden="true"></i>')
                    ->submit() !!}

      </div>
    </div>
</div>
{!! Form::close() !!}

    <div class="well" style="background-color:#fff">

        <ul class="list-inline">
            <li><img src="{!! asset('img/payment/logos/logo_r1_c1.gif') !!}" alt="Saldo CuentaDigital" width="108" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c11.gif') !!}" alt="VoucherDigital" width="68" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c20.gif') !!}" alt="PagoFacil Pago Facil" width="30" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c27.gif') !!}" alt="RapiPago Rapi Pago" width="68" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c56.gif') !!}" alt="CobroExpress" width="48" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c63.gif') !!}" alt="Ripsa" width="44" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c68.png') !!}" alt="Link RedLink PagosLink LinkPagos" width="26" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_c76.gif') !!}" alt="PagoDirecto Pago Directo Debito Automatico" width="43" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r2_c36.gif') !!}" alt="Bapro BaproPagos" width="68" height="20"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r2_c44.gif') !!}" alt="ProvinciaPagos Provincia Pagos" width="65" height="21"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_formo.gif') !!}" alt="FormoPagos" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_pagolisto.gif') !!}" alt="Pagolisto" height="31"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_pampa.gif') !!}" alt="PampaPagos" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_chubut.gif') !!}" alt="ChubutPagos" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r1_coope.gif') !!}" alt="Cooperativa Obrera" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/logo_r8_c40.gif') !!}" alt="Transferencia Bancaria Local" width="76" height="25"></li>
            <li><img src="{!! asset('img/payment/logos/visa.png') !!}" alt="cobrar con VISA" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/mastercard.png') !!}" alt="cobrar con MASTERCARD" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/argencard.png') !!}" alt="cobrar con ARGENCARD" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/amex.png') !!}" alt="cobrar con American Express AMEX" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/tarjetanaranja.png') !!}" alt="cobrar con tarjeta NARANJA" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/shopping.png') !!}" alt="cobrar con TARJETA SHOPPING" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/cencosud.png') !!}" alt="cobrar con TARJETA CENCOSUD" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/nativa.png') !!}" alt="cobrar con NATIVA" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/tarjetamas.png') !!}" alt="cobrar con TARJETA MAS" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/diners.png') !!}" alt="cobrar con DINERS" height="30"></li>
            <li><img src="{!! asset('img/payment/logos/cordobesa.png') !!}" alt="cobrar con tarjeta CORDOBESA" height="30"></li>
        </ul>
    </div>

@stop