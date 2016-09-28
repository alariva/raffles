@extends('layouts.public')
@section('page_heading', "Paso 2: Confirmá tus datos")
@section('section')

{!! Form::open(['route' => ['coupons.confirm', $raffle], 'class' => 'form-horizontal']) !!}
<div class="col-xs-6 col-md-8 col-sm-12 col-md-offset-2">

    <div class="panel panel-default">
      <!-- Default panel contents -->

      <div class="panel-body">
        
        <p class="lead">Necesitamos algunos datos de contacto en caso de resultar ganador.</p>

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

@include('_footer')

@stop