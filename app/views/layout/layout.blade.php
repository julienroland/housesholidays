<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
  {{HTML::style('css/chosen.css')}}
  {{HTML::style('css/ui-lightness/jquery-ui-1.10.4.custom.css')}}
  {{HTML::style('css/uploadfile.css')}}
  {{HTML::style('css/main.css')}}
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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  
  @if( isset($widget) && Helpers::isOk($widget) && in_array('select', $widget) )
  {{HTML::script('js/chosen.jquery.js')}}

  <script>

    var config = {
      '.select'                : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.nb-select' : {disable_search_threshold:100},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    
  </script>
  @endif

  @if(isset($page) && $page ==='inscription_etape3')
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDTG91JrczloADLMwqPBbgPEGjOjOTX9o&sensor=false"></script>
  {{HTML::script('js/map.js')}}
  @endif
  @if( isset( $page ) && $page === 'inscription_etape4')
  <script>$('.baseFile').remove();</script>
  {{HTML::script('js/jquery.uploadfile.min.js')}}
  {{HTML::script('js/jquery.validationEngine.js')}}
  {{HTML::script('js/jquery.validationEngine-fr.js')}}
  @endif
  @if( isset($widget) && Helpers::isOk($widget) && in_array('datepicker', $widget) )
  <script>
    $(function() {
      $( ".date" ).datepicker({ dateFormat: "dd-mm-yy" } );
    });
  </script>
  @endif
  {{HTML::script('js/jquery-ui-1.10.4.custom.min.js')}}
  {{HTML::script('js/modernizr.js')}}
  {{HTML::script('js/js-webshim/minified/polyfiller.js')}}

  {{HTML::script('js/main.js')}}


  @if( isset($widget) && Helpers::isOk($widget) && in_array('tab', $widget)  )
  <script> $( ".tabs" ).tabs();</script>
  script>
  @endif



</body>
</html>