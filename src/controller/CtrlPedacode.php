<?php

declare(strict_types=1);

namespace pedacode\controller;

use pedacode\dao\DaoPedacode;
use pedacode\controller\Message;
use pedacode\controller\CtrlAuth;
use pedacode\metier\DataCode;
use pedacode\metier\Langage;
use pedacode\metier\Workspace;
use pedacode\metier\Category;
use pedacode\metier\Chapter;
use pedacode\metier\Goal;
use pedacode\metier\Lesson;

class CtrlPedacode
{

    public const MAX_SAVE_SLOTS = 8;
    public const EMPTY_SLOT = "- Emplacement vide -";

    public function __construct(
        private DaoPedacode $daoPedacode = new DaoPedacode(),
    ) {
    }

    public function getIndex() {
        require './view/vindex.php';
    }

    public function getLogin() {
        

        // user connecté ? redirection vers mon compte
        if (isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/my-account');
            exit();
        }

        $msg = '';

        if (isset($_POST['pseudo']) && isset($_POST['password'])) {
            $ctrlAuth = new CtrlAuth();
            $ctrlAuth->connectUserAccount($_POST['pseudo'], $_POST['password'], $this->daoPedacode);
            if (isset($_SESSION['is-logged'])) {
                header('Location: ' . APP_ROOT . '/my-account');
                exit();
            }
            else {
                $msg = $ctrlAuth->getMessage();
            }
        }

        require './view/client/vinterfaceConnexion.php';
    }

    public function getCreateAccount() {
        

        // user connecté ? redirection vers mon compte
        if (isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/my-account');
            exit();
        }

        $msg = '';

        if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
            $ctrlAuth = new CtrlAuth();
            
            $isCreated = $ctrlAuth->createUserAccount($_POST['pseudo'], $_POST['email'], $_POST['password'], $this->daoPedacode);
            if ($isCreated) {
                header('Location: ' . APP_ROOT . '/my-account');
                exit();
            }
            else {
                $msg = $ctrlAuth->getMessage();
            }
        }

