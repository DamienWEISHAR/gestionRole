<?php
require_once "./controllers/MainController.controller.php";
require_once "./models/Visiteur/Visiteur.model.php";

class VisiteurController extends MainController{


    private $visiteurManager;

    public function __construct(){
        $this->visiteurManager = new VisiteurManager();
    }

    //Propriété "page_css" : tableau permettant d'ajouter des fichiers CSS spécifiques
    //Propriété "page_javascript" : tableau permettant d'ajouter des fichiers JavaScript spécifiques
    public function accueil(){
        // Toolbox::ajouterMessageAlerte("test", Toolbox::COULEUR_VERTE);
        

        //récupérer les utilisateurs
        $utilisateurs = $this->visiteurManager->getUtilisateurs();
        
        /* ce tableau est transféré dans genererPage (MainController.php) 
        qui va créer des variables à partir de chacun des clefs du tableau */
        $data_page = [
            "page_description" => "Description de la page d'accueil",
            "page_title" => "Titre de la page d'accueil",
            "utilisateurs" => $utilisateurs,
            "view" => "views/Visiteur/accueil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //préparer les informations qui seront affichées à l'écran
    public function login(){
        $data_page = [
            "page_description" => "Page de connexion",
            "page_title" => "Page de connexion",
            "view" => "views/Visiteur/login.view.php",
            "template" => "views/common/template.php"
        ];
        ///pour utiliser toutes ces infos dans le template:
        $this->genererPage($data_page);
    }

    //récupération de la fonction protected pageErreur dans la classe parent/mère
    //donc obligé de refaire une fonction qui appelle cette fonction-là
    public function pageErreur($msg){
        parent::pageErreur($msg);
    }
}