<?php
    use Scrirock\Forum\Model\Manager\UserManager;
    include "../View/_partials/menu.view.php";
?>
<div id="containerHomePage">
    <?php
        if (isset($_SESSION["name"])){
            if ((new UserManager())->verifyAccount($_SESSION["name"])){
                echo "Un mail vous a été envoyé. Veuillez confirmer votre email";
            }
        }
    ?>
        <div id="scene">
        <div data-depth="0.5"><img src="./Asset/img/1.png" alt="test"></div>
        <div data-depth="0.4"><img src="./Asset/img/2.png" alt="test"></div>
        <div data-depth="0.3"><img src="./Asset/img/3.png" alt="test"></div>
        <div data-depth="0.2"><img src="./Asset/img/4.png" alt="test"></div>
        <div data-depth="0.1"><img src="./Asset/img/5.png" alt="test"></div>
    </div>
    <div id="addTopic">
        <p class="title">Ajouter un sujet</p>
        <p>
            Avant d'ajouter un sujet assurez vous qu'il n'existe pas déjà. Si vous n'avez pas encore lu le réglement
            il est vivement conseiller d'y jeter un oeil pour éviter tout problème.
        </p>
        <?php if (isset($_SESSION["name"]) && !(new UserManager())->verifyAccount($_SESSION["name"])){ ?>
            <a href="?controller=addTopic" class="button">Ajouter un sujet</a>
        <?php } else{ ?>
            <p>Connectez vous ou activez votre compte pour ajouter un sujet</p>
        <?php } ?>
    </div>

</div>

<?php include "../View/_partials/footer.view.php"; ?>