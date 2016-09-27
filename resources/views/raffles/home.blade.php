@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="container-fluid">     
    {!! Markdown::convertToHtml( $raffle->description ) !!}

    {!! Button::primary('Elegi tus numeros de la suerte acá')->block()->large() !!}
</div>

@stop
