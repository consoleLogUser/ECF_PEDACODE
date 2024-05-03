<?php

$title = 'Admin View Global | PedaCode';

ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>

<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
  <main class="flex-1 flex flex-col gap-6 my-6">
    <h1 class="text-center text-primary-light-dm">Gerez les Categories</h1>
    <section id="gestionCategories" class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
      <?php foreach ($categories as $cat) { ?>
        <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center  ">
          <span class=" text-center font-semibold "><?= $cat->getName() ?> - [id : <?= $cat->getId() ?>]</span>
          <div class=" flex flex-row items-center gap-2 ">
            <a href="<?= APP_ROOT ?>/adminChapter?categoryId=<?= $cat->getId() ?>" class=" rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm ">Voir</a>
            <a href="<?= APP_ROOT ?>/adminEditCat?categoryId=<?= $cat->getId() ?>" class="rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm">Editer</a>
            <form class="mb-0" method="post" action="<?= APP_ROOT ?>/adminGlobalDelCat" id="formulaireSupprimerCategorie">
              <input type='hidden' name='idCat' value='<?= $cat->getId() ?>'>
              <input type='hidden' name='actionCat' value='delete'>
              <button type="submit" class="rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm">Supprimer</button>
            </form>
          </div>
        </div>
      <?php } ?>

    </section>
    <section class="flex flex-col items-center gap-2">
      <h2>Ajouter une nouvelle categorie</h2>
      <form action="<?= APP_ROOT ?>/adminGlobalAjoutCat" method="post" class="flex flex-col gap-2" id="formulaireAjoutCategorie">
        <div class="title flex flex-col flex-wrap ">
          <label for="title">Titre de la categorie :</label>
          <input id="title" name="new_category_name" type="text">
        </div>
        <button type="submit" class="bg-primary-light-dm m-auto p-2 rounded text-white hover:bg-primary-dark-dm ">Ajouter</button>
      </form>
    </section>
    <hr>
    <!-- <section>
      <h2 class="text-center">Gerez les langages</h2>
      <section class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
        <?php foreach ($langages as $langage) { ?>
          <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center  ">
            <span class=" text-center font-semibold "><?= $langage->getName() ?> - [id : <?= $langage->getId() ?>] - [ext : <?= $langage->getExtension() ?>]</span>
            <div class=" flex flex-row items-center gap-2 ">
              <a href="<?= APP_ROOT ?>/adminEditLang?langId=<?= $langage->getId() ?>" class=" rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm ">Editer</a>
              <form class="mb-0" method="post" action= "<?= APP_ROOT ?>/adminGlobalDelLang" id="formulaireSupprimerLangage">
                <input type='hidden' name='idLang' value='<?= $langage->getId() ?>'>
                <button type="submit" class="rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm">Supprimer</button>
              </form>
            </div>
          </div>
        <?php } ?>
      </section>
      <section class="flex flex-col items-center gap-2">
        <h2 class="text-center mt-4">Ajouter un langage</h2>
        <form action= <?= APP_ROOT."/adminGlobalAjoutLang" ?> method="post" class="flex flex-col gap-2" id="formulaireAjoutLangage">
          <div class="title flex flex-col flex-wrap ">
            <label for="title">Titre du langage :</label>
            <input id="title" name="new_langage_name" type="text">
            <label for="ext">Extension du langage :</label>
            <input id="ext" name="new_langage_extension" type="text">
            <label for="new_langage_id">Id du langage :</label>
            <input id="new_langage_id" name="new_langage_id" type="number">
          </div>
          <button type="submit" class="bg-primary-light-dm m-auto p-2 rounded text-white hover:bg-primary-dark-dm ">Ajouter</button>
        </form>
      </section> -->

    </section>
  </main>
</section>
<?php $content = ob_get_clean(); ?>


<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>

<?php require('./view/base.php'); ?>