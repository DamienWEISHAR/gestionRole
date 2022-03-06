<?php

require_once "./models/MainManager.model.php";

class UtilisateurManager extends MainManager{

    private function getPasswordUser($login){
        $req = "SELECT password FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat['password'];

    }
   
    public function isCombinaisonValide($login, $password){
        $passwordBD = $this->getPasswordUser($login);
        return password_verify($password, $passwordBD); //si ça correspond, renvoie TRUE, sinon renvoie FALSE
    }
    
    public function estCompteActive($login){
        $req = "SELECT est_valide FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        //avec (int) je transforme le résultat pour avoir un int et pas une chaine de caractères
        return (int)$resultat['est_valide'] === 1;
    }

    public function getUserInformation($login){
        $req = "SELECT * FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat;
    }

    public function verifLoginDisponible($login){
        //comme c'est la même requête qu'au-dessus, on va l'appeler 
        $utilisateur = $this->getUserInformation($login);
        //test si elle est empty = login dispo, sinon on aura une erreur
        return empty($utilisateur);
    }

    public function bdCreerCompte($login, $passwordCrypte, $mail, $clef){
        $req = "INSERT INTO utilisateur (login, password, mail, est_valide, role, clef, image) 
        VALUES (:login, :password, :mail, 0, 'utilisateur', :clef, '')";
        $stmt = $this->getBdd()->prepare($req);
        $stmt ->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt ->bindValue(":password", $passwordCrypte, PDO::PARAM_STR);
        $stmt ->bindValue(":mail", $mail, PDO::PARAM_STR);
        $stmt ->bindValue(":clef", $clef, PDO::PARAM_INT);

    }
} 