<?php

$title = 'Admin Edit Categorie | PedaCode';

ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
    <main class="flex-1 flex flex-col gap-6 my-6">
        <h1 class="text-center text-primary-light-dm">Editer la Categorie</h1>
        <a href="<?= APP_ROOT ?>/adminGlobal" class="pl-3"> <i class="fa-solid fa-chevron-left"></i> Revenir en arriere</a>
        <section id="editCategorie" class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
            <form action="<?= APP_ROOT ?>/adminEditCat?categoryId=<?= $category->getId() ?>" method="post" >
                <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center  ">
                    <div>
                        <input type="text" name="edit_category_name" id="edit_category_name" value="<?= $newGategoryName ??$category->getName() ?>">
                    </div>
                    <div>
                        <select name="category_id" id="category_id">
                            <option value="<?= $category->getId() ?>"><?= $category->getId() ?></option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary-light-dm m-auto p-2 rounded text-white hover:bg-primary-dark-dm ">Editer</button>
            </form>
        </section>
        <p class="text-center"><?= $message ?? 'Modifier votre categorie' ?></p>
    </main>
</section>
<?php $content = ob_get_clean(); ?>
<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>
<?php require('./view/base.php'); ?>