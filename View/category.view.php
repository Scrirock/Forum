<?php include "../View/_partials/menu.view.php"; ?>
<div id="containerCategoryPage">
        <?php if (isset($var["category"], $var["topic"])){
            foreach ($var["category"] as $category){ ?>
                <div class="category">
                    <div class="oneLine">
                        <p class="title"><?= $category["name"] ?></p>
                        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"){ ?>
                            <div>
                                <div class="icon">
                                    <i class="far fa-edit edit"></i>
                                    <a href="?controller=deleteCategory&id=<?= $category["id"] ?>"><i class="far fa-trash-alt delete"></i></a>
                                </div>
                                <a href="?controller=archived&id=<?= $category["id"] ?>" class="archived">
                                    <?php
                                    if ($category["archived"]) echo "Ouvrir la catégorie";
                                    else echo "Fermer la catégorie";
                                    ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="description">
                        <p class="test" data-id="<?= $category["id"] ?>"><?= $category["description"] ?></p>
                        <form action="" method="POST"></form>
                    </div>
                    <span class="show button">Voir les sujets <i class="far fa-caret-square-right"></i></span>
                    <div class="topic">
                        <?php foreach ($var["topic"] as $topic){
                            if ($topic["fk_category"] === $category["id"]){ ?>
                                <p>
                                    <i class="fas fa-hand-point-right"></i>
                                    <a href="?controller=topic&id=<?= $topic["id"] ?>" class="topicLink"><?= $topic["title"] ?></a>
                                </p>
                        <?php }
                        } ?>
                    </div>
                </div>
            <?php }
        }
    ?>
</div>
<?php include "../View/_partials/footer.view.php"; ?>