        require './view/client/vcreerCompte.php';
    }

    public function getMyAccount() {
        
        if (!isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/createAccount');
            exit();
        }
        require './view/client/vmyAccount.php';
    }

    public function getLogout() {
        $ctrlAuth = new CtrlAuth();
        $ctrlAuth->logOut();

        // TODO : redigirer vers la dernière page
        header('Location: ' . APP_ROOT . '/accueil');
        exit();
    }

    public function getCursus() {
        
        require './view/client/vcursus.php';
    }

    public function getNotFound()
    {
        
        require './view/v404.php';
    }

    public function getPlayground(): void
    {
        // echo 'getPlayground';
        

        $mappedWorkspaces = array_fill(0, CtrlPedacode::MAX_SAVE_SLOTS, CtrlPedacode::EMPTY_SLOT);

        if (isset($_SESSION['is-logged'])) {
            $playgWorkspaces = $this->daoPedacode->getPlaygWorkspacesByUserId($_SESSION['id']);

            // Met les workspaces dans l'ordre des emplacements
            foreach ($playgWorkspaces as $workspace) {
                $mappedWorkspaces[$workspace->getSlotIndex()] = $workspace->getName();
            }
        }
        $workspacesSlots = $mappedWorkspaces;

        require './view/client/vplayground.php';
    }
    //######################//
    //#### ADMIN GLOBAL ####//
    //######################//
    public function getadminGlobal(): void
    {
        
        $categorie = $this->daoPedacode->getCategories();
        $langages = $this->daoPedacode->getLangages();

        require './view/admin/vadminGlobal.php';
    }

    public function postAjoutLangage(): void
    {
        
        $categorie = $this->daoPedacode->getCategories();
        $langages = $this->daoPedacode->getLangages();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_langage_name'], $_POST['new_langage_extension'], $_POST['new_langage_id'])) {

            $newLangageName = $_POST['new_langage_name'];
            $newLangageExtension = $_POST['new_langage_extension'];
            $newLangageId = $_POST['new_langage_id'];


            try {
                $langage = new Langage((int)$newLangageId, $newLangageName, $newLangageExtension);
                $this->daoPedacode->addLangage($langage);
                header("Refresh:1; url=./adminGlobal");
            } catch (\Exception $e) {

                echo "Une erreur s'est produite lors de l'ajout du langage : " . $e->getMessage();
            }
        }
        require './view/admin/vadminGlobal.php';
    }

    public function postDelLangage(): void
    {
        
        $categorie = $this->daoPedacode->getCategories();
        $langages = $this->daoPedacode->getLangages();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idLang'])) {

            $langageId = (int)$_POST['idLang'] ?? null;
            $delLangage = $this->daoPedacode->delLangage((int)$langageId);
            $langageId = $_GET['idLang'] ?? 0;
            if ($langageId === null) {
                echo "Une erreur s'est produite lors de la suppression du langage : ";
            }
            $langages = $this->daoPedacode->getLangages($langageId);
        }


        require './view/admin/vadminGlobal.php';
    }

    public function postAjoutCat(): void
    {
        
        $categories = $this->daoPedacode->getCategories();
        $langages = $this->daoPedacode->getLangages();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_category_name'], $_POST['new_category_id'])) {

            $newCategoryName = $_POST['new_category_name'];
            $newCategoryId = $_POST['new_category_id'];


            try {
                $category = new Category($newCategoryName, (int)$newCategoryId);
                $this->daoPedacode->addCategory($category);

                header("Location: ./adminGlobal");
            } catch (\Exception $e) {

                echo "Une erreur s'est produite lors de l'ajout de la catégorie : " . $e->getMessage();
            }
        }

        require './view/admin/vadminGlobal.php';
    }

    public function postDelCat(): void
    {
        
        $categories = $this->daoPedacode->getCategories();
        $langages = $this->daoPedacode->getLangages();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idCat'])) {
            $categoryId = $_POST['idCat'] ?? null;
            $delCategory = $this->daoPedacode->delCategory((int)$categoryId);
            $categoryId = $_GET['idCat'] ?? 0;
            if ($categoryId === null) {
                echo "Une erreur s'est produite lors de la suppression de la catégorie : ";
            }
            $categorie = $this->daoPedacode->getCategories($categoryId);
        }

        $langages = $this->daoPedacode->getLangages();

        require './view/admin/vadminGlobal.php';
    }

    //#######################//
    //#### ADMIN CHAPTER ####//
    //#######################//

    public function getadminChapter(): void
    {
        
        $categories = $this->daoPedacode->getCategories();

        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];

            // echo "ID de la catégorie : $categoryId";
        }
        // else {
        // echo "Paramètre 'categoryId' non trouvé dans l'URL.";
        // }
        $chapitres = [];
        if ($categoryId !== null) {
            $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
        }

        require './view/admin/vadminChapter.php';
        // require './view/base.php';
    }

    public function postAjoutChap(): void
    {
        
        $categories = $this->daoPedacode->getCategories();
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
        }

        // echo "ID de la catégorie : $categoryId";
        // } else {
        //     echo "Paramètre 'categoryId' non trouvé dans l'URL.";
        // }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST["newChapitre"]) && !empty($_POST["categoryId"])) {

                $categoryId = (int)$_POST["categoryId"];
                $newChapitreTitle = $_POST["newChapitre"];
                // $newChapitreId = (int)$_GET["newChapitreId"];

                try {

                    $this->daoPedacode->addChapitre($newChapitreTitle, (int)$categoryId);
                    header("Refresh:0; url=./adminChapter?categoryId=$categoryId");
                    exit();
                } catch (\Exception $e) {

                    // echo "Une erreur s'est produite lors de l'ajout du chapitre : " . $e->getMessage();
                }
            } else {

                // echo "Veuillez saisir le titre du nouveau chapitre ou la catégorie est manquante.";
            }
        }

        $chapitres = [];
        if ($categoryId !== null) {
            $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
        }

        require './view/admin/vadminChapter.php';
    }
    public function delChap(): void
    {
        
        $categories = $this->daoPedacode->getCategories();

        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];

            // echo "ID de la catégorie : $categoryId";
        }
        // else {
        //     echo "Paramètre 'categoryId' non trouvé dans l'URL.";
        // }


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idChap'])) {
            $chapitreId = $_POST['idChap'] ?? null;
            $delChapitre = $this->daoPedacode->delChapitre($chapitreId);
            $chapitreId = $_GET['idChap'] ?? 0;
            $chapitre = $this->daoPedacode->getChapitresByCategory($chapitreId);
            $categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : null;
            $categorie = $this->daoPedacode->getCategories($categoryId);
        }

        $chapitres = [];
        if ($categoryId !== null) {
            $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
        }

        require './view/admin/vadminChapter.php';
    }

    //#######################//
    //#### ADMIN LESSON  ####//
    //#######################//

    public function getadminLesson(): void
    {
        
        $chapitreId = $_GET['chapitreId'] ?? null;

        // var_dump($chapitreId);

        if ($chapitreId !== null) {
            $selectedChapter = $this->daoPedacode->getChapitresByCategory($chapitreId);
            $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);
        } else {
            $selectedChapter = null;
            $lessons = [];
        }

        $chapitres = $this->daoPedacode->getChapitresByCategory($chapitreId);

        $id_chap = $_GET['chapitreId'] ?? null;
        $id_cat = $_GET['categoryId'] ?? null;
        $chapitres = $this->daoPedacode->getChapitresByCategory($id_cat);

        $selectedChapter = $this->daoPedacode->getChapitresByCategory($id_chap);


        require './view/admin/vadminLesson.php';
    }

    public function postLessonDel(): void
    {
        
        $id_chap = $_GET['chapitreId'] ?? null;
        $id_cat = $_GET['categoryId'] ?? null;
        $chapitres = $this->daoPedacode->getChapitresByCategory($id_cat);
        $selectedChapter = $this->daoPedacode->getChapitresByCategory($id_chap);

        $chapitreId = $_GET['chapitreId'] ?? null;

        // var_dump($chapitreId);

        if ($chapitreId !== null) {
            $selectedChapter = $this->daoPedacode->getChapitresByCategory($chapitreId);
            $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);
        } else {
            $selectedChapter = null;
            $lessons = [];
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idDelLess'])) {
            $lessonId = $_POST['idDelLess'] ?? null;
            $delLesson = $this->daoPedacode->delLesson((int)$lessonId);
            $lessons = $this->daoPedacode->getChapitresByCategory($lessonId);
            $chapitreId = isset($_GET['chapitreId']) ? (int)$_GET['chapitreId'] : null;
            $chapitre = $this->daoPedacode->getChapitresByCategory($chapitreId);
            $categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : null;
            $categorie = $this->daoPedacode->getCategories($categoryId);
        }
        $chapitres = $this->daoPedacode->getChapitresByCategory($chapitreId);

        
        
        require './view/admin/vadminLesson.php';
    }

    public function postadminAddLesson(): void {
    $categoryId = $_GET['categoryId'] ?? null;
    $chapitreId = $_GET['chapitreId'] ?? null;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addLesson'])) {
        $newLecon = $_POST['addLesson'];
        $addLesson = $this->daoPedacode->addLesson($newLecon, (int)$chapitreId);
    }

    if ($chapitreId !== null) {
        $selectedChapter = $this->daoPedacode->getChapitresByCategory($chapitreId);
        $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);
    } else {
        $selectedChapter = null;
        $lessons = [];
    }

    $chapitres = $this->daoPedacode->getChapitresByCategory($chapitreId);

    $id_chap = $_GET['chapitreId'] ?? null;
    $id_cat = $_GET['categoryId'] ?? null;
    $chapitres = $this->daoPedacode->getChapitresByCategory($id_cat);

    $selectedChapter = $this->daoPedacode->getChapitresByCategory($id_chap);


    // $categories = $this->daoPedacode->getCategories();
    //     $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
    //     $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $newLecon = $_POST['lecon'];
    //     $newInstruction = $_POST['instruction'];
    //     $newObjectif = $_POST['objectif'];
    //     $abonnementChecked = isset($_POST['abonnement']) ? 'checked' : '';

    //     if ($abonnementChecked === 'checked') {
    //         $newIdSub = 2;
    //     } else {
    //         $newIdSub = 1;
    //     }

    //     try {
    //         $this->daoPedacode->addLesson($newLecon,  $newInstruction , $newIdSub,(int)$chapitreId);
    //         $lessonId = $this->daoPedacode->getLastInsertedLessonId();
    //         $this->daoPedacode->insertGoalByLessonId($lessonId, $newObjectif); 
    //         header("Location: ./adminEditLesson?categoryId=$categoryId&chapitreId=$chapitreId&lessonId=$lessonId");
    //         exit();
    //     } catch (\Exception $e) {
    //         $message = "Une erreur s'est produite lors de la création de la leçon : " . $e->getMessage();
    //     }
    // }

    require './view/admin/vadminLesson.php';
}

    

    //#######################//
    //##### ADMIN EDIT ######//
    //#######################//

    public function getadminEditCat(): void
    {
        $categoryId = $this->daoPedacode->getCategoryById((int)$_GET['categoryId']);

        require './view/admin/vadminEditCategory.php';
    }

    public function postadminUpdateCat(): void
    {
        
        $categoryId = $this->daoPedacode->getCategoryById((int)$_GET['categoryId']);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_category_name'], $_POST['category_id'])) {

            $newCategoryName = $_POST['edit_category_name'];
            $newCategoryId = (int)$_POST['category_id'];
            // var_dump($newCategoryId);
            // var_dump($newCategoryName);

            try {
                $category = new Category($newCategoryName, (int)$newCategoryId);
                $this->daoPedacode->updateCategory($category);
                $message = "La catégorie a bien été modifiée.";
                header("Refresh:1;url=./adminEditCat?categoryId=$newCategoryId");
            } catch (\Exception $e) {

                $message = "Une erreur s'est produite lors de la modification de la catégorie : " . $e->getMessage();
            }
        }
        require './view/admin/vadminEditCategory.php';
    }

    public function getadminEditLang(): void
    {
        
        $langageId = $this->daoPedacode->getLangageById((int)$_GET['langId']);

        require './view/admin/vadminEditLangage.php';
    }

    public function postadminUpdateLang(): void
    {
        
        $langageId = $this->daoPedacode->getLangageById((int)$_GET['langId']);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_lang_name'], $_POST['lang_id'], $_POST['edit_ext_name'])) {

            $newLangName = $_POST['edit_lang_name'];
            $newLangExt = $_POST['edit_ext_name'];
            $newLangId = (int)$_POST['lang_id'];
            try {
                $langage = new Langage((int)$newLangId, $newLangName, $newLangExt);
                $this->daoPedacode->updateLangage($langage);
                $message = "Le langage a bien été modifiée.";
                header("Refresh:1;url=./adminEditLang?langId=$newLangId");
            } catch (\Exception $e) {

                $message = "Une erreur s'est produite lors de la modification du langage : " . $e->getMessage();
            }
        }
        require './view/admin/vadminEditLangage.php';
    }

    public function getadminEditChap(): void
    {
        
        $categoryId = $this->daoPedacode->getCategoryById((int)$_GET['categoryId']);
        $chapitreId = $this->daoPedacode->getChapitreById((int)$_GET['chapitreId']);

        require './view/admin/vadminEditChapter.php';
    }

    public function postadminUpdateChap(): void
    {
        
        $categoryId = $this->daoPedacode->getCategoryById((int)$_GET['categoryId']);
        $chapitreId = $this->daoPedacode->getChapitreById((int)$_GET['chapitreId']);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_chap_name'], $_POST['chap_id'])) {

            $newChapName = $_POST['edit_chap_name'];
            $newChapId = (int)$_POST['chap_id'];
            try {
                $chapitre = new Chapter ($newChapName,(int)$newChapId);
                $this->daoPedacode->updateChapitre($chapitre);
                header("Refresh:1;url=./adminEditChap?categoryId=$newChapId&chapitreId=$newChapId");
                $message = "Le chapitre a bien été modifiée.";
            } catch (\Exception $e) {
        
                $message = "Une erreur s'est produite lors de la modification du chapitre : " . $e->getMessage();
            }
        }
        require './view/admin/vadminEditChapter.php';
    }

    public function getadminEditLesson(): void
    {
        
        $categoryId = $_GET['categoryId'] ?? null;
        $chapitreId = $_GET['chapitreId'] ?? null;
        $lessonId = $_GET['lessonId'] ?? null;

        $categories = $this->daoPedacode->getCategories();
        $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
        $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);
        $goals = $this->daoPedacode->getGoalsByLessonId((int)$lessonId);


        $abonnementChecked = '';
        if (isset($lessonId)) {
            foreach ($lessons as $lesson) {
                if ($lesson->getIdLes() == $lessonId) {
                    if ($lesson->getIdSub() === 2) {
                        $abonnementChecked = 'checked';
                    }
                    break;
                }
            }
        }

        $selectedInstruction = '';
        if (isset($lessonId)) {
            foreach ($lessons as $lesson) {
                if ($lesson->getIdLes() == $lessonId) {
                    $selectedInstruction = $lesson->getInstrLes();
                    break;
                }
            }
        }
        require './view/admin/vadminEditLesson.php';
    }

    // public function getadminAddLesson(): void{
    //     global $user;
    //     $categoryId = $_GET['categoryId'] ?? null;
    //     $chapitreId = $_GET['chapitreId'] ?? null;
        
    //     $categories = $this->daoPedacode->getCategories();
    //     $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
    //     $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);

    //     require './view/admin/vadminAddLesson.php';
    // }

    // public function postadminUpdateLesson(): void
    // {
    //     global $user;
    //     $categoryId = $_GET['categoryId'] ?? null;
    //     $chapitreId = $_GET['chapitreId'] ?? null;
    //     $lessonId = $_GET['lessonId'] ?? null;
    
    //     $categories = $this->daoPedacode->getCategories();
    //     $chapitres = $this->daoPedacode->getChapitresByCategory($categoryId);
    //     $lessons = $this->daoPedacode->getLessonsByChapterId($chapitreId);
    //     $goals = $this->daoPedacode->getGoalsByLessonId((int)$lessonId);
        
    //     $abonnementChecked = '';
    //     if (isset($lessonId)) {
    //         foreach ($lessons as $lesson) {
    //             if ($lesson->getIdLes() == $lessonId) {
    //                 if ($lesson->getIdSub() === 2) {
    //                     $abonnementChecked = 'checked';
    //                 }
    //                 break;
    //             }
    //         }
    //     }
    
    //     $selectedInstruction = '';
    //     if (isset($lessonId)) {
    //         foreach ($lessons as $lesson) {
    //             if ($lesson->getIdLes() == $lessonId) {
    //                 $selectedInstruction = $lesson->getInstrLes();
    //                 break;
    //             }
    //         }
    //     }
    
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $newLecon = $_POST['lecon'];
    //         $newInstruction = $_POST['instruction'];
    //         $newIdLecon = (int)$lessonId;
    //         $newObjectif = $_POST['objectif'];
    //         $abonnementChecked = isset($_POST['abonnement']) ? 'checked' : '';
        
    //         if ($abonnementChecked === 'checked') {
    //             $newIdSub = 2;
    //         } else {
    //             $newIdSub = 1;
    //         }
        
    //         // Convertir $newObjectif en tableau si nécessaire
    //         if (!is_array($newObjectif)) {
    //             $newObjectif = [$newObjectif];
    //         }
        
    //         try {
    //             $lesson = new Lesson($newIdLecon, (int)$chapitreId, $newIdSub, $newLecon, $newInstruction);
    //             $this->daoPedacode->updateLesson($lesson);
    //             $this->daoPedacode->updateGoalsByLessonId($newIdLecon, $newObjectif); // Passer le tableau d'objectifs ici
    //             header("Refresh:1;url=./adminEditLesson?categoryId=$categoryId&chapitreId=$chapitreId&lessonId=$newIdLecon");
    //         } catch (\Exception $e) {
    //             $message = "Une erreur s'est produite lors de la modification de la leçon : " . $e->getMessage();
    //         }
    //     }
    
    //     require './view/admin/vadminEditLesson.php';
    // }
    


    

    // ################################
    // ######### AJAX section #########
    // ################################

    function loadUserDataFromSlot(): void
    {
        

        $slotIndex = isset($_GET['slotIndex']) ? intval($_GET['slotIndex']) : -1;

        if (!is_numeric($slotIndex) || $slotIndex < 0 || $slotIndex > CtrlPedacode::MAX_SAVE_SLOTS) {
            throw new \Exception(Message::INVALID_WORKSPACE_PLAYG_SLOT . ' : ' . $slotIndex);
        }
        $dataCodeArr = $this->daoPedacode->getCodeFromPlaygSlot($slotIndex, $_SESSION['id']);

        $encodedData = json_encode($dataCodeArr);

        echo $encodedData ? $encodedData : '';
        exit();
    }

    function deleteUserDataFromSlot(): void
    {
        

        $slotIndex = isset($_POST['slotIndex']) ? intval($_POST['slotIndex']) : -1;

        if (!is_numeric($slotIndex) || $slotIndex < 0 || $slotIndex > CtrlPedacode::MAX_SAVE_SLOTS) {
            throw new \Exception(Message::INVALID_WORKSPACE_PLAYG_SLOT . ' : ' . $slotIndex);
        }
        $workspaceId = $this->daoPedacode->getPlaygWorkspaceIdByUserId($slotIndex, $_SESSION['id']);

        if ($workspaceId !== null) {
            $this->daoPedacode->deletePlaygWorkspace($workspaceId);
        }

        exit();
    }

    function saveUserDataFromSlot(): void
    {
        // json
        // code_data: liveEditor.editor.getValue(),
        // name_workspace: inputSlot.value,
        // langage_name: liveEditor.getLangage(),
        // langage_extension: liveEditor.getLangagePretty()

        

        $workspaceData = json_decode($_POST['dataJson'], true);
        $slotIndex = isset($workspaceData['slot_index']) ? intval($workspaceData['slot_index']) : -1;

        if (!is_numeric($slotIndex) || $slotIndex < 0 || $slotIndex > CtrlPedacode::MAX_SAVE_SLOTS) {
            throw new \Exception(Message::INVALID_WORKSPACE_PLAYG_SLOT . ' : ' . $slotIndex);
        }

        if (
            !isset($workspaceData['code_data']) && !is_string($workspaceData['code_data'])
            || !isset($workspaceData['langage_name']) && !is_string($workspaceData['langage_name'])
            || !isset($workspaceData['langage_extension']) && !is_string($workspaceData['langage_extension'])
        ) {
            throw new \Exception(Message::INVALID_JSON_DATA);
        }

        $langage = $this->daoPedacode->getLangageByName($workspaceData['langage_name']);

        // le langage est invalide ou n'existe pas dans la bdd
        // if ($langage === null) { return ''; } // TODO : throw error

        $workspaceId = $this->daoPedacode->getPlaygWorkspaceIdByUserId($slotIndex, $_SESSION['id']);

        // current workspace is null, create it
        if ($workspaceId === null) {
            $workspaceId = $this->daoPedacode->addPlaygWorkspace($_SESSION['id'], $workspaceData['name_workspace'], $slotIndex);
        }
        // Workspace exists, update name
        else {
            $this->daoPedacode->updatePlaygWorkspaceName($workspaceId, $workspaceData['name_workspace']);
        }

        // delete all code from workspace byb id
        $this->daoPedacode->deleteCodeFromWorkspace($workspaceId);

        // insert new codes
        $dataCode = new DataCode($workspaceId, $workspaceData['code_data'], $langage);
        $this->daoPedacode->addCodeFromWorkspace($dataCode);

        // TODO : return date if there is no name
        echo $workspaceData['name_workspace'];
        exit();
    }

    public function updateLesson(): void {
        // lessonId: lessonId.value,
        // lessonTitle: lessonTitleInput.value,
        // instruction: instructionInput.value,
        // chapterId: chapitreSelect.value,
        // subscription: subscription.value,
        // goalsDescription: goalsInput.value,
        // goalsConditions: 'conditions.value',
        // code: liveEditor.editor.getValue(),
        // langageName: liveEditor.getLangage(),
        // langageExtension: liveEditor.getLangagePretty()

        $lessonData = json_decode($_POST['dataJson'], true);
        $updatedLesson = new Lesson($lessonData['lessonId'], $lessonData['chapterId'], $lessonData['subscription'], $lessonData['lessonTitle'], $lessonData['instruction']);
        try {
            $this->daoPedacode->updateLesson($updatedLesson);
        }
        catch (\Exception $er) {
            echo $er->getMessage();
            exit();
            // throw new \Exception($er->getMessage());
        }
        // retrouver workspace grace à la lesson (id) et del dataCode ou le créer si il existe pas lié à la lesson
        // pareil qu'en haut mais avec le goal
        // FIXME : subscription value checkbox
        require './view/admin/vadminEditLesson.php';
    }

    // public function loadDataFromLesson() {
    
    //     $encodedData = ''; // Initialiser $encodedData
    
    //     if (isset($_GET['lessonId'])) {
    //         $dataCode = $this->daoPedacode->getCodeByLessonId((int)$_GET['lessonId']);
    //         $encodedData = json_encode($dataCode);
    //     }
    
    //     echo $encodedData ? $encodedData : 'Wesh';
    //     exit();
    // }
}
