<?php session_start() ; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice individuel php</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Praise&display=swap" rel="stylesheet">
</head>

<body>

    <?php 
        //j'initialise la variable explanation à vide
        $explanation = "" ;

        //je checke si qqe chose est rempli dans le formulaire
        $inputGettingFilled = isset($_POST['first_name']) ;

        //j'initialise la variable session['connected_id] à vide s'il n'y a rien dans 'session'
        if(empty($_SESSION)){
            $_SESSION['connected_user'] = NULL ;
            $statusSession = $_SESSION['connected_user'] ; 
        }elseif (!empty($_SESSION)){
            $statusSession = $_SESSION['connected_user'] ;
        };
         
        //si un name_user existe dans l'url et pas dans le formulaire ni dans la session
        //je remplace la valeur de name_user par celui de l'url
        if ((isset($_GET['first_name'])) && (!$inputGettingFilled) && ($statusSession == NULL)){
            $name_url = $_GET['first_name'] ; 
            $name_user = $name_url ;
            $explanation = "We know you from the URL." ;
        //je rempli avec l'input du formulaire si la session est vide
        //et j'initialise la session avec cette valeur
        } elseif ($inputGettingFilled && ($statusSession == NULL )){
            $name_from_input = $_POST['first_name'] ; 
            $_SESSION['connected_user'] = $name_from_input ;
            $name_user = $_SESSION['connected_user'] ;
            $explanation = "You are now known as " . $name_user . ". If it's not you, please restart the session." ;
        } elseif ($inputGettingFilled && ($statusSession != NULL )){
            $name_user = $_SESSION['connected_user'] ;
            $explanation = "You are known as " . $name_user . ". If it's not you, please restart the session." ; 
        //si aucune info n'est présente, name_user est "anonyme"
        } else {
            $name_user = "anonyme" ;
            $explanation = "";
        }

        //je clean la session si le bouton restart session est clické et si la session n'est pas null
        if(isset($_POST['restart']) && $_SESSION['connected_user'] != NULL){
            unset($_SESSION);
            $_SESSION = array();
            session_destroy();
            $name_user = "anonyme" ;
            $explanation = "Session has been cleaned." ;
        } elseif (isset($_POST['restart']) && ($_SESSION['connected_user'] == NULL)) {
            $explanation = "Can't clean something already empty." ; 
        } ; 

    ?>

    <div class="container">
        <div class="trucContenu">
            <div>
                <!-- j'affiche un message de bienvenue qui s'adapte en fonction de la valeur de name_user -->
                <h1>Henlo <?php echo $name_user ?> !</h1>
            </div>

            <!-- formulaire qui permet au user de renseigner son prénom -->
            <form action="exercice.php" method="post">
                <p>What's your name ? <input type="texte" name="first_name" class="input"/></p>
                <p><input type="submit" value="I want my greetings !" class="button-56" role="button"></p>
                <p><input type="submit" name ="restart" value="Restart session" class="button-56" role="button"></p>
            </form>

            <div>
                <p><?php echo $explanation ?></p>
            </div>
        </div>
    </div>

</body>
</html>