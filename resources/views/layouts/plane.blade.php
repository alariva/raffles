<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>Couponic</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="{{ $raffle->name }}" name="description"/>
	<meta content="alariva.com" name="author"/>

	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
    
    {!! Analytics::render() !!}

    <style type="text/css">
    @stack('style')
    </style>
</head>
<body>
	@yield('body')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
    @stack('scripts')
</body>

<script type="text/javascript">
    var images = document.getElementsByTagName("img");
    var i;

    for(i = 0; i < images.length; i++) {
        images[i].className += " img-responsive";
    }
</script>
</html>