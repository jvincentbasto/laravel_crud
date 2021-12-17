<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com/"></script>

    <title>
    	@yield('title')
    </title>
  </head>
  <body class="bg-neutral-100">

  	<x-navbar title="CRUD" />
  	<div style="min-height: 650px; height: auto;" class="max-w-full pt-8">
	    @yield('content')  		
  	</div>
    <x-footer	title="John Vincent Basto" />

  </body>
</html>
