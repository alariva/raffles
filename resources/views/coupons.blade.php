@extends('layouts.public')
@section('page_heading','Paso 1: Elegí tus números')
@section('section')

<div class="container-fluid">
<div class="col-xs-6 col-md-6 col-md-offset-3 col-sm-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Quedan {{ $count }} talones disponibles</div>
      <div class="panel-body">
        <p>Estos son los números disponibles para reservar. Tu reserva será efectiva <strong>únicamente con tu comprobante de pago.</strong></p>

        @foreach($coupons->chunk(3) as $chunk)

          <div class="col-sm-4">
          @foreach($chunk as $coupon)
          <div class="row">
            @if(in_array($coupon, $selected))
                <button type="button" class="list-group-item list-group-item-info" disabled>
                  <i class="fa fa-tag"></i>&nbsp;<big>N° {{ $coupon }}</big><i class="fa fa-check"></i>
                  </button>
            @else
                <a href="{{ route('coupons.add', $coupon) }}">
                  <button type="button" class="list-group-item">
                    <i class="fa fa-tag"></i>&nbsp;<big>N° {{ $coupon }}</big>
                  </button>
                </a>
            @endif
          </div>
          @endforeach
          </div>

        @endforeach

      </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($selected as $number)

            <li class="list-group-item list-group-item-success"><i class="fa fa-tag"></i>&nbsp;N° {{ $number }} <i class="fa fa-check"></i></li>

        @endforeach
      </ul>
    <div class="panel-footer">

    @if(count($selected)>0)

      {!! Button::primary('Continuar')
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