@extends('layouts.public')
@section('page_heading','Coupons')
@section('section')

<div class="col-xs-6 col-md-3">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Rifas</div>
      <div class="panel-body">
        <p>Elegí tu número</p>
      </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)
            <a href="#"><button type="button" class="list-group-item">Numero {{ $coupon }} </button></a>
        @endforeach
      </ul>
    </div>
</div>

@stop