<?php
$title = 'Pedacode | Cursus';
ob_start();
include './view/inc/navbar.php';
$navbar = ob_get_clean();
?>
<?php ob_start(); ?>
<main class="flex-1 flex flex-col gap-6 my-6 ">
    <div class="flex flex-col w-screen">
        <h1 class="text-center text-primary-light-dm uppercase">Choisissez le module qui vous convient</h1>
        <div class="mb-16">
            <!-- Code block starts -->
                <div class=" mx-auto h-dvh">
                    <div class="container mx-auto">
                        <div class="lg:flex md:flex flex-1 sm:flex items-center xl:justify-center flex-wrap md:justify-around sm:justify-around lg:justify-around gap-4">
                            <a href="#" class="xl:w-1/3 sm:w-3/4 md:w-2/5 relative mt-16 mb-32 sm:mb-24 xl:max-w-sm lg:w-2/5">
                                <div class="rounded overflow-hidden shadow-md bg-white">
                                    <div class="absolute -mt-[30px] w-full flex justify-center">
                                        <div class="h-16 w-16">
                                            <img src="./../assets/img/html.png" alt="html logo" role="img" class=" object-cover h-full w-full shadow-md" />
                                        </div>
                                    </div>
                                    <div class="px-6 mt-16">
                                        <h1 class="font-bold text-3xl text-center mb-1">HTML</h1>
                                        <p class="text-center text-gray-600 text-base pt-3 font-normal">Le langage de balisage du web, ce qui permet de structurer et de decrire le contenu d'un site web.</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="xl:w-1/3 sm:w-3/4 md:w-2/5 relative mt-16 mb-32 sm:mb-24 xl:max-w-sm lg:w-2/5">
                                <div class="rounded overflow-hidden shadow-md bg-white">
                                    <div class="absolute -mt-[30px] w-full flex justify-center">
                                        <div class="h-16 w-16">
                                            <img src="./../assets/img/css.png" alt="html logo" role="img" class=" object-cover h-full w-full shadow-md" />
                                        </div>
                                    </div>
                                    <div class="px-6 mt-16">
                                        <h1 class="font-bold text-3xl text-center mb-1">CSS</h1>
                                        <p class="text-center text-gray-600 text-base pt-3 font-normal">Le langage de style permet de designer le visuel d'un site web et de le rendre plus jolie et conviviale.</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="xl:w-1/3 sm:w-3/4 md:w-2/5 relative mt-16 mb-32 sm:mb-24 xl:max-w-sm lg:w-2/5">
                                <div class="rounded overflow-hidden shadow-md bg-white">
                                    <div class="absolute -mt-[30px] w-full flex justify-center">
                                        <div class="h-16 w-16">
                                            <img src="./../assets/img/javaScript.png" alt="html logo" role="img" class=" object-cover h-full w-full shadow-md" />
                                        </div>
                                    </div>
                                    <div class="px-6 mt-16">
                                        <h1 class="font-bold text-3xl text-center mb-1">JAVASCRIPT</h1>
                                        <p class="text-center text-gray-600 text-base pt-3 font-normal">le langage de programmation du web, permet de rendre le contenu d'un site web plus interactif et dynamique.</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="xl:w-1/3 sm:w-3/4 md:w-2/5 relative mt-16 mb-32 sm:mb-24 xl:max-w-sm lg:w-2/5">
                                <div class="rounded overflow-hidden shadow-md bg-white">
                                    <div class="absolute -mt-[30px] w-full flex justify-center">
                                        <div class="h-16 w-16">
                                            <img src="./../assets/img/algo.png" alt="algo logo" role="img" class=" object-cover h-full w-full shadow-md" />
                                        </div>
                                    </div>
                                    <div class="px-6 mt-16">
                                        <h1 class="font-bold text-3xl text-center mb-1">ALGORITHME</h1>
                                        <p class="text-center text-gray-600 text-base pt-3 font-normal">l'algorithme permet de relier les instructions d'un programme avec des actions d'un ordinateur.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <!-- Code block ends -->
            <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->
        </div>
    </div>
</main>

<?php $content = ob_get_clean(); ?>


<?php
ob_start();
include './view/inc/footer.php';
$footer = ob_get_clean();
?>

<?php require('./view/base.php'); ?>