;(function() {
    "use strict";

    var sBasePath = 'http://localhost/pix/housesholidays/public/',
    oLang,
    upload_dir = sBasePath+'uploads/',
    propriete_dir = 'proprietes',
    $supprimerImage = $('.supprimerImage'),
    settingsUpload;

    webshims.polyfill('forms dom-support');

    $(function() {

       getTraductions(  );

       if($('#inscription_etape4').length !== 0){

           uploadFile(  );

       }

       $('#addTarif').submit( function(e){
        e.preventDefault();
        addTarif( $(this) );
    } );

       $supprimerImage.on('click', function( e ){
        e.preventDefault();
        deleteImage( $(this) );

    });
       var toEuNumDate = function( $date ){
        var sSplit = $date.split('-');
        return sSplit['2']+'/'+sSplit['1']+'/'+sSplit['0'];
    };
    var toEuShortDate = function( $date ){

        var sSplit = $date.split('-');
        console.log(sSplit);
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
            console.log(oData);
            if( $('#tarifTable').length == 0 ){

                $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td></tr></thead></table>');

            }
            else{
                $('#tarifTable').remove();
                $('#addTarif').after('<table id="tarifTable"><thead><tr><td>'+oLang.form.tarif_1+'</td><td>'+oLang.form.tarif_2+'</td><td>'+oLang.form.tarif_3+'</td><td>'+oLang.form.tarif_4+'</td><td>'+oLang.form.tarif_5+'</td><td>'+oLang.form.tarif_6+'</td></tr></thead></table>');
            }

            for(var i in oData){
                
                $('#tarifTable thead').after('<tr><td><div class="saison">'+oData[i].saison+'</div><div class="dates"><span class="debut">'+toEuShortDate(oData[i].date_debut)+'</span><span class="fin">'+toEuShortDate(oData[i].date_fin)+'</span></div></td><td>'+oData[i].prix_nuit+' '+oData[i].monnaie.icon+'</td><td></td><td>'+oData[i].prix_semaine+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].prix_mois+' '+oData[i].monnaie.icon+'</td><td>'+oData[i].duree_min+' '+oLang.form.nuit+'</td></tr>');

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

    /**
    *
    * Get les régions en fonction du pays
    *
    **/
    $(".paysAjax").chosen().change( function(){

        loadChildSelect( 'pays', $(this) );

    });

    /**
    *
    * Get les sous_regions en fonction dde la region
    *
    **/

    $(".regionAjax").chosen().change( function(){

        loadChildSelect( 'region', $(this) );

    });

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
                console.log($(this));
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
        showStatusAfterSuccess:true,
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