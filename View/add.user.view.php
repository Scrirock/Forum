<?php
include "../View/_partials/menu.view.php";

if(isset($_SESSION['error?'])){
    echo "<div id='error'>".$_SESSION['error?']."</div>";
    session_destroy();
    session_start();
}
else{
    session_destroy();
    session_start();
}
?>
<h1 class="littleTitle">S'inscrire</h1>

<form action="" method="POST" class="connexionForm">
    <div>
        <label for="username">Nom: </label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="mail">Email: </label>
        <input type="email" id="mail" name="mail">
    </div>
    <div>
        <label for="password">Mot de passe: </label>
        <input type="password" id="password" name="password">
    </div>
    <div>
        <input type="submit" value="S'inscrire">
    </div>
</form>

<?php include "../View/_partials/footer.view.php"; ?>