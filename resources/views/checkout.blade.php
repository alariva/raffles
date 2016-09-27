@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="col-xs-6 col-md-6 col-md-offset-3">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Comprar Rifas</div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)
            <li class="list-group-item list-group-item-success">Numero {{ $coupon }}</li>
        @endforeach
      </ul>

      <div class="panel-body">
        <p>Casi listos, ahora necesitamos algunos datos para contactarte si en caso de ganar uno de los premios.</p>
      </div>

    <div class="panel-footer">
      {!! Form::open(['route' => ['coupons.confirm', $raffle]]) !!}

      <div class="form-group">
      {!! Form::label('name', 'Tu Nombre completo', ['class' => 'control-label']) !!}
      {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Juan Perez']) !!}
      </div>

      <div class="form-group">
      {!! Form::label('email', 'Tu email', ['class' => 'control-label']) !!}
      {!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'juanperez@ejemplo.com']) !!}
      </div>

      <div class="form-group">
      {!! Form::label('tel', 'Tu teléfono', ['class' => 'control-label']) !!}
      {!! Form::text('tel', '', ['class' => 'form-control', 'placeholder' => '1568088592']) !!}
      </div>

      <div class="form-group">
      {!! Form::label('city', 'Ciudad', ['class' => 'control-label']) !!}
      {!! Form::text('city', 'Villa Martelli, Buenos Aires', ['class' => 'form-control', 'placeholder' => 'Buenos Aires']) !!}
      </div>

      {!! Button::success("Confirmar Rifas (\$ {$price})")
                  ->block()
                  ->large()
                  ->withIcon('<i class="fa fa-shopping-cart" aria-hidden="true"></i>')
                  ->submit() !!}

      {!! Form::close() !!}
    </div>
    </div>
</div>

@stop