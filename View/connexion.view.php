<?php
include "../View/_partials/menu.view.php";
    if (isset($_SESSION['name'])){
        session_destroy();
        header("Location: /");
    }

    if(isset($_SESSION['error'])) {
        echo "<div id='error'>" . $_SESSION['error'] . "</div>";
        session_destroy();
        session_start();
    }
    else{
        session_destroy();
        session_start();
    }
?>
<div id="containerConnexionPage">
    <form action="" method="POST" class="connexionForm">
        <div>
            <label for="name">Nom: </label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="password">Mot de passe: </label>
            <input type="password" id="password" name="password">
        </div>
        <div id="inputSubmit"><input type="submit" value="Se connecter" id="validate"></div>
        <div><a href="?controller=addUser" id="inscription">Pas encore inscrit ?</a></div>
    </form>
</div>

<?php include "../View/_partials/footer.view.php"; ?>