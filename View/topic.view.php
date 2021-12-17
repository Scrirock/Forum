<?php
    use Scrirock\Forum\Model\Manager\CategoryManager;
    use Scrirock\Forum\Model\Manager\UserManager;
    include "../View/_partials/menu.view.php";
?>
<div id="containerTopicPage">
    <?php if (isset($var["topic"])){ ?>
        <div id="topicContainer">
            <div class="oneLine">
                <p class="title"><?= $var["topic"]["tTitle"] ?></p>
                <?php
                if (isset($_SESSION["role"], $_SESSION["name"])){
                    if (!(new CategoryManager())->checkArchived(null, $var["topic"]["id"])
                        || $_SESSION["role"] === "admin"){
                    if ($_SESSION["role"] === "admin" || $_SESSION["role"] === "moderator"
                        || $_SESSION["name"] === $var["topic"]["pseudo"]){ ?>
                        <div class="icon">
                            <a href="?controller=archivedTopic&id=<?= $var["topic"]["id"] ?>" class="archived">
                                <?php
                                    if ($var["topic"]["close"]) echo "Ouvrir le sujet";
                                    else echo "Fermer le sujet";
                                ?>
                            </a>
                            <i class="far fa-edit edit"></i>
                            <a href="?controller=deleteTopic&id=<?= $var["topic"]["id"] ?>"><i class="far fa-trash-alt delete"></i></a>
                        </div>
                <?php }}} ?>
            </div>
            <p id="pseudo"><?= $var["topic"]["pseudo"] ?></p>
            <p class="contentT" data-id="<?= $var["topic"]["id"] ?>"><?= $var["topic"]["tContent"] ?></p>
            <form action="" method="POST"></form>
        </div>
    <?php } ?>

    <p id="commentaire">Commentaires</p>
    <div id="comment">
        <?php if (isset($var["comment"])){
            foreach ($var["comment"] as $comment){ ?>
                <div class="oneComment">
                    <div class="oneLine">
                        <div>
                            <p class="pseudo"><?= $comment["pseudo"] ?></p>
                            <?php
                            if (isset($_SESSION["role"], $_SESSION["name"])){
                                if (!(new CategoryManager())->checkArchived(null, $var["topic"]["id"])
                                    || $_SESSION["role"] === "admin"){
                                    if ($_SESSION["role"] === "admin"
                                        || $_SESSION["role"] === "moderator"
                                        || $_SESSION["name"] === $var["topic"]["pseudo"]){ ?>
                                        <div class="icon">
                                            <i class="far fa-edit edit"></i>
                                            <a href="?controller=deleteComment&cId=<?= $comment["cId"] ?>&tId=<?= $var["topic"]["id"] ?>"><i class="far fa-trash-alt delete"></i></a>
                                        </div>
                            <?php }}} ?>
                        </div>
                        <p class="date"><?= $comment["date"] ?></p>
                    </div>
                    <p class="content" data-id="<?= $comment["cId"] ?>"><?= $comment["cContent"] ?></p>
                    <form action="" method="POST"></form>
                </div><?php
            }
        }
        if (((isset($var["topic"]) && $var["topic"]["close"])
                || (new CategoryManager())->checkArchived(null, $var["topic"]["id"]))
                && $_SESSION["role"] !== "admin" ){
            echo "La section commentaire est fermée.";
        }
        else{
            if (isset($_SESSION["name"]) && !(new UserManager())->verifyAccount($_SESSION["name"])){
                ?>
                <div id="addComment">
                    <span>Ajouter un commentaire</span><i id="plusIcon" class="far fa-plus-square"></i>
                    <form action="" method="POST"></form>
                </div>
            <?php }
        }?>
    </div>
</div>

<?php include "../View/_partials/footer.view.php";?>