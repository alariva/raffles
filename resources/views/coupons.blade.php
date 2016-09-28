@extends('layouts.public')
@section('page_heading','Paso 1: Elegí tus números')
@section('section')

<div class="container-fluid">
<div class="col-xs-6 col-md-6 col-md-offset-3">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Rifas</div>
      <div class="panel-body">
        <p>Estos son los números disponibles para reservar. Tu reserva será efectiva únicamente con tu comprobante de pago.</p>
      </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)

        @if(in_array($coupon, $selected))
            <li class="list-group-item list-group-item-success">N° {{ $coupon }} <i class="fa fa-check"></i></li>
        @else
            <a href="{{ route('coupons.add', $coupon) }}"><button type="button" class="list-group-item">N° {{ $coupon }} </button></a>
        @endif
        @endforeach
      </ul>
    <div class="panel-footer">

    @if(count($selected)>0)

      {!! Button::success('Reservar Rifas')
                  ->large()
                  ->block()
                  ->withIcon('<i class="fa fa-shopping-cart" aria-hidden="true"></i>')
                  ->asLinkTo(route('coupons.checkout', $raffle)) !!}

    @else

      {!! Alert::info('Elegí una rifa para reservar') !!}

    @endif

    </div>
    </div>
</div>
</div>

@include('_footer')

@stop