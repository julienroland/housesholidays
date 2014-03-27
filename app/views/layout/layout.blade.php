<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
  {{HTML::style('css/chosen.css')}}
	{{HTML::style('css/ui-lightness/jquery-ui-1.10.4.custom.css')}}
</head>
<body id="{{isset($page) ? $page : ''}}">

  {{link_to(Lang::get('routes.index'),trans('general.index'))}}

  @if(Auth::check())

  {{link_to(Lang::get('routes.deconnexion'),trans('general.deconnexion'))}}

  {{link_to_route('compte', trans('general.compte'),array(Auth::user()->slug))}}

  @else

  {{link_to(Lang::get('routes.inscription'),trans('general.inscription'))}}
  {{link_to(Lang::get('routes.connexion'),trans('general.connexion'))}}

  @endif
  @yield('container')

  {{HTML::script('js/jquery.js')}}
  {{HTML::script('js/jquery-ui-1.10.4.custom.min.js')}}

  {{HTML::script('js/chosen.jquery.js')}}
  {{HTML::script('js/modernizr.js')}}
  {{HTML::script('js/js-webshim/minified/polyfiller.js')}}
  {{HTML::script('js/main.js')}}


    <script> $( ".tabs" ).tabs();</script>

  <script>

    var config = {
      '.select'           		 : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.nb-select' : {disable_search_threshold:100},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    
  </script>

</body>
</html>