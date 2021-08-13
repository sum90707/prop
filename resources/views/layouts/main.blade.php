<!DOCTYPE html>
<html lang="tw">
<html>
  <head>
      <!-- Standard Meta -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
      <title>@yield('title')@lang('glob.slogan')</title>
      <script type="text/javascript" src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('semantic/semantic.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('semantic/alert/Semantic-UI-Alert.js') }}"></script>
      <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
      <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>

      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('semantic/semantic.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('semantic/alert/Semantic-UI-Alert.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
      <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/dataTables.semanticui.min.css">
  </head>
  <body>
        @extends('layouts.navBar')
        @yield('content')
        
  </body>
</html>