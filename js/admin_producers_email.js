jQuery(document).ready(function(){

    jQuery('#Enregistrer').mousedown(function(){
        var email= jQuery('#email').val().trim();
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        if((email=="entre votre adresse e-mail")||(email==null)) {
            jQuery("#reponse").html("Entrez une adresse e-mail");
        }else if(reg.test(email)==false){
            jQuery("#reponse").html("Cette adresse e-mail n'est pas valide");
        }else{

        }
    });

    jQuery('#enregistrer').click(function(){
        var name = jQuery('#name').val().trim();
        var email = jQuery('#email').val().trim();
        var term_id = jQuery('#term_id').val().trim();

        if(name=='') jQuery('#name-error').show();
        else jQuery('#name-error').hide();

        if(email=='') jQuery('#email-error').show();
        else jQuery('#email-error').hide();

        if(term_id=='') jQuery('#term_id-error').show();
        else jQuery('#term_id-error').hide();

        if((name!='')&&(email!='')&&(term_id!='')) jQuery('form').submit();
    });

});