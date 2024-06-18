<?php 
    
    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "",  "message" => "", 
    "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "",  "messageError" => "", "isSuccess" => false);
    $emailTo = "thomas.houdard.98@gmail.com"; //a qui on envoi l'email


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        array["firstname"] = verifyInput($_POST["firstname"]); //recuperer les informations
        array["name"] = verifyInput($_POST["name"]);
        array["email"] = verifyInput($_POST["email"]);
        array["phone"] = verifyInput($_POST["phone"]);
        array["message"] = verifyInput($_POST["message"]);
        array["isSuccess"] = true;
        $emailText = "";

        if (empty(array["firstname"])) {
            array["firstnameError"] = "Je veux connaitre ton prénom";
            array["isSuccess"] = false;
        }
        else   
            $emailText .= "FirstName : {$array['firstname']}\n"; //\n = sauter une ligne

        if (empty(array["name"])) {
            array["nameError"] = "Je veux connaitre ton nom";
            array["isSuccess"] = false;
        }
        else   
            $emailText .= "Name :  {$array['name']}\n";

        if (empty(array["message"])) {
            array["messageError"] = "Tu veux me dire quoi ?";
            array["isSuccess"] = false;
        }
        else   
        $emailText .= "Message : {$array["message"]}\n";

        if (!isEMail(array["email"])) { //si ce n'est pas un email valid = false
            array["emailError"] = "Ce n'est pas un email";
            array["isSuccess"] = false;
        }
        else   
            $emailText .= "Email : $ {$array["email"]}\n";

        if (!isPhone(array["phone"])) { //si ce n'est pas un phone valid = false
            array["phoneError"] = "Ce n'est pas un numéro de téléphone";
            array["isSuccess"] = false;
        }
        else   
            $emailText .= "Phone : $ {$array["phone"]}\n";

        if (array["isSuccess"]) { //message de remerciement
            $headers = "From:  {$array["firstname"]}  {$array["name"]} < {$array["email"]}>\r\nReply-to: {$array["email"]}"; //reply-to : répondre à l'email qui nous l'a envoyé
            mail($emailTo, "Un message de votre site", $emailText, $headers);//Envoi de l'email. header : info de l'user
        }

        echo json_encode($array);
    }

    //EMAIL
    function isEmail($var){ 
        return filter_var($var, FILTER_VALIDATE_EMAIL); //comparer a un filtre d'email (avec un @ et .com oui .fr)
    }

    //PHONE
    function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var); //0-9 = chiffre en 0 et 9 ou espace. * = n'importe quelle combinaison 
    }

    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var); //enlever tous les anti slash
        $var = htmlspecialchars($var);

        return $var;
    }
?>