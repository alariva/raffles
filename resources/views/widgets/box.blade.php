<div class="panel panel-{{$color}}">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
                <i class="fa fa-{{$icon}} fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge">{{ $count }}</div>
                <div>{{$label}}</div>
            </div>
        </div>
    </div>
    <a href="{{ $url }}">
        <div class="panel-footer">
            <span class="pull-left">{{ $linkLabel }}</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>