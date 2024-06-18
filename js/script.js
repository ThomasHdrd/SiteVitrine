$(function(){

$("#contact-form").submit(function(e) { //id: contact-form
    e.preventDefault(); //enlever le comportement quand je suis dans un formulaire
    $(".comment").empty(); //touts les messages à 0 lorsque je soumets en appuyant sur envoyer
    var postdata = $("#contact-form").serialize(); //les mettre dans une variable "postdata"

    $.ajax({
        type: "POST",
        url: "php/contact.php",
        data: postdata,
        dataType: "JSON",
        success: function(result) {
            
            if (result.isSuccess) {
                $("#contact-form").append("<p class='thank-you'>Votre message à bien été envoyé. Merci de m'avoir contacté </p>") ;
                $("#contact-form")[0].reset(); //si message envoyé alors reset tous les champs
            }
            else{
                $("#firstname + .comment").html(result.firstnameError); //sinon ceci me rendre firstnameError
                $("#name + .comment").html(result.nameError); //sinon ceci me rendre firstnameError
                $("#email + .comment").html(result.emailError); //sinon ceci me rendre firstnameError
                $("#phone + .comment").html(result.phoneError); //sinon ceci me rendre firstnameError
                $("#message + .comment").html(result.messageError); //sinon ceci me rendre firstnameError
            }
        }
    })

    });    
})

