<h1>coucou</h1>


<?php 
//parcours du tableau pour récupérer les valeurs (as $utilisateur)
foreach($utilisateurs as $utilisateur){
    echo $utilisateur['login']." - " .$utilisateur['mail'];
}
?>