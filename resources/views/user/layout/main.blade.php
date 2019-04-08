<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel='stylesheet' href="{{ asset('css/animate.css') }}">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title')</title>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}" ></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
  </head>
  <body>
  	<div class="header">
  		@include('user.layout.header')
  	</div>
  	<div class="content">
      @yield('content')
  	</div>
  	{{--<div class="footer">--}}
  		{{--@include('user.layout.footer')--}}
  	{{--</div>--}}
    <script>
        FormatPrice();
        function FormatPrice(){
            $('.fm-price').each(function(index, el) {
                var temp = "---";
                if($(this).text() !== '---'){
                    temp = $(this).text().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '₫';
                }
                $(this).text(temp);
            });
        }
    </script>
  </body>
</html>