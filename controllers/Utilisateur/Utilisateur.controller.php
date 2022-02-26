<?php
require_once "./controllers/MainController.controller.php";
require_once "./models/Utilisateur/Utilisateur.model.php";

class UtilisateurController extends MainController{


    private $utilisateurManager;

    public function __construct(){
        $this->utilisateurManager = new UtilisateurManager();
    }

    public function validation_login($login, $password){
        //test
        if($this->utilisateurManager->isCombinaisonValide($login, $password)){
            if($this->utilisateur->estCompteActive($login)){

            }else{
                Toolbox::ajouterMessageAlerte("Compte ".$login."n'a pas été validé par mail", Toolbox::COULEUR_ROUGE);
                //renvoyer mail de validation
                header('Location:' .URL."login");
            }
        }else{
            Toolbox::ajouterMessageAlerte("Login ou Mot de passe invalide", Toolbox::COULEUR_ROUGE);
            header('Location:' .URL."login");
        }
    }

    //récupération de la fonction protected pageErreur dans la classe parent/mère
    //donc obligé de refaire une fonction qui appelle cette fonction-là
    public function pageErreur($msg){
        parent::pageErreur($msg);
    }
}