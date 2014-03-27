;(function() {
    "use strict";

    var sBasePath = 'http://localhost/pix/housesholidays/public/',
    oLang;

    webshims.polyfill('forms dom-support');

    $(function() {

        getTraductions(  );

        var visualReplacement = $('.chosen-container');

        $(this).after(visualReplacement).hide();
            //bind the visual element to the API element
            webshims.addShadowDom(this, visualReplacement);
        });

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
    * Chope tous les fichier de traductions 
    *
    **/
    var getTraductions = function(  ) {

       $.ajax({

        type: "get", 
        url: sBasePath+'getAllLang',
        dataType: "json",
        success:function( oData ){
            oLang = oData;
        }
    });
   };

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