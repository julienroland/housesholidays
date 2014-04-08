;(function() {
    "use strict";

    var sBasePath = 'http://localhost/pix/housesholidays/public/',
    oLang,
    upload_dir = sBasePath+'uploads/',
    propriete_dir = 'proprietes',
    $supprimerImage = $('.supprimerImage'),
    $calendar = $('.calendar'),
    $dispoPopup = $('.dispoPopup'),
    $overlay = $('.overlay'),
    $popup = $('.popup'),
    settingsUpload;

    webshims.polyfill('forms dom-support');

    $(function() {

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
    } );

       $('#addTarif').submit( function(e){
        e.preventDefault();
        addTarif( $(this) );
    } );

       $supprimerImage.on('click', function( e ){
        e.preventDefault();
        deleteImage( $(this) );

    });

       $('#addDispo').submit( function(e){
        e.preventDefault();
        addDispo( $(this) );
    });
       var hidePopup = function( ){

        $popup.fadeOut(function(){
            $overlay.fadeOut();
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
    console.log(between);
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

    showDatePopup(  $that.attr('data-date') ,e);

};
var showDatePopup = function( sParam, e){

    $overlay.show();
    $dispoPopup.css({
        left:e.pageX + 24,
        top:e.pageY - 50,
    }).fadeIn();
    $dispoPopup.find('.date_debut ').val( sParam );
       /* var dates = $(".date_fin").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: sParam,

        });*/
};
var toEuNumDate = function( $date ){

    var sSplit = $date.split('-');
    return sSplit['2']+'/'+sSplit['1']+'/'+sSplit['0'];

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
      url: sBasePath + 'addTarif',
      dataType: "json",
      success:function( oData ){

        if( $('#tarifTable').length == 0 ){

            $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td></tr></thead></table>');

        }
        else{

            $('#tarifTable').remove();
            $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td></tr></thead></table>');

        }

        for(var i in oData){
            if(oData[i].prix_weekend != null){var prix_weekend = oData[i].prix_weekend}else{var prix_weekend = ''}
                $('#tarifTable thead').after('<tr><td><div class="saison">'+oData[i].saison+'</div><div class="dates"><span class="debut">'+toEuShortDate(oData[i].date_debut)+'</span><span class="fin">'+toEuShortDate(oData[i].date_fin)+'</span></div></td><td>'+oData[i].prix_nuit+' '+oData[i].monnaie.icon+'</td><td>'+prix_weekend+'</td><td>'+oData[i].prix_semaine+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].prix_mois+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].duree_min+' '+oLang.form.nuit+'</td></tr>');

        }
    }
});


}
var visualReplacement = $('.chosen-container');

$(this).after(visualReplacement).hide();
            //bind the visual element to the API element
            webshims.addShadowDom(this, visualReplacement);
        });

    /**
    
        TODO:
        - ajouter au fichiers de lang les trucs du bas
        - Second todo item
    
        **/



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
            url: sBasePath + 'deleteImage/'+ $that.attr('data-id'),
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

                    $('#baseForm').after('<div id="images"><ul></ul></div>');

                }
                $('#images').find('li').remove();

            }
            for( var i in oData ){

                $('#images ul').append('<li><div class="image"><img src="'+ upload_dir + userId + '/' + propriete_dir + '/' + proprieteId + '/' + oData[i].url +'"></div><a href="" class="supprimerImage" data-id="'+oData[i].id+'" title="'+oLang.form.supp+'">'+oLang.form.supp_image+'</a></li>'); //userId/ProprieteId/

                $('.supprimerImage').on('click', function( e ){
                    e.preventDefault();
                    deleteImage( $(this) );

                });
            }

        }
    });

    }

}
   /**
   *
   * Param du plugins uploadFile
   *
   **/
   
   var uploadFile = function(){

    settingsUpload = $("#mulitplefileuploader").uploadFile({
        url: sBasePath + "ajax/uploadImage",
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