@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="container-fluid">

    {!! Markdown::convertToHtml( $raffle->description ) !!}

    @if($raffle->opened_at->isFuture())

        {!! Alert::info('La entrega de talones abre '.$raffle->opened_at->diffForHumans()) !!}

    @else

        @if($raffle->closed_at->isFuture())
        {!! Alert::info('La entrega de talones cierra '.$raffle->closed_at->diffForHumans()) !!}

        {!! Button::primary('Elegi tus numeros de la suerte acá')
                    ->block()
                    ->large()
                    ->asLinkTo(route('coupons.browse', $raffle)) !!}
        @else
        {!! Alert::warning('La entrega de talones cerró '.$raffle->closed_at->diffForHumans().'! Mucha suerte!') !!}
        @endif

    @endif

</div>

<br/>

@stop
