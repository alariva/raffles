@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="container-fluid">

    {!! Markdown::convertToHtml( $raffle->description ) !!}

    @if($raffle->opened_at->isFuture())

        {!! Alert::info('La entrega de talones abre '.$raffle->opened_at->diffForHumans()) !!}

    @else

    <div class="row">
    <div class="col-lg-3 col-md-6">
        @include('widgets.box', ['color' => 'green', 'icon' => 'tags', 'count' => $reservedCount, 'label' => 'Talones Reservados', 'url' => route('coupons.browse', $raffle), 'linkLabel' => 'Reservar'])
    </div>
    <div class="col-lg-9 col-md-6">

        @if($raffle->closed_at->isFuture())
        {!! Alert::info("La entrega de talones cierra {$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->diffForHumans()} ({$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->toDateTimeString()})") !!}

        {!! Button::primary('Elegi tus numeros de la suerte acá')
                    ->block()
                    ->large()
                    ->asLinkTo(route('coupons.browse', $raffle), ['id' => '#browse']) !!}
        @else
        {!! Alert::warning('La entrega de talones cerró '.$raffle->closed_at->timezone('America/Argentina/Buenos_Aires')->diffForHumans().'! Mucha suerte!') !!}
        @endif

    </div>

    </div>

        @if($terms)
            <button class="btn btn-normal btn-lg btn-block" data-toggle="modal" data-target="#myModal">
                Bases y Condiciones
            </button>

            @include('raffles._terms', compact('terms'))
        @endif

    @endif

</div>

<br/>

@stop
