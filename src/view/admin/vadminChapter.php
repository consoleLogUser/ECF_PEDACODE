<?php

$title = 'Admin View Select Chapitre | PedaCode';

ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
    <main class="flex-1 flex flex-col gap-6 my-6">
        <h1 class="text-center text-primary-light-dm">Section Chapitre</h1>
        <a href="<?= APP_ROOT ?>/adminGlobal" class="pl-3"> <i class="fa-solid fa-chevron-left"></i> Revenir en arriere</a>
        <h2>Creer /Modifier un chapitre</h2>
        <div class="flex flex-col justify-around items-center bg-primary-light-dm">
            <div class="selection my-6">
                <div class="selection-categorie">
                    <label for="categorie" class="text-nightsky-dark-dm">Langage de programmation :</label>
                    <select id="categorie" name="categorie" required>
                        <?php foreach ($categories as $categorie) { ?>
                            <option value="<?= $categorie->getId() ?>" <?php if (isset($_GET['categoryId']) && $_GET['categoryId'] == $categorie->getId()) echo 'selected'; ?> disabled>
                                <?= $categorie->getName() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <section id="gestionChapitre" class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
                <?php foreach ($chapitres as $chapitre) { ?>
                    <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center ">
                        <span class=" text-center font-semibold "><?= $chapitre->getTitle() ?> - [id : <?= $chapitre->getId() ?>]</span>
                        <div class=" flex flex-row items-center gap-2 ">
                            <a href="<?= APP_ROOT ?>/adminLesson?categoryId=<?= $categoryId ?>&chapitreId=<?= $chapitre->getId() ?>" class=" rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm ">Voir</a>
                            <a href="<?= APP_ROOT ?>/adminEditChap?categoryId=<?= $categoryId ?>&chapitreId=<?= $chapitre->getId() ?>" class="rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm">Editer</a>
                            <form class="mb-0" method="post" action="<?= APP_ROOT ?>/adminChapterDelChap?categoryId=<?= $_GET['categoryId'] ?>">
                                <input type="hidden" name="idChap" value="<?= $chapitre->getId() ?>">
                                <button type="submit" class="rounded p-1 bg-red-500 text-white hover:text-gray-50 hover:bg-red-600 ">Supprimer</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </section>
            <form action="<?= APP_ROOT ?>/adminChapterAjoutChap?categoryId=<?= $categoryId ?>" method="post" class="flex flex-col justify-around items-center bg-primary-light-dm">
                <div class="selection-chapitre p-3">
                    <p class="text-nightsky-dark-dm">ID de la catégorie : <?= $categoryId ?></p>
                    <label for="newChapitre" class="text-nightsky-dark-dm">Nom du chapitre :</label>
                    <input type="text" id="newChapitre" name="newChapitre" placeholder="Nouveau chapitre" class=" text-nightsky-dark-dm">
                    <input type="hidden" name="categoryId" value="<?= $categoryId ?>">
                </div>
                <button id="saveButton" type="submit" class="bg-nightsky-dark-dm m-auto p-2 rounded text-white hover:bg-nightsky-light-dm ">Ajouter</button>
            </form>
        </div>
    </main>
</section>
<?php $content = ob_get_clean(); ?>
<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>
<?php require('./view/base.php'); ?>