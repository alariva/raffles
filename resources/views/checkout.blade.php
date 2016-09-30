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

        <div class="form-group">
        <div class="col-sm-12">
          <div class="checkbox">
              <label style="font-size: 1em">
                  <input type="checkbox" name="accept_terms" value="yes">
                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                  Acepto las Bases y Condiciones del sorteo
              </label>
          </div>
        </div>
        </div>

        <div class="form-group">
        <div class="col-sm-12">
          <div class="checkbox">
              <label style="font-size: 1em">
                  <input type="checkbox" name="contactme" value="yes" >
                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                  Pertenezco a un club/grupo y quiero organizar un sorteo similar, por favor contactarme.
              </label>
          </div>
        </div>
        </div>

      <!-- List group -->
      <ul class="list-group">
        @foreach($coupons as $coupon)
            <li class="list-group-item list-group-item-success">
              <i class="fa fa-tag"></i>&nbsp;
              <big><strong>N° {{ $coupon }}</strong></big>
            </li>
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

@push('style')
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
@endpush