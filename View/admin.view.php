<?php include "../View/_partials/menu.view.php" ?>
<div id="containerAdminPage">
    <div id="addCategory">
        <span>Ajouter une catégorie</span><i id="plusIcon" class="far fa-plus-square"></i>
        <form action="" method="POST"></form>
    </div>
    <div id="log">
        <?php
            $file = fopen('../Log/log.log', 'rb');
            while ($log = fgets($file)){
                echo "<span class='logLine'>".nl2br($log)."</span>";
            }
            fclose($file);
        ?>
    </div>
</div>

<?php include "../View/_partials/footer.view.php"; ?>