<?php include "../View/_partials/menu.view.php" ?>
<div id="containerTopicForm">
    <form action="" method="POST">
        <div>
            <label for="title">Titre: </label>
            <input type="text" name="title" id="title">
            <label for="category">Catégorie: </label>
            <select name="category" id="category"></select>
        </div>
        <label for="content">Votre message: </label><br>
        <textarea name="content" id="content" cols="60" rows="20"></textarea>
        <input type="submit" value="Ajouter" id="submitTopic">
    </form>
</div>

<?php include "../View/_partials/footer.view.php"; ?>