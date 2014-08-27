;(function($){

    $(function(){
        $('.activerPropriete').on('click', activerPropriete );
        $('.desactiverPropriete').on('click', desactiverPropriete );

        $('.verifierPropriete').on('click', verifierPropriete );
        $('.deverifierPropriete').on('click', deverifierPropriete );
    });

    var activerPropriete =  function(e){
        e.preventDefault();
        $.ajax({
            url:'propriete/activer/'+ $(this).attr('data-id'),
            method: 'get',
            success: function(oData){
               if(oData.succes !== "undefined"){
                 alert(oData.success);
             }else{
                 alert(oData.error);
             }
         }

     })
    };
    var desactiverPropriete =  function(e){
        e.preventDefault();
        $.ajax({
            url:'propriete/desactiver/'+ $(this).attr('data-id'),
            method: 'get',
            success: function(oData){
                  if(oData.succes !== "undefined"){
                 alert(oData.success);
             }else{
                 alert(oData.error);
             }
            }

        })
    };

    var verifierPropriete =  function(e){
        e.preventDefault();
        $.ajax({
            url:'propriete/verifier/'+ $(this).attr('data-id'),
            method: 'get',
            success: function(oData){
                if(oData.succes !== "undefined"){
                 alert(oData.success);
             }else{
                 alert(oData.error);
             }
         },

     })
    };
    var deverifierPropriete =  function(e){
        e.preventDefault();
        $.ajax({
            url:'propriete/deverifier/'+ $(this).attr('data-id'),
            method: 'get',
            success: function(oData){
                  if(oData.succes !== "undefined"){
                 alert(oData.success);
             }else{
                 alert(oData.error);
             }
            }

        })
    };

}).call(this, jQuery);