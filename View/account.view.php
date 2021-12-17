<?php include "../View/_partials/menu.view.php" ?>

<div id="containerAccountPage">
    <h1>Bonjour <?= $_SESSION["name"] ?></h1>
    <p>Modifier: </p>
    <form action="" method="POST"></form>
    <p class="pButton" id="pseudoButton">Son pseudo</p>
    <p class="pButton" id="passwordButton">Son mot de passe</p>
    <p id="premium">Devenir premium<a href="/?controller=paypal" class="button">Cliquer ici</a></p>
</div>

<?php include "../View/_partials/footer.view.php"; ?>