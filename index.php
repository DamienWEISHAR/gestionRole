<?php
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
"://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

require_once ("./controllers/Toolbox.class.php");
require_once ("./controllers/Securite.class.php");
require_once("./controllers/Visiteur/Visiteur.controller.php");
require_once("./controllers/Utilisateur/Utilisateur.controller.php");
$visiteurController = new VisiteurController();
$utilisateurController = new UtilisateurController();



try {
    if(empty($_GET['page'])){
        $page = "accueil";
    } else {
        $url = explode("/", filter_var($_GET['page'],FILTER_SANITIZE_URL));
        $page = $url[0];
    }

    switch($page){
        case "accueil" :   $visiteurController->accueil();
        break;
        case "login":    $visiteurController->login();
        break;
        case "validation_login":
            if(!empty($_POST['login']) && !empty($_POST['password'])){
                $login = Securite::secureHTML($_POST['login']);
                $password = Securite::secureHTML($_POST['password']);
                $utilisateurController->validation_login($login, $password);
            }else{
                Toolbox::ajouterMessageAlerte("Login ou MDP non renseigné", Toolbox::COULEUR_ROUGE);
                header('Location:' .URL. "login");
            }
        break;
        case "compte" : 
            switch($url[1]){
                case "profil": $visiteurController->accueil();
                break;
            }
        break;
        
        default : throw new Exception("La page n'existe pas");
    }
} catch (Exception $e){
    $visiteurController->pageErreur($e->getMessage());
}