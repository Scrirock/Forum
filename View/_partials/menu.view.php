<nav>
    <i class="fas fa-bars" id="menuBar"></i>
    <div id="logoMenu">
        logo
    </div>
    <div id="leftMenu">
        <a href="/"><div class="menu"><div class="underline"></div>Accueil</div></a>
        <a href="?controller=rules"><div class="menu"><div class="underline"></div>Réglement</div></a>
        <a href="?controller=category"><div class="menu"><div class="underline"></div>Catégories</div></a>
        <?php if(isset($_SESSION['role']) && ($_SESSION['role'] === "admin" || $_SESSION['role'] === "moderator")){ ?>
            <a href="?controller=admin"><div class="menu"><div class="underline"></div>Admin panel</div></a>
        <?php } ?>
    </div>
    <div id="rightMenu">
        <?php if (isset($_SESSION["name"])){ ?>
            <a href="?controller=myAccount"><div class="menu" id="barre"><div class="underline"></div>Mon profil</div></a>
        <?php } ?>
        <a href="?controller=connexion">
            <div>
                <div class="button">
                    <?php
                        if (isset($_SESSION['name'])) echo "Déconnexion";
                        else echo "Connexion";
                    ?>
                </div>
            </div>
        </a>
    </div>
</nav>