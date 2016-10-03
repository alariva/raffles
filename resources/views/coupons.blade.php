@extends('layouts.public')
@section('page_heading','Paso 1: Elegí tus números')
@section('section')

<div class="container-fluid">

<a href="#next" class="scroll-down" style="display: inline;">
  <i class="fa fa-arrow-down" title="Continuar"></i>
</a>

<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Quedan {{ $count }} talones disponibles</div>
      <div class="panel-body">
        <p>Estos son los números disponibles para reservar. Tu reserva será efectiva <strong>únicamente con tu comprobante de pago.</strong></p>

        @foreach($coupons->chunk(4) as $chunk)

          <div class="row">
          @foreach($chunk as $coupon)
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            @if(in_array($coupon, $selected))
                <button type="button" class="list-group-item list-group-item-info" disabled>
                  <big><i class="fa fa-tag"></i>&nbsp;N°{{ $coupon }}</big><i class="fa fa-check"></i>
                </button>
            @else
                <a href="{{ route('coupons.add', $coupon) }}">
                  <button type="button" class="list-group-item">
                    <big><i class="fa fa-tag"></i>&nbsp;N°{{ $coupon }}</big>
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
    <div class="panel-footer" id="next">

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

@push('scripts')
<script type="text/javascript">
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
</script>
@endpush

@push('style')
.scroll-down {
  background: none;
  margin: 0;
  position: fixed;
  bottom: 0;
  right: 0;
  width: 70px;
  height: 70px;
  z-index: 100;
  display: none;
  text-decoration: none;
  color: #3C763D;
}

.scroll-down i {
  font-size: 3em;
}
@endpush