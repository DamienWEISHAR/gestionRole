<?php

require_once "./models/MainManager.model.php";

class UtilisateurManager extends MainManager{

    private function getPasswordUser($login){
        $req = "SELECT password FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];

    }
   
    public function isCombinaisonValide($login, $password){
        $passwordBD = $this->getPasswordUser($login);
        echo $passwordBD;
        return password_verify($password, $passwordBD); //si ça correspond, renvoie TRUE, sinon renvoie FALSE
    }
    

} 