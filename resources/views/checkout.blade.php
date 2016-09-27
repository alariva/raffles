@extends('layouts.public')
@section('page_heading','Rifas')
@section('section')

<div class="col-xs-6 col-md-3 col-md-offset-4">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Rifas</div>
      <div class="panel-body">
        <p>Tus numeros de la suerte</p>
      </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)
            <li class="list-group-item list-group-item-success">Numero {{ $coupon }}</li>
        @endforeach
      </ul>
    <div class="panel-footer">
      <button type="button" class="btn btn-success btn-block btn-lg" aria-label="">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Comprar Rifas
      </button>
    </div>
    </div>
</div>

@stop