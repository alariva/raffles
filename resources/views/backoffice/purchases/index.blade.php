@extends('layouts.public')
@section('page_heading','Compras')
@section('section')

<div class="container-fluid">

  {!! Table::withContents($data) !!}

</div>

@stop