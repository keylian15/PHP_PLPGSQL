<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-card">
    <div class="w3-dropdown-hover">
      <button class="w3-bar-item w3-button logo">Bienvenue <?= $_SESSION['login']; ?></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="index.php" class="w3-bar-item w3-button">Accueil</a>
        <a href="#" class="w3-bar-item w3-button"><i><?= $_SESSION['user']['firstname'] .' '. $_SESSION['user']['lastname']; ?></i></a>
        <a href="delog.php" class="w3-bar-item w3-button"><i class="fa-solid fa-person-walking-arrow-right"></i> Se deconnecter</a>
      </div>
    </div>

    <?php
    $list_menus = array(
      'etudiants' => 'Les étudiants',
      'enseignants' => 'Les enseignants',
      'modules' => 'Les modules',
      'matieres' => 'Les matières',
      'epreuves' => 'Les épreuves',
    );

    foreach ($list_menus as $key => $menu) {
    ?>
      <div class="w3-dropdown-hover">
        <a href="index.php?element=<?= $key; ?>" class="w3-bar-item w3-button"><?= $menu; ?></a>
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
          <a href="index.php?element=<?= $key; ?>&action=list" class="w3-bar-item w3-button">Liste</a>
          <a href="index.php?element=<?= $key; ?>&action=add" class="w3-bar-item w3-button">Nouveau</a>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>