<?php

$title = 'Admin Update Lesson | PedaCode';


ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<section class="flex flex-col min-h-screen">
    <main class="flex-1 flex flex-col gap-6 my-6">
        <h1 class="text-center text-primary-light-dm">Modifier un cours</h1>
        <a href="<?= APP_ROOT ?>/adminLesson?categoryId=<?= $_GET['categoryId'] ?>&chapitreId=<?= $_GET['chapitreId'] ?>" class="pl-3"> <i class="fa-solid fa-chevron-left"></i> Revenir en arriere</a>
        <form action="<?= APP_ROOT ?>/updateLesson?categoryId=<?= $_GET['categoryId'] ?>&chapitreId=<?= $_GET['chapitreId'] ?>&lessonId=<?= $_GET['lessonId'] ?>" method="post" class="flex flex-col justify-around items-center bg-primary-light-dm">
            <div class="flex flex-wrap text-white gap-4 justify-around my-6 ">
                <div class="selection-langage">
                    <label for="category" class="text-nightsky-dark-dm">La categorie est :</label>
                    <select id="category" name="category">
                        <?php foreach ($categories as $categorie) { ?>
                            <option value="<?= $categorie->getId() ?>" <?php if (isset($_GET['categoryId']) && $_GET['categoryId'] == $categorie->getId()) echo 'selected'; ?> disabled> <?= $categorie->getName() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="selection-chapitre">
                    <label for="chapitre" class="text-nightsky-dark-dm">Nom Chapitre :</label>
                    <select id="chapitre" name="chapitre">
                        <?php foreach ($chapters as $chapitre) { ?>
                            <option value="<?= $chapitre->getId() ?>" <?php if (isset($_GET['chapitreId']) && $_GET['chapitreId'] == $chapitre->getId()) echo 'selected'; ?> disabled> <?= $chapitre->getTitle() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="selection-lesson">
                    <label for="title-lesson" class="text-nightsky-dark-dm">Nom Leçon :</label>
                    <input type="text" name="title-lesson" id="title-lesson" class="text-nightsky-dark-dm" required value="<?= $lesson->getTitleLes() ?>">
                </div>
                <!-- <div class="selection-date">
                    <label for="date" class="text-nightsky-dark-dm">Dèrniere modification : </label>
                    <input type="date" name="date" id="date" required class=" text-nightsky-dark-dm">
                </div> -->
                <div class="selection-abonnement">
                    <input type="checkbox" name="abonnement" id="abonnement" <?= $abonnementChecked ?>>
                    <label for="abonnement" class="text-nightsky-dark-dm">Abonnement nécessaire</label>
                </div>

            </div>
            <div class="flex flex-wrap text-white gap-4 justify-around w-full">
                <div class="w-full">
                    <div class=" w-full flex flex-col items-center justify-center">
                        <label for="instruction" class="text-nightsky-dark-dm">Instruction :</label>
                        <textarea name="instruction" id="instruction" rows="10" class="text-nightsky-dark-dm w-[90%]" required><?= $selectedInstruction ?></textarea>
                    </div>

                            

                    <!-- <div class="w-full flex flex-col items-center justify-center">
                        <label for="objectif" class="text-nightsky-dark-dm">Objectif :</label>
                        <textarea name="objectif" id="objectif" rows="10" class="text-nightsky-dark-dm w-[90%]" >
<?php foreach ($goals as $goal) {
    echo $goal->getDescrGoal() . "\n";
} ?></textarea>
                    </div> -->



                </div>
                <div class="w-full  ">
                    <p class="text-nightsky-dark-dm text-center">Data Code :</p>
                    <div class="flex flex-col items-center justify-center">
                        <div id="editor" class="w-full max-w-[90%] h-[350px]"></div>
                    </div>
                </div>
            </div>
            <div class="button my-6">
                <button id="submit" class="bg-nightsky-dark-dm m-auto p-2 rounded text-white hover:bg-nightsky-light-dm ">Soumettre</button>
            </div>
        </form>
    </main>
</section>
<p><?= $message ?? '' ?></p>
<script type="module" src="../assets/js/adminCreate.js"></script>
<script src="../src-min/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="../src-min/ext-language_tools.js"></script>
<?php $content = ob_get_clean(); ?>
<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>
<?php require('./view/base.php'); ?>

<!-- <script type="module" src="../../assets/js/adminCreate.js"></script>
</body>

</html> -->