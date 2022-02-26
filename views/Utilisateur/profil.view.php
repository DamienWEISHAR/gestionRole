<h1>Profil de <?= $utilisateur['login'] ?></h1>
<div id="mail">
    Mail : <?= $utilisateur['mail']; ?>
</div>
<!-- afficher le rôle de l'utilisateur -->
<?= $_SESSION['profil']['role']; ?>