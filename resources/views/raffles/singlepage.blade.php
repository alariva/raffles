@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="container-fluid">

    {!! Markdown::convertToHtml( $raffle->description ) !!}

    @if($raffle->opened_at->isFuture())

        {!! Alert::info('La entrega de talones abre '.$raffle->opened_at->diffForHumans()) !!}

    @else

    <div class="row">

        @if($raffle->closed_at->isFuture())
        {!! Alert::info("La entrega de talones cierra {$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->diffForHumans()} ({$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->toDateTimeString()})") !!}

        @else
        {!! Alert::warning('La entrega de talones cerró '.$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->diffForHumans()) !!}
        @endif

        @if($terms)
            <button class="btn btn-normal btn-lg btn-block" data-toggle="modal" data-target="#myModal">
                Términos
            </button>

            @include('raffles._terms', compact('terms'))
        @endif

    </div>

    @endif

</div>

<br/>

{!! Form::open(['route' => ['coupons.directconfirm', $raffle], 'class' => 'form-horizontal']) !!}
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">

    <div class="panel panel-default">
      <!-- Default panel contents -->

      <div class="panel-body">
        
        <p class="lead">Registro para participar del taller.</p>

        <div class="form-group">
        {!! Form::label('name', 'Tu Nombre completo', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
          {!! Form::text('name', '', ['class' => 'form-control input-lg', 'placeholder' => 'Juan Perez']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('dni', 'Tu DNI', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
          {!! Form::text('dni', '', ['class' => 'form-control input-lg', 'placeholder' => '00000000']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('email', 'Tu email', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
          {!! Form::email('email', '', ['class' => 'form-control input-lg', 'placeholder' => 'juanperez@ejemplo.com']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('tel', 'Tu teléfono', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
        {!! Form::tel('tel', '', ['class' => 'form-control input-lg', 'placeholder' => '1568088592']) !!}
        </div>
        </div>

        <div class="form-group">
        {!! Form::label('city', 'Barrio', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
        {!! Form::text('city', '', ['class' => 'form-control input-lg', 'placeholder' => 'Villa Urquiza, CABA']) !!}
        </div>
        </div>

        <div class="form-group">
        <div class="col-sm-12">
          <div class="checkbox">
              <label style="font-size: 1em">
                  <input type="checkbox" name="accept_terms" value="yes">
                  <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                  Acepto las Condiciones del taller
              </label>
          </div>
        </div>
        </div>

      <div class="panel-footer">

        {!! Button::success("Reservar (ARS $price)")
                    ->block()
                    ->large()
                    ->prependIcon('<i class="fa fa-shopping-cart" aria-hidden="true"></i>')
                    ->submit() !!}

      </div>
    </div>
</div>
{!! Form::close() !!}

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