 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
{{HTML::script('js/jquery-ui-1.10.4.custom.min.js')}}
@if( isset($widget) && Helpers::isOk($widget) && in_array('tab', $widget)  )
<script> $( "#tabs" ).tabs();</script>

@endif
 @if( isset($widget) && Helpers::isOk($widget) && in_array('editor', $widget) )

 {{HTML::script('//tinymce.cachefly.net/4.0/tinymce.min.js')}}
 <script type="text/javascript">
  tinymce.init({
    selector: "textarea",
    height:350,
    plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "save table contextmenu directionality emoticons template paste textcolor"
    ],
  });
</script>
@endif

@if( isset($widget) && Helpers::isOk($widget) && in_array('select', $widget) )
{{HTML::script('js/chosen.jquery.js')}}
{{HTML::script('js/modernizr.js')}}
{{HTML::script('js/js-webshim/minified/polyfiller.js')}}
<script>webshims.polyfill('forms dom-support');</script>
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

@if(isset($widget) && Helpers::isOk($widget) && in_array('upload', $widget))
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
@if(isset($widget) && Helpers::isOk($widget) && in_array('sortable', $widget))
<script>
  $(function(){
    $("#sortable").sortable({
      stop: function(event, ui) {
        var data = {};

        $("#sortable li").each(function(i, el){
          var p = $(el).find('a').attr('data-id');
          data[p]=$(el).index()+1;
        });

        $("form > [name='image_order']").val(JSON.stringify(data));

      },
      create: function(event, ui) {
        var data = {};

        $("#sortable li").each(function(i, el){
          var p = $(el).find('a').attr('data-id');
          data[p]=$(el).index()+1;
        });

        $("form > [name='image_order']").val(JSON.stringify(data));

      }

    }).disableSelection();


  });
</script>
@endif

@if( isset($widget) && Helpers::isOk($widget) && in_array('carte', $widget)  )

{{HTML::script('js/carte.js')}}

@endif


{{HTML::script('js/admin.js')}}



{{HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js')}}

</body>
</html>