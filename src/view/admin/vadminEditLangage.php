<!-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8802cd6801.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../../assets/css/output.css">
    <title>Admin Edit Langage | PedaCode</title>
</head>

<body class="flex flex-col min-h-screen"> -->
<?php

$title = 'Admin Edit Langage | PedaCode';

ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
    <main class="flex-1 flex flex-col gap-6 my-6">
        <h1 class="text-center text-primary-light-dm">Editer le Langage</h1>
        <a href="<?= APP_ROOT ?>/adminGlobal" class="pl-3"> <i class="fa-solid fa-chevron-left"></i> Revenir en arriere</a>
        <section id="editLangage" class="p-2 flex flex-row flex-wrap gap-4 justify-center items-center w-full bg-primary-regular-dm">
            <form action="<?= APP_ROOT ?>/adminUpdateLang?langId=<?= $langageId->getId() ?>" method="post">
                <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center  ">
                    <div>
                        <input type="text" name="edit_lang_name" id="edit_lang_name" value="<?= $langageId->getName() ?>">
                    </div>
                    <div>
                        <input type="text" name="edit_ext_name" id="edit_ext_name" value="<?= $langageId->getExtension() ?>">
                    </div>
                    <div>
                        <select name="lang_id" id="lang_id">
                            <option value="<?= $langageId->getId() ?>"><?= $langageId->getId() ?></option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary-light-dm m-auto p-2 rounded text-white hover:bg-primary-dark-dm ">Editer</button>
            </form>
        </section>
        <p class="text-center"><?= $message ?? 'Modifier votre langage' ?></p>
    </main>
</section>
<?php $content = ob_get_clean(); ?>
<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>
<?php require('./view/base.php'); ?>
