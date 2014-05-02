;(function( $ ) {
  "use strict";
  /*http://localhost/pix/housesholidays/public*/
  var sBasePath = '/',
  oLang,
  upload_dir = sBasePath+'uploads/',
  propriete_dir = 'proprietes',
  $supprimerImage = $('.supprimerImage'),
  $calendar = $('.calendar'),
  $dispoPopup = $('.dispoPopup'),
  $dispoUpdatePopup = $('.dispoUpdatePopup'),
  $tarifUpdatePopup = $('.tarifUpdatePopup'),
  $overlay = $('.overlay'),
  $popup = $('.popup'),
  $updateTarif = $('.updateTarif'),
  $deleteTarif = $('.deleteTarif'),
  $linkOpAvance = $('.linkOpAvance'),
  $login = $('#login-trigger'),
  $loginContent = $('#login-content'),
  $refreshAnnonce = $('.refreshAnnonce'),
  settingsUpload;


  $(function() {

    $('#sendMessage').on('submit',function(e){
      e.preventDefault();
      sendMessage($(this));
    });

    $('#repondreMessage').on('submit',function(e){
      e.preventDefault();
      repondreMessage($(this));
    });

    $('.addFavoris').on('click', function(e){
      e.preventDefault();
      addFavoris( $(this) );
    } );

    $('.note_propriete input').on('change',function(){

      $(this).parent().siblings().removeClass('checked');

      if($(this).is(':checked')){

        $(this).parent().addClass('checked');
        $(this).parent().prevAll().addClass('checked');

      }

    });

    /**
    *
    * Inscription interieur valeur
    *
    **/
    $('.interieur input[type="checkbox"]').on('change', function(){
      toggleValeur($(this));
    });


    /**
    *
    * TABS
    *
    **/

    // tr
    $("#tab3 table tr:even").css( "background-color", "#ddd");
    $("#tab3 table tr td:first-child").css( "color", "#000");

  /*  $('#quisommesnous .tab_container div').hide();
    $('#quisommesnous .tab_container div:first').show();
    $('#quisommesnous ul li a:first').addClass('active');

    $('#quisommesnous ul.tabs li a').click(function(){
      $('#quisommesnous ul.tabs li a').removeClass('active');
      $(this).addClass('active');
      var currentTab = $(this).attr('href');
      $('#quisommesnous .tab_container div').hide();
      $('div#'+currentTab).show();
      $('div#'+currentTab+' div').show();
      return false;
    });*/

    /**
    *
    * LOGIN
    *
    **/
    
    $('#click_login').click(function(){
      $('#signup_int').hide();
      $('#forget_int').hide();  
      $('#signin_int').show();  
    });  

    $('#click_signup').click(function(){
      $('#signup_int').show();
      $('#signin_int').hide();  
      $('#forget_int').hide();  
    });

    $('#click_forget').click(function(){
      $('#signup_int').hide();
      $('#signin_int').hide();  
      $('#forget_int').show();  
    });    

    $login.on('click', function( e ){
      e.preventDefault();
      $loginContent.slideToggle();
    });
    $refreshAnnonce.on('click', function( e ){
      e.preventDefault();
      refreshAnnonce( $(this) );

    });

    /**
    *
    * END LOGIN
    *
    **/
    
    $linkOpAvance.on('click', function(e){
      e.preventDefault();
      displayNext( $(this) );
    });

    $updateTarif.on('click', function(e){
      e.preventDefault();
      var sId = $(this).attr('data-id');
      showUpdateTarifPopup( sId);
    });

    $deleteTarif.on('click', function(e){
      e.preventDefault();
      var sId = $(this).attr('data-id');
      deleteTarif( sId);
    });

    $overlay.on('click', function(e){
      e.stopPropagation();
      hidePopup($(this));
    } );

    getTraductions(  );

    if($('#inscription_etape4').length !== 0){

     uploadFile(  );

   }

   $calendar.on('click','a', function(e){
    e.preventDefault();
    showDispo( $(this) , e);
  });


   $('#addTarif').submit( function(e){
    e.preventDefault();
    addTarif( $(this) );
  } );

   $('#updateTarif').submit( function(e){
    e.preventDefault();
    updateTarif( $(this) );
  } );

   $supprimerImage.on('click', function( e ){
    e.preventDefault();
    deleteImage( $(this) );

  });

   $('#addDispo').submit( function(e){
    e.preventDefault();
    addDispo( $(this) );
  }); 
   $('#updateDispo').submit( function(e){
    e.preventDefault();
    updateDispo( $(this) );
  });
   $('#deleteDispo').submit( function(e){
    e.preventDefault();
    deleteDispo( $(this) );
  });
   var addFavoris  = function($that){

    var user = $that.attr('data-userId');

    var propriete = $that.attr('data-proprieteId');

    $.ajax({
      type: "get", 
      url: sBasePath + 'addFavoris/'+user+'/'+propriete,
      dataType: "json",
      success:function( oData ){
        console.log(oData);
        alert(oData);
      },
    });
  };
    var tableColors = function(){

      var $tr = $('.description_propriete').find('tr');

      $tr.each(function(i){

        if(i == 0 || i % 2 == 0){

          $(this).css('background-color','#DDDDDD');

        }

      });
    };
    tableColors();
    var toggleValeurs = function(  ){

      $.each($('input[type="checkbox"]'), function(){
        console.log('ok');
        if($(this).is(':checked')){
          $(this).parent().find('.valeur').show();

        }

      })
    };
    var sendMessage = function( $that ){

      $.ajax({
        type: "get", 
        url: sBasePath + 'envoyeMessage/',
        dataType: "json",
        data:$that.serialize(),
        success:function( oData ){
          $('#contact').append('<div class="errors">'+oData+'</div>');
          $('#cboxOverlay').click();
        },
      }).fail(function(error, text){
        $('#contact').append('<div class="errors"></div>');
        var data = JSON.parse(error.responseText);
        for( var i in data ){
          for( var e in data[i] ){

            $('#contact .errors').append(data[i][e]);

          }
          
        }


      });

    }; 
    var repondreMessage = function( $that ){

console.log($that.serialize());
      $.ajax({
        type: "get", 
        url: sBasePath + 'repondreMessage/',
        dataType: "json",
        data:$that.serialize(),
        success:function( oData ){
          $('#contact').append('<div class="errors">'+oData+'</div>');
          $('#cboxOverlay').click();
        },
      }).fail(function(error, text){
      


      });

    };
    var toggleValeur = function( $that ){

      if($that.is(':checked')){
        $that.parent().find('.valeur').show();

      }else{
        $that.parent().find('.valeur').hide().val('');
      }

    };
    var refreshAnnonce = function($that){
     $.ajax({
      type: "get", 
      url: sBasePath + 'refreshAnnonce/'+ $that.attr('data-id'),
      dataType: "json",
      success:function( oData ){
        console.log(oData);
        if(oData){

          alert(oData);
          return true;

        }else{

          alert(oData);
          return false;

        }

      }
    });

   }
   var appendTarif = function( oData ){

    if( $('#tarifTable').length == 0 ){

      $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td><td>'+oLang.form.actions+'</td></tr></thead></table>');

    }
    else{

      $('#tarifTable').remove();
      $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td><td>'+oLang.form.actions+'</td></tr></thead></table>');

    }

    for(var i in oData){
      if(oData[i].prix_weekend != null){var prix_weekend = oData[i].prix_weekend}else{var prix_weekend = ''}
        $('#tarifTable thead').after('<tr><td><div class="saison">'+oData[i].saison+'</div><div class="dates"><span class="debut">'+toEuShortDate(oData[i].date_debut)+'</span><span class="fin">'+toEuShortDate(oData[i].date_fin)+'</span></div></td><td>'+oData[i].prix_nuit+' '+oData[i].monnaie.icon+'</td><td>'+prix_weekend+'</td><td>'+oData[i].prix_semaine+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].prix_mois+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].duree_min+' '+oLang.form.nuit+'</td><td><a href='+sBasePath+'updateTarif data-id="'+oData[i].id+'" class="updateTarif">'+oLang.form.modifier+'</a> - <a href='+sBasePath+'deleteTarif class="deleteTarif" data-id="'+oData[i].id+'" >'+oLang.form.supprimer+'</a></td></tr>');

    }
    $('.updateTarif').on('click', function(e){
      e.preventDefault();
      var sId = $(this).attr('data-id');
      showUpdateTarifPopup( sId);
    });

    $('.deleteTarif').on('click', function(e){
      e.preventDefault();
      var sId = $(this).attr('data-id');
      deleteTarif( sId);
    });
  };
  var deleteTarif = function( sId ){

    $.ajax({
      type: "get", 
      url: sBasePath + 'deleteTarif/'+ sId,
      dataType: "json",
      success:function( oData ){

        appendTarif( oData );

      }
    });
  };
  var displayNext = function($that){
    $that.next('.opAvance').slideToggle();
  };
  var hidePopup = function( ){

    $popup.fadeOut(function(){
      $overlay.fadeOut();
    });

  };
  var deleteDispo = function( $that ){

    var $id = $that.find('.tarif_id').val();

    $calendar.find('a[data-id="'+ $id +'"]').removeAttr('data-id');

    $('.calendar').on('click','a', function(e){
      e.preventDefault();
      showDispo( $(this) , e);
    });

    var sData = $that.serialize();
    $.ajax({
      type: "get", 
      data:sData,
      url: sBasePath + 'deleteDispo',
      dataType: "json",
      success:function( oData ){

        $('.calendar td').removeClass('busy');

        for(var i in oData ){

          var between = [],
          start = oData[i].date_debut,
          currentDate = new Date(start),
          end = new Date(oData[i].date_fin);

          while (currentDate <= end) {
            var date = {};
            var today  = toPhpDate( currentDate );
            date['date'] = today;
            date['id'] = oData[i].id;
            between.push(date);
            currentDate.setDate(currentDate.getDate() + 1);
          }

          showDispoBusy( between );


        }

        hidePopup();
      }
    });
  };
  var updateTarif = function( $that ){

   var sData = $that.serialize();
   $.ajax({
    type: "get", 
    data:sData,
    url: sBasePath + 'updateTarif',
    dataType: "json",
    success:function( oData ){

      appendTarif( oData );
      hidePopup();
    }
  });
 };
 var updateDispo = function( $that ){

   var sData = $that.serialize();
   $.ajax({
    type: "get", 
    data:sData,
    url: sBasePath + 'updateDispo',
    dataType: "json",
    success:function( oData ){
      $('.calendar td').removeClass('busy');
      for(var i in oData ){

        var between = [],
        start = oData[i].date_debut,
        currentDate = new Date(start),
        end = new Date(oData[i].date_fin);

        while (currentDate <= end) {
          var date = {};
          var today  = toPhpDate( currentDate );
          date['date'] = today;
          date['id'] = oData[i].id;
          between.push(date);
          currentDate.setDate(currentDate.getDate() + 1);
        }

        showDispoBusy( between );

      }
      hidePopup();
    }
  });
 };
 var addDispo = function( $that ){

   var sData = $that.serialize();

   $.ajax({
    type: "get", 
    data:sData,
    url: sBasePath + 'addDispo',
    dataType: "json",
    success:function( oData ){
      $('.calendar td').removeClass('busy');
      for(var i in oData ){

        var between = [],
        start = oData[i].date_debut,
        currentDate = new Date(start),
        end = new Date(oData[i].date_fin);

        while (currentDate <= end) {
          var date = {};
          var today  = toPhpDate( currentDate );
          date['date'] = today;
          date['id'] = oData[i].id;
          between.push(date);
          currentDate.setDate(currentDate.getDate() + 1);
        }


        showDispoBusy( between );

      }
      hidePopup();
    }
  });
 };
 var showDispoBusy = function( between ){

  for( var i in between ){
    $('.calendar a[data-date="'+between[i].date+'"]').attr('data-id',between[i].id).parent().addClass('busy');

  }
};
var toPhpDate = function( jDate ){
  var dd = jDate.getDate();
  var mm = jDate.getMonth()+1;
  var yyyy = jDate.getFullYear();
  if(dd<10){dd='0'+dd}
    if(mm<10){mm='0'+mm}
      return dd+'-'+mm+'-'+yyyy;
  };
  var parseDate  = function(input, format) {
    format = format || 'yyyy-mm-dd'; 
    var parts = input.match(/(\d+)/g), 
    i = 0, fmt = {};
  // extract date-part indexes from the format
  format.replace(/(yyyy|dd|mm)/g, function(part) { fmt[part] = i++; });

  return new Date(parts[fmt['yyyy']], parts[fmt['mm']]-1, parts[fmt['dd']]);
}
var showDispo = function( $that, e ){

  if($that.attr('data-id') && $that.attr('data-id').length > 0){

    showUpdateDatePopup( $that.attr('data-id'), e );
  }
  else{

    showDatePopup(  $that.attr('data-date') ,e);

  }

};
var showUpdateTarifPopup = function( sId ){

 $.ajax({
   type: "get", 
   url: sBasePath + 'ajax/getOneTarif/'+sId,
   dataType: "json",
   success:function( oData ){

    $tarifUpdatePopup.find('.tarifId').val( oData.id );
    $tarifUpdatePopup.find('.weekendId').val( oData.tarif_special_weekend_id );

    $tarifUpdatePopup.find('select[name="monnaie"]').val( oData.monnaie_id );
    $tarifUpdatePopup.find('input[name="nom_saison"]').val( oData.saison );
    $tarifUpdatePopup.find('input[name="debut"]').val( toEuNumDate( oData.date_debut,'-') );
    $tarifUpdatePopup.find('input[name="fin"]').val( toEuNumDate( oData.date_fin,'-' ) );
    $tarifUpdatePopup.find('select[name="min_nuit"]').val( oData.duree_min );
    $tarifUpdatePopup.find('input[name="nuit"]').val( oData.prix_nuit );
    $tarifUpdatePopup.find('input[name="semaine"]').val( oData.prix_semaine );
    $tarifUpdatePopup.find('input[name="mois"]').val( oData.prix_mois );
    $tarifUpdatePopup.find('select[name="arrive_popup"]').val( oData.jour_arrive_id );
    $tarifUpdatePopup.find('.monnaie').html( oData.monnaie.icon );



    if( oData.tarif_speciaux_weekend !== "" &&  oData.tarif_speciaux_weekend !== null  || oData.prix_weekend!==null && oData.prix_weekend!=="" ){

      $tarifUpdatePopup.find('input[name="weekend_popup"]').attr('checked', true) ;

      $tarifUpdatePopup.find('input[name="prix_weekend_popup"]').val( oData.prix_weekend ) ;
      if( oData.tarif_speciaux_weekend !== "" &&  oData.tarif_speciaux_weekend !== null ){
        if( oData.tarif_speciaux_weekend.jour_semaine !== "" && oData.tarif_speciaux_weekend.jour_semaine!== null ){

          for( var i in oData.tarif_speciaux_weekend.jour_semaine ){

            $tarifUpdatePopup.find('input[name="jour_weekend_popup['+oData.tarif_speciaux_weekend.jour_semaine[i].id+']"]').attr('checked', true) ;

          }

        }

        if( oData.tarif_speciaux_weekend.max_nuit !=="" && oData.tarif_speciaux_weekend !==null ){

          $tarifUpdatePopup.find('input[name="duree_supp_popup"]').attr('checked', true);
          $tarifUpdatePopup.find('select[name="nuit_max_popup"] ').val( oData.tarif_speciaux_weekend.max_nuit );

        }
      }


    }
    else
    {

      $tarifUpdatePopup.find('.opAvance').hide();
    }

    $("select").trigger("chosen:updated");
    $overlay.show();
    var height = $tarifUpdatePopup.height();
    $tarifUpdatePopup.css({
      left:0,
      top:0 +  height/2,
    }).fadeIn();
    $tarifUpdatePopup.find('.date_debut ').val();
    $tarifUpdatePopup.find('.date_fin ').val();
    $tarifUpdatePopup.find('.tarif_id ').val();
  }
});


};
var showUpdateDatePopup = function( sId, e){
  $.ajax({
   type: "get", 
   url: sBasePath + 'ajax/getOneDispo/'+sId,
   dataType: "json",
   success:function( oData ){

    $overlay.show();
    var height = $dispoPopup.height();

    var top = checkPopupPosition( e.pageY - height/2 );
    $dispoUpdatePopup.css({
      left:e.pageX + 24,
      top:top,
    }).fadeIn();
    $dispoUpdatePopup.find('.date_debut ').val( toEuNumDate(oData.date_debut, '-') );
    $dispoUpdatePopup.find('.date_fin ').val( toEuNumDate(oData.date_fin, '-') );
    $dispoUpdatePopup.find('.tarif_id ').val( oData.id );
  }
});

};
var checkPopupPosition = function( $selector, data ){

 if( data  > 0){

  if( data > $(window).height() -  $selector.height()){

    return $(window).height()  -  $selector.height();

  }
  else
  {
    return data;
  }
}
else{

  return 0;

}


};
var showDatePopup = function( sParam, e){

  $overlay.show();

  var height = $dispoPopup.height();

  var top = checkPopupPosition( $dispoPopup, e.pageY - height/2 );

  $dispoPopup.css({
    left:e.pageX + 24,
    top:top,
  }).fadeIn();

  $dispoPopup.find('.date_debut ').val( sParam );


 /* $('body').on('focus',".date_fin", function(){
    $(this).datepicker({ minDate: -20 });
  });*/
$dispoPopup.find('.date_debut').datepicker({
  minDate: 0,
  numberOfMonths: 1,
  onSelect: function(selected) {
    $(".date_fin").datepicker("option","minDate", selected);
  }
});

$dispoPopup.find('.date_fin ').datepicker({ 
  dateFormat: "dd-mm-yy",
  minDate:parseDate( $(".date_debut").val(),"dd-mm-yyyy"),
  onSelect: function(selected) {
    $(".date_debut").datepicker("option","maxDate", selected);
  }
});

};
var toEuNumDate = function( $date, sSeprateur ){

  if(typeof sSeprateur === "undefined"){

    var sSeprateur = '/';
  }

  var sSplit = $date.split('-');
  return sSplit['2']+sSeprateur+sSplit['1']+sSeprateur+sSplit['0'];

};
var toEuShortDate = function( $date ){

  var sSplit = $date.split('-');

  var mois_id =parseInt(sSplit['1']);
  return parseInt(sSplit['2'])+' '+oLang.general.mois[mois_id]+' '+sSplit['0'];

};
var addTarif = function( $that ){

  var sData = $that.serialize();

  $.ajax({
    type: "get", 
    data:sData,
    url: sBasePath + 'addTarif/',
    dataType: "json",
    success:function( oData ){

     appendTarif( oData );
   }
 });


}
var visualReplacement = $('.chosen-container');

$(this).after(visualReplacement).hide();
            //bind the visual element to the API element
            webshims.addShadowDom(this, visualReplacement);
          });

