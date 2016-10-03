@extends('layouts.plane')

@section('body')
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url ('') }}">Couponic</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-shopping-cart fa-fw"></i> Mis compras&nbsp;<i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                    @if(session('cart.purchases'))
                        @forelse(session('cart.purchases') as $purchase)
                        <li>
                            <a href="{!! route('coupons.purchase', ['raffle' => $raffle, 'hash' => $purchase]) !!}">
                                <div>
                                    <strong>Ver compra</strong>
                                    <span class="pull-right text-muted">
                                        <em></em>
                                    </span>
                                </div>
                                <div>{{ $purchase }}</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        @empty
                        <li>
                            <a href="{!! route('coupons.browse', ['raffle' => $raffle]) !!}">
                                <div>
                                    <strong>No hiciste compras aún</strong>
                                    <span class="pull-right text-muted">
                                        <em></em>
                                    </span>
                                </div>
                                <div>Comprar</div>
                            </a>
                        </li>
                        @endforelse
                    @endif
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <div class="text-center">
                                <img width="80%" src="{{ URL::to('/') }}/img/{{ $raffle->slug }}"/ alt="{{ $raffle->name }}" style="padding:10px">
                                <div class="caption">
                                    <h3>{{ $raffle->name }}</h3>
                                    <p class="text-muted">
                                        <small>Potenciado por <a target="_blank" href="https://alariva.com">alariva.com</a> y <a target="_blank" href="https://www.pega.sh/">pega.sh</a></small>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @if($raffle = session('cart.raffle'))
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="{{ route('raffle.home', $raffle)}}"><i class="fa fa-undo fa-fw"></i> Recomenzar</a>
                        </li>
                    @endif
                    @if($numbers = session('cart.numbers'))
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="#"><i class="fa fa-tags fa-fw"></i>{{ count($numbers) }} Números</a>
                        </li>
                    @endif
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
             <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>
            <div class="row">

                @include('_errors')

                @yield('section')              

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop

