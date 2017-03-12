@extends('layouts.public')
@section('page_heading','Gracias!')
@section('section')

<div class="container-fluid">
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Estado de tu reserva</div>

      <div class="panel-body">

        @foreach($purchase->coupons as $coupon)
          @if($coupon->status == 'R')
            {!! Alert::warning("El cupón N° {$coupon->code} está pendiente de pago hasta {$coupon->created_at->addDays(3)->toDateString()} a nombre de {$coupon->notes}.") !!}
          @elseif($coupon->status == 'P')
            {!! Alert::success("El cupón N° {$coupon->code} está pago y confirmado a nombre de {$coupon->notes}.") !!}
          @elseif($coupon->status == 'H')
            {!! Alert::info("El cupón N° {$coupon->code} está disponible a través de distribuidor autorizado.") !!}
          @else
            {!! Alert::warning("El cupón N° {$coupon->code} está reservado.") !!}
          @endif
        @endforeach

        <p>Recordá que tu reserva dura 96 hs y será confirmada una vez ingresado el pago.</p>

      </div>

      <div class="panel-footer">
        <i class="fa fa-barcode"></i>
        <span class="text-muted">Transacción {{ substr($purchase->hash,0,6) }}</span>
      </div>

    </div>

      @if($purchase->url && !$purchase->isPaid())
        {!! Button::primary('Ticket de Pago')
                    ->large()
                    ->block()
                    ->prependIcon('<i class="fa fa-money"></i>&nbsp;')
                    ->asLinkTo($purchase->url)
                    ->withAttributes(['target' => '_blank']) !!}
      @endif

{{--
        {!! Button::normal('Comprar más talones')
                    ->large()
                    ->block()
                    ->prependIcon('<i class="fa fa-shopping-cart"></i>&nbsp;')
                    ->asLinkTo(route('coupons.browse', session('cart.raffle'))) !!}
--}}
      <br/>

</div>
</div>

@include('_footer')

@stop