$('.submit_form').click(function() {

  var validate = $("#myform").validationEngine('validate');
            var has_file = $(".ajax-file-upload-statusbar").length //check if there files need upload

            if(validate){

              if(has_file != false){

                settingsUpload.startUpload();

              }else{

                $('#myform').submit();

              }
            }
          });

/*$('#file').on('change', saveFile );*/

    /**
    *
    * Change le comportement du required pour fonctionner avec "chosen“
    *
    **/
    $('form').on('firstinvalid', function(e){
      webshims.validityAlert.showFor(e.target); 
            //remove native validation
            return false;
          });
    if($(".paysAjax").length !== 0){
    /**
    *
    * Get les régions en fonction du pays
    *
    **/
    $(".paysAjax").chosen().change( function(){

      loadChildSelect( 'pays', $(this) );

    });
  }
  if($(".regionAjax").length !== 0){
    /**
    *
    * Get les sous_regions en fonction dde la region
    *
    **/

    $(".regionAjax").chosen().change( function(){

      loadChildSelect( 'region', $(this) );

    });
  }
    /**
    *
    * Supprimer l'image 
    *
    **/
    
    var deleteImage = function( $that ){

      $.ajax({
        type: "get", 
        async:   false,
        url: sBasePath + 'deleteImage/'+ $that.attr('data-id')+'/'+$that.attr('data-proprieteId'),
        dataType: "json",
        success:function( oData ){

          if( oData ==='success'){
            $that.parent().fadeOut( 'fast', function(){
              $(this).remove();   
            });
          }
        }
      });
    }
    /**
    *
    * Chope tous les fichier de traductions 
    *
    **/
    var getTraductions = function(  ) {

     $.ajax({

      type: "get", 
      async:   false,
      url: sBasePath+'getAllLang',
      dataType: "json",
      success:function( oData ){
        oLang = oData;
        console.log(oData);
        return true;
      }
    });
   };
   var getProprietePhoto = function( userId, proprieteId ){

    if( userId && proprieteId ){

      $.ajax({
       type: "get", 
       url: sBasePath+'getPhotoPropriete/'+ proprieteId,
       dataType: "json",
       success:function( oData ){

        oData = oData.data;
        if( oData ){

          if($('#images').length == 0){

            $('#baseForm').after('<div id="images"><ul id="sortable" class="ui-sortable"></ul></div>');

          }
          $('#images').find('li').remove();

        }
        for( var i in oData ){

                $('#images ul').append('<li><div class="image"><img src="'+ upload_dir + userId + '/' + propriete_dir + '/' + proprieteId + '/' + oData[i].url +'"></div><a href="" class="supprimerImage" data-id="'+oData[i].id+'" data-proprieteId="'+proprieteId+'" title="'+oLang.form.supp+'">'+oLang.form.supp_image+'</a></li>'); //userId/ProprieteId/

                $('.supprimerImage').on('click', function( e ){
                  e.preventDefault();
                  deleteImage( $(this) );

                });

              }
              sortable();
            }

          });


}

}
var sortable = function(){

  $('#sortable').sortable({
   create: function(event, ui) {
    var data = {};

    $("#sortable li").each(function(i, el){
      var p = $(el).find('a').attr('data-id');
      data[p]=$(el).index()+1;
    });

    $("form > [name='image_order']").val(JSON.stringify(data));

  }
});

}
   /**
   *
   * Param du plugins uploadFile
   *
   **/
   
   var uploadFile = function(){

     var nProprieteId = $('form').attr('data-proprieteId');

     settingsUpload = $("#mulitplefileuploader").uploadFile({
      url: sBasePath + "ajax/uploadImage/"+nProprieteId,
      method: "post",
      allowedTypes:"jpg,gif,bmp",
      fileName: "file",
      autoSubmit:true,
      multiple:true,
      showStatusAfterSuccess:false,
      dragDropStr: "<span><b>"+oLang.form.dragDrop+"</b></span>",
      abortStr:oLang.form.abandonner,
      cancelStr:oLang.form.stop,
      doneStr:oLang.form.ok,
      multiDragErrorStr:oLang.form.multiDrag,
      extErrorStr:oLang.form.ext_pas_autorise,
      sizeErrorStr:oLang.form.taille_pas_autorise,
      uploadErrorStr:oLang.form.upload_pas_autorise,
      onSubmit:function(files)
      {
        $('<input>').attr({
          type: 'text',
          name: 'file[]',
          value: files
        }).appendTo('#myform');

      },

      onSuccess:function(files,data,xhr)
      {

        $('#myform').submit();

        getProprietePhoto( $('form').attr('data-userId'), $('form').attr('data-proprieteId') );
      },

      onError: function(files,status,errMsg)
      {
        /*console.log(files+'.'+status+'.'+errMsg);*/
        $("#status").html("<font color='green'>Something Wrong</font>");
      }

    });

}

    /**
    *
    * Append les enfants d'un select ex: pays -> région
    *
    **/
    var loadChildSelect = function( sType , that){

      var nId = Number(that.val());

      if( sType ==='pays'){

        $.ajax({
          type: "get", 
          url: sBasePath+'getDataSelect/region/pays/'+ nId,
          dataType: "json",
          success:function( jData ){

            if($('#region')){

              var $region = $('#region');

              $region.find('option').each( function(){

                $(this).remove();
              });

              $region.append('<option value="">'+oLang.form.enter_region+'</option');

              for(var i in jData ){

                $region.append('<option value="'+ jData[i].id+'">'+ jData[i].val +'</option');
              }

              $region.trigger("chosen:updated");
            }
          }
        });

        $.ajax({
          type: "get", 
          url: sBasePath+'getChildDataSelect/sousRegion/region/pays/null/'+ nId,
          dataType: "json",
          success:function( jData ){

            if($('#sous_region')){

              var $sousRegion = $('#sous_region');

              $sousRegion.find('option').each( function(){

                $(this).remove();
              });

              $sousRegion.append('<option value="">'+oLang.form.enter_sousRegion+'</option');

              for(var i in jData ){

                $sousRegion.append('<option value="'+ jData[i].id+'">'+ jData[i].val +'</option');
              }

              $sousRegion.trigger("chosen:updated");
            }
          },
          error:function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
          }
        });

      }else if( sType === 'region'){
        $.ajax({
          type: "get", 
          url: sBasePath+'getDataSelect/sousRegion/region/'+ nId,
          dataType: "json",
          success:function( jData ){

            if($('#region')){

              var $region = $('#sous_region');

              $region.find('option').each( function(){

                $(this).remove();
              });

              $region.append('<option value="">'+oLang.form.enter_sousRegion+'</option');

              for(var i in jData ){

                $region.append('<option value="'+ jData[i].id+'">'+ jData[i].val +'</option');
              }

              $region.trigger("chosen:updated");
            }
          }
        });
      }
    }; 
  }).call( this, jQuery );