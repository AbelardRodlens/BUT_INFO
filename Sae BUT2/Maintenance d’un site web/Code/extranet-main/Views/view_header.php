<!-- Vue stockant le header personnalisé pour chaque fonction -->
<header>

<div class="barre">
<div class="logo"><img src="Content/images/logo.png"></div>
<div class="sep"></div>
  <nav>
        <?php if (isset($menu)): ?>
            <ul class="menu-list">
                <?php foreach ($menu as $m): ?>
                    <li>
                    
                    <a href=<?= $m['link'] ?>>
                    <?= $m['icon'] ?>
                    <?= $m['name'] ?>
                  
                  </a>
                  </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </nav>
</div>
</header>

<div class="profil">
  
            <a href="?controller=<?= $_GET['controller'] ?>&action=infos" class='droite'>
            <i class="fa fa-user-circle" ></i>

            <div class="nom">
            <p><?php if (isset($_SESSION)): echo $_SESSION['nom']; endif; ?></p>
            <p><?php if (isset($_SESSION)): echo $_SESSION['prenom']; endif; ?></p>
            </div>

            </a>

            <a href="?controller=login" class="gauche">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a>
</div>

