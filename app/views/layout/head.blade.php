<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

  @if(isset($widget) && Helpers::isOk($widget) && in_array('select', $widget))
  {{HTML::style('css/chosen.css')}}
  @endif

  {{HTML::style('css/ui-lightness/jquery-ui-1.10.4.custom.css')}}


  @if(isset($widget) && Helpers::isOk($widget) && in_array('upload', $widget))
  {{HTML::style('css/uploadfile.css')}}
  @endif

  {{HTML::style('css/style.css')}}

</head>