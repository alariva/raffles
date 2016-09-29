@extends('layouts.public')
@section('page_heading','Estado de reserva')
@section('section')

<div class="container-fluid">
<div class="col-xs-8 col-md-8 col-md-offset-2 col-sm-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Estado de cupones</div>

      <div class="panel-body">

      @foreach($purchase->coupons as $coupon)
        @if($coupon->status == 'R')
          {!! Alert::warning("El cupón N° {$coupon->code} está reservado pendiente de pago hasta {$coupon->created_at->addDays(3)->toDateString()} a nombre de {$coupon->notes}.") !!}
        @elseif($coupon->status == 'P')
          {!! Alert::success("El cupón N° {$coupon->code} está pago y confirmado a nombre de {$coupon->notes}.") !!}
        @elseif($coupon->status == 'H')
          {!! Alert::info("El cupón N° {$coupon->code} está disponible a través de distribuidor autorizado.") !!}
        @else
          {!! Alert::warning("El cupón N° {$coupon->code} está reservado.") !!}
        @endif

      </div>

    </div>

</div>
</div>

@include('_footer')

@stop