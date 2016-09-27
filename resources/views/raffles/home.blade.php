@extends('layouts.public')
@section('page_heading', $raffle->name)
@section('section')

<div class="container">           
    {!! Markdown::convertToHtml( $raffle->description ) !!}
</div>

@stop
