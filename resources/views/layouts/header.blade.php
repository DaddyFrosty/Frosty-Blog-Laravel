<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<meta name="author" content="{{ env("APP_NAME") }} Developers">
	@if ( trim( $__env->yieldContent( "subtitle" ) ) )
		<meta name="description" content="@yield( 'subtitle' )">
	@endif

	<title>{{ env("APP_NAME") }} | @yield('title', 'Home')</title>

	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" /> --}}
	{{-- <link rel='stylesheet' type='text/css' media='screen' href='{{ asset('css/app.css') }}'> --}}

	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script> --}}
	{{-- <script src="https://momentjs.com/downloads/moment-timezone.js"></script> --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
	{{-- <script src="{{ asset( 'js/utility.js' ) }}"></script> --}}
	{{-- @livewireStyles --}}

	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
	@stack('styles')
</head>
<body>