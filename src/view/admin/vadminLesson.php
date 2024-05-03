<?php

$title = 'Admin View Select Lesson | PedaCode';

ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
    <main class="flex-1 flex flex-col gap-6 my-6">
        <h1 class="text-center text-primary-light-dm">Section Leçon</h1>
        <a href="<?= APP_ROOT ?>/adminChapter?categoryId=<?= $_GET['categoryId'] ?>" class="pl-3"> <i class="fa-solid fa-chevron-left"></i> Revenir en arriere</a>
        <h2 class="text-center">Liste des leçons</h2>
        <div class="flex flex-col justify-around items-center bg-primary-light-dm">
            <div class="selection my-6">
                <div class="selection-chapitre">
                    <label for="chapitre" class="text-nightsky-dark-dm">ID du chapitre :</label>
                    <select id="chapitre" name="chapitre" required>
                        <?php foreach ($chapters as $chapitre) { ?>
                            <option value="<?= $chapitre->getId() ?>" <?php if (isset($_GET['chapitreId']) && $_GET['chapitreId'] == $chapitre->getId()) echo 'selected'; ?> disabled> <?= $chapitre->getTitle() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <section id="gestionLesson" class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
                <?php foreach ($lessons as $lesson) { ?>
                    <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center ">
                        <span class=" text-center font-semibold "><?= $lesson->getTitleLes() ?> - [id : <?= $lesson->getIdLes() ?>]</span>
                        <div class=" flex flex-row items-center gap-2 ">
                            <a href="<?= APP_ROOT ?>/adminEditLesson?categoryId=<?= $_GET['categoryId'] ?>&chapitreId=<?= $_GET['chapitreId'] ?>&lessonId=<?= $lesson->getIdLes() ?>" class=" rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm ">Modifier</a>
                            <form class="mb-0" method="post" action="<?= APP_ROOT ?>/delLesson?categoryId=<?= $_GET['categoryId'] ?>&chapitreId=<?= $_GET['chapitreId'] ?>">
                                <input type="hidden" name="idDelLess" value="<?= $lesson->getIdLes() ?>">
                                <input type='hidden' name='action' value='delete'>
                                <button type="submit" class="rounded p-1 bg-red-500 text-white hover:text-gray-50 hover:bg-red-600 ">Supprimer</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </section>
        </div>
        <div class="flex justify-center my-6">
            <form action="<?= APP_ROOT ?>/addLesson?categoryId=<?= $_GET['categoryId'] ?>&chapitreId=<?= $_GET['chapitreId'] ?>" method="post">
                <input type="hidden" name="chapterId" value="<?= $_GET['chapitreId'] ?>">
                <label for="addLesson">Nom de la leçon : </label>
                <input type="text" name="addLesson" id="addLesson" class="text-nightsky-dark-dm">
                <button type="submit" class="rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm">Ajouter une leçon</button>
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