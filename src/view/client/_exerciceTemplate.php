<!DOCTYPE html>
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

  <title>Playground</title>

</head>

<body class="flex flex-col min-h-screen">
  
  <?php include './navbar.php' ?>

  <main class="flex-1">
    <header class="px-2 flex flex-row justify-between items-center">
      <select name="" id="langage-list" class="max-w-40">
        <option value="placeholder" selected disabled>Aller à l'exercice ...</option>
        <option value="">Exercice 1</option>
        <option value="">Exercice 2</option>
        <option value="">Exercice 3</option>
      </select>

      <h1 class="text-xl">HTML</h1>
      
      <div id="ellipsis-menu">
        <button popovertarget="data-modal"><i class="fa-solid fa-ellipsis-vertical fa-xl p-4 my-2 rounded-full  hover:text-primary-light-dm hover:bg-primary-dark-dm transition-colors"></i></button>
        <div popover id="data-modal" class="inset-[unset] right-0 top-28 p-3 shadow-2xl bg-nightsky-dark-dm">
          <button popovertarget="data-modal" popovertargetaction="hide" class="btn-default block w-full mx-auto">Réinitialiser</button>
          <button popovertarget="data-modal" popovertargetaction="hide" class="btn-default block w-full mx-auto">Sauver</button>
          <button popovertarget="data-modal" popovertargetaction="hide" class="btn-default block w-full mx-auto">Charger</button>
        </div>
      </div>
    </header>

    <div id="lesson" class="flex flex-col xl:flex-row mx-1">
      <div id="instructions" class="flex flex-col min-w-[35%] xl:max-h-[80vh] xl:overflow-y-scroll">
        <div id="description">
          <!-- TODO : les instructions & le nom de l'exercice seront ajoutées à la volée -->
          <p class="text-center py-1 bg-nightsky-regular-dm">Nom de l'exercice</p>
          <pre class="p-2">
La nature est belle et généreuse,
Elle nous offre des paysages merveilleux,
Des montagnes, des forêts, des océans, des déserts,
Des fleurs, des fruits, des animaux, des rivières,

La nature est aussi fragile et menacée,
Elle subit les conséquences de nos activités,
La pollution, le réchauffement, la déforestation, l'extinction,
Des fléaux qui mettent en péril sa diversité et sa fonction,

La nature est donc notre bien le plus précieux,
Elle mérite notre respect et notre attention,
Nous devons la protéger et la préserver,
Pour qu'elle puisse continuer à nous émerveiller.</pre>
        </div>
        <div id="goals">
          <p class="text-center py-1 bg-nightsky-regular-dm">Objectifs</p>
          <!-- TODO : les objectifs seront ajoutées à la volée dans le <p> -->
          <pre class="p-2">
La nature est belle et généreuse
Elle nous offre des paysages merveilleux
Des montagnes, des forêts, des océans, des déserts
Des fleurs, des fruits, des animaux, des rivières
La nature est belle et généreuse
Elle nous offre des paysages merveilleux
Des montagnes, des forêts, des océans, des déserts
Des fleurs, des fruits, des animaux, des rivières
La nature est belle et généreuse
Elle nous offre des paysages merveilleux
Des montagnes, des forêts, des océans, des déserts
Des fleurs, des fruits, des animaux, des rivières
</pre>
          <ul class="mt-4 p-2 bg-nightsky-regular-dm">
            <!-- TODO : les objectifs seront ajoutées à la volées dans les <li> -->
            <li class="mt-2 first:mt-0"><i class="fa-solid fa-circle-check "></i> Exemple d'objectif permettant de valider l'exercice.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Un autre exemple d'objectif que l'utilisateur doit valider.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Exemple objectif permettant de valider l'exercice.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Un autre exemple d'objectif que l'utilisateur doit valider.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Exemple objectif permettant de valider l'exercice.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Un autre exemple d'objectif que l'utilisateur doit valider.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Exemple objectif permettant de valider l'exercice.</li>
            <li class="mt-2"><i class="fa-solid fa-circle-check "></i> Un autre exemple d'objectif que l'utilisateur doit valider.</li>
          </ul>
          <button class="btn-default w-full mx-0">Tester le code</button>
        </div>
      </div>

      <div class="flex md:flex-row flex-col gap-1 w-full">
        <div id="editor" class="w-full h-[80vh]">function foo(items) {
          var i;
          for (i = 0; i &lt; items.length; i++) {
              alert("Ace Rocks " + items[i]);
          }
      }</div>
        <iframe id="output" class="w-full h-[80vh] bg-nightsky-regular-dm"></iframe>
      </div>
    </div>
  </main>

  <footer class="w-full flex flex-row flex-wrap justify-center items-center mt-6 gap-8 px-6 py-3 bg-nightsky-regular-dm">
    <a href="#">CGV</a>
    <a href="#">Mentions légales</a>
    <a href="#">CGU</a>
    <a href="#">Nous contactez</a>
  </footer>

  <script src="../../src-min/ace.js" type="text/javascript" charset="utf-8"></script>
  <script type="module" src="../../assets/js/playground.js"></script>

</body>
</html>