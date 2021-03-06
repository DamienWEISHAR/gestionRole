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
            //test compte actif ou pas?
            if($this->utilisateurManager->estCompteActive($login)){
                Toolbox::ajouterMessageAlerte("Bon retour sur le site ".$login."!", Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    "login" => $login,
                    // "role" => $role
                ];
                header('Location:'.URL."compte/profil");
            }else{
                Toolbox::ajouterMessageAlerte("Compte ".$login." n'a pas été validé par mail", Toolbox::COULEUR_ROUGE);
                //renvoyer mail de validation
                header('Location:' .URL."login");
            }
        }else{
            Toolbox::ajouterMessageAlerte("Login ou Mot de passe invalide", Toolbox::COULEUR_ROUGE);
            header('Location:' .URL."login");
        }
    }

    public function profil(){
        //récupération des infos d'un utilisateur
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
        $_SESSION['profil']['role']=$datas['role'];
        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page de profil",
            "utilisateur" => $datas,
            "view" => "views/Utilisateur/profil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }


    public function deconnexion(){
        Toolbox::ajouterMessageAlerte("Déconnexion réussie", Toolbox::COULEUR_ORANGE);
        unset($_SESSION['profil']);
        header('Location:'.URL."accueil");
    }

        public function validation_creerCompte($login, $password, $mail){
            //test de vérification: login déjà présent en bdd?
            if($this->utilisateurManager->verifLoginDisponible($login)){
                //hachage du password
                $passwordCrypte=password_hash($password, PASSWORD_DEFAULT);
                $clef = rand(0,9999);
                //vérification si compte a été créé
                if($this->utilisateurManager->bdCreerCompte($login, $passwordCrypte, $mail, $clef)){

                }else{
                    Toolbox::ajouterMessageAlerte("Login déjà utilisé", Toolbox::COULEUR_ROUGE);
                header('Location:'.URL."creerCompte");
                }
            }else{
                Toolbox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencez svp!", Toolbox::COULEUR_ROUGE);
                header('Location:'.URL."creerCompte");
            }
        }

    //récupération de la fonction protected pageErreur dans la classe parent/mère
    //donc obligé de refaire une fonction qui appelle cette fonction-là
    public function pageErreur($msg){
        parent::pageErreur($msg);
    }
}