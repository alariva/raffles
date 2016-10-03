@extends('layouts.public')
@section('page_heading','Mis compras')
@section('section')

<div class="container-fluid">
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Tus compras</div>

      <div class="panel-body">

        @forelse($purchases as $purchase)
            {!! Button::normal($purchase->created_at->toDateTimeString())
                        ->block()
                        ->asLinkTo(route('coupons.purchase', ['raffle' => $raffle, 'hash' => $purchase->hash])) !!}
        @empty
            {!! Alert::info('Aún no hiciste una compra') !!}

            {!! Button::primary('Comprar')
                        ->block()
                        ->asLinkTo(route('coupons.browse', $raffle)) !!}
        @endforelse

      </div>

    </div>

</div>
</div>

@include('_footer')

@stop