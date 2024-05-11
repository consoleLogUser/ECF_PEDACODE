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

    public function getIndex()
    {
        require './view/vindex.php';
    }

    public function getLogin()
    {


        // user connecté ? redirection vers accueil
        if (isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/');
            exit();
        }

        $msg = '';

        if (isset($_POST['pseudo']) && isset($_POST['password'])) {
            $ctrlAuth = new CtrlAuth();
            $ctrlAuth->connectUserAccount($_POST['pseudo'], $_POST['password'], $this->daoPedacode);
            if (isset($_SESSION['is-logged'])) {
                header('Location: ' . APP_ROOT . '/');
                exit();
            } else {
                $msg = $ctrlAuth->getMessage();
            }
        }

        require './view/client/vinterfaceConnexion.php';
    }

    public function getCreateAccount()
    {


        // user connecté ? redirection l'accueil
        if (isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/');
            exit();
        }

        $msg = '';

        if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
            $ctrlAuth = new CtrlAuth();

            $isCreated = $ctrlAuth->createUserAccount($_POST['pseudo'], $_POST['email'], $_POST['password'], $this->daoPedacode);
            if ($isCreated) {
                header('Location: ' . APP_ROOT . '/');
                exit();
            } else {
                $msg = $ctrlAuth->getMessage();
            }
        }

        require './view/client/vcreerCompte.php';
    }

    public function getMyAccount()
    {

        if (!isset($_SESSION['is-logged'])) {
            header('Location: ' . APP_ROOT . '/createAccount');
            exit();
        }
        require './view/client/vmyAccount.php';
    }

    public function getLogout()
    {
        $ctrlAuth = new CtrlAuth();
        $ctrlAuth->logOut();

        // TODO : redigirer vers la dernière page
        header('Location: ' . APP_ROOT . '/');
        exit();
    }

    public function getCursus()
    {

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

    // private function fetchChaptersAndLessons(int $categoryId, int $chapterId) {
    //     $chapters = $this->daoPedacode->getChapitresByCategory($categoryId);
    //     $lessons = $this->daoPedacode->selectLessonByChapterId($chapterId);
    //     return ['chapters' => $chapters, 'lessons' => $lessons];
    // }

    public function getadminGlobal(): void
    {
        $categories = $this->daoPedacode->getCategories();

        require './view/admin/vadminGlobal.php';
    }

    public function addCategory(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_category_name'])) {
            $categoryName = trim($_POST['new_category_name']);
            if (!empty($categoryName)) {
                try {
                    $category = new Category($categoryName, 0); // le 0 est pour l'id, il sera généré par la bdd et n'est pas interpreter dans la requete INSERT_CATEGORY
                    $this->daoPedacode->insertCategory($category);
                    $_SESSION['message'] = "Catégorie ajoutée avec succès.";
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Le nom de la catégorie ne peut pas être vide.";
            }
        }
        header('Location: ' . APP_ROOT . '/adminGlobal');
    }

    public function delCategory(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCat']) && isset($_POST['actionCat']) && $_POST['actionCat'] === 'delete') {
            $categoryId = (int)$_POST['idCat'];
            if ($categoryId > 0) {
                try {
                    $this->daoPedacode->deleteCategory($categoryId);
                    $_SESSION['message'] = "Catégorie supprimée avec succès.";
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Identifiant de catégorie invalide.";
            }
        }
        header('Location: ' . APP_ROOT . '/adminGlobal');
        exit();
    }

    public function getadminEditCat(): void
    {
        if (isset($_GET['categoryId'])) {
            $categoryId = (int)$_GET['categoryId'];
            if ($categoryId > 0) {
                try {
                    $category = $this->daoPedacode->getCategoryById($categoryId);
                    if ($category) {
                        require './view/admin/vadminEditCategory.php';
                    } else {
                        $_SESSION['error'] = "Aucune catégorie trouvée avec cet identifiant.";
                        header('Location: ' . APP_ROOT . '/adminGlobal'); // mettre un require
                        exit(); // eviter les exit
                    }
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la récupération de la catégorie : " . $e->getMessage();
                    header('Location: ' . APP_ROOT . '/adminGlobal');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Identifiant de catégorie invalide.";
                header('Location: ' . APP_ROOT . '/adminGlobal');
                exit();
            }
        } else {
            $_SESSION['error'] = "Aucun identifiant de catégorie fourni.";
            header('Location: ' . APP_ROOT . '/adminGlobal');
            exit();
        }

    }

    public function updateCategory(): void
    {
        $categoryId = (int)$_GET['categoryId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category_name'], $_POST['category_id'])) {
            $categoryName = trim($_POST['edit_category_name']);
            if (!empty($categoryName) && $categoryId > 0) {
                try {
                    $category = new Category($categoryName, $categoryId);
                    $this->daoPedacode->updateCategory($category);
                    $_SESSION['message'] = "Catégorie mise à jour avec succès.";
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de la catégorie : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Le nom de la catégorie ne peut pas être vide et l'identifiant doit être valide.";
            }
        }
        header('Location: ' . APP_ROOT . '/adminEditCat?categoryId=' . $categoryId);
        exit();
    }

    //#######################//
    //#### ADMIN CHAPTER ####//
    //#######################//

    public function getadminChapter(): void
    {
        //Le categoryId est dans l'url et doit renvoyer un int 
        $categoryId = (int)$_GET['categoryId'];
        $categories = $this->daoPedacode->getCategories(); // Je recupère toute les cat pour la liste déroulante 
        $chapters = $this->daoPedacode->getChapitresByCategory($categoryId); // Je recupère tout les chapitres liés à la catégorie

        //Afficher la vue avec les chapitres liés à la catégorie
        require './view/admin/vadminChapter.php';
    }

    public function addChapter(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newChapitre'], $_POST['categoryId'])) {
            $chapterTitle = trim($_POST['newChapitre']);
            $categoryId = (int)$_POST['categoryId'];
            if (!empty($chapterTitle) && $categoryId > 0) {
                try {
                    // Création de l'objet Category
                    $category = new Category("", $categoryId); // Le nom n'est pas nécessaire pour l'insertion du chapitre
                    // Création de l'objet Chapter
                    $chapter = new Chapter(0, $chapterTitle, $category); // L'ID du chapitre est mis à 0 car il sera généré par la base de données
    
                    // Appel à la méthode addChapitre de DaoPedacode
                    $this->daoPedacode->addChapitre($chapter);
                    $_SESSION['message'] = "Chapitre ajouté avec succès.";
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de l'ajout du chapitre : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Le titre du chapitre ne peut pas être vide et l'identifiant de la catégorie doit être valide.";
            }
        }
        header('Location: ' . APP_ROOT . '/adminChapter?categoryId=' . $categoryId);

    }

    public function delChapter(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idChap'])) {
            $chapitreId = (int)$_POST['idChap'];
            if ($chapitreId > 0) {
                try {
                    $this->daoPedacode->delChapitre($chapitreId);
                    $_SESSION['message'] = "Chapitre supprimé avec succès.";
                } catch (\Exception $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression du chapitre : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Identifiant du chapitre invalide.";
            }
        }
        header('Location: ' . APP_ROOT . '/adminChapter?categoryId=' . $_GET['categoryId']);
        exit();
    }

    public function getEditChapter(): void
    {
        $categoryId = (int)$_GET['categoryId'];
        // Récupérer l'identifiant du chapitre depuis l'URL et vérifier sa validité
        $chapitreId = (int)$_GET['chapitreId'];
        if ($chapitreId <= 0) {
            throw new \Exception("Identifiant du chapitre invalide.");
        }

        // Récupérer les informations du chapitre à éditer
        $chapitre = $this->daoPedacode->selectChapitreById($chapitreId);
        if (!$chapitre) {
            throw new \Exception("Chapitre non trouvé.");
        }

        // Récupérer toutes les catégories pour la liste déroulante
        $categories = $this->daoPedacode->getCategories();

        // Afficher la vue avec les informations du chapitre à éditer
        require './view/admin/vadminEditChapter.php';
    }

    // public function updateChapter(): void
    // {

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chap_id'], $_POST['edit_chap_name'])) {
    //         $chapitreId = (int)$_POST['chap_id'];
    //         $newTitle = trim($_POST['edit_chap_name']);

    //         if ($chapitreId > 0 && !empty($newTitle)) {
    //             try {
    //                 $updated = $this->daoPedacode->updateChapitre($chapitreId, $newTitle);
    //                 if ($updated) {
    //                     $_SESSION['message'] = "Chapitre mis à jour avec succès.";
    //                 } else {
    //                     $_SESSION['error'] = "Mise à jour du chapitre échouée.";
    //                 }
    //             } catch (\Exception $e) {
    //                 $_SESSION['error'] = "Erreur lors de la mise à jour du chapitre : " . $e->getMessage();
    //             }
    //         } else {
    //             $_SESSION['error'] = "L'identifiant du chapitre doit être valide et le titre ne peut pas être vide.";
    //         }
    //     }
    //     header('Location: ' . APP_ROOT . '/adminChapter?categoryId=' . $_GET['categoryId']);
    //     exit();
    // }

    public function updateChapter(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chap_id'], $_POST['edit_chap_name'])) {
        $chapitreId = (int)$_POST['chap_id'];
        $newTitle = trim($_POST['edit_chap_name']);

        if ($chapitreId > 0 && !empty($newTitle)) {
            try {
                // Création de l'objet Chapter
                $existingChapter = $this->daoPedacode->selectChapitreById($chapitreId);
                $category = $existingChapter->getCategory();

                $chapter = new Chapter($chapitreId, $newTitle, $category);

                // Mise à jour du chapitre via DaoPedacode
                $updated = $this->daoPedacode->updateChapitre($chapter);
                if ($updated) {
                    $_SESSION['message'] = "Chapitre mis à jour avec succès.";
                } else {
                    $_SESSION['error'] = "Mise à jour du chapitre échouée.";
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = "Erreur lors de la mise à jour du chapitre : " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "L'identifiant du chapitre doit être valide et le titre ne peut pas être vide.";
        }
    }
    header('Location: ' . APP_ROOT . '/adminChapter?categoryId=' . $_GET['categoryId']);
    exit();
}


    //#######################//
    //#### ADMIN LESSON  ####//
    //#######################//

    public function getAdminLesson(): void
    {
        $chapterId = (int)$_GET['chapitreId']; // Le chapterId est dans l'url et doit renvoyer un int
        $categoryId = (int)$_GET['categoryId'];
        $chapters = $this->daoPedacode->getChapitresByCategory($categoryId);

        $lessons = $this->daoPedacode->selectLessonByChapterId($chapterId); // Je récupère toutes les leçons liées au chapitre

        // Afficher la vue avec les leçons liées au chapitre
        require './view/admin/vadminLesson.php';
    }


    public function getAdminEditLesson(): void
    {
        $lessonId = (int)$_GET['lessonId'];
        $chapterId = (int)$_GET['chapitreId'];
        $categoryId = (int)$_GET['categoryId'];

        $categories = $this->daoPedacode->getCategories(); // Je recupère toute les cat pour la liste déroulante 


        if ($lessonId <= 0 || $chapterId <= 0 || $categoryId <= 0) {
            throw new \Exception("Paramètres invalides.");
        }


        $lessons = $this->daoPedacode->selectLessonByChapterId($chapterId);
        if (empty($lessons)) {
            error_log("Aucune leçon trouvée pour le chapitre ID: $chapterId");
            throw new \Exception("Aucune leçon trouvée pour le chapitre ID: $chapterId");
        }

        $lessonToEdit = null;
        foreach ($lessons as $lesson) {
            if ($lesson->getIdLes() === $lessonId) {
                $lessonToEdit = $lesson;
                break;
            }
        }

        if (!$lessonToEdit) {
            error_log("Leçon non trouvée avec l'ID: $lessonId");
            throw new \Exception("Leçon non trouvée avec l'ID: $lessonId");
        }

        // /!\ Fonctionelle mais pas encore implémentée /!\
        // // Récupérer les objectifs associés à la leçon
        // $goals = $this->daoPedacode->getGoalsByLessonId($lessonId);
        // if (empty($goals)) {
        //     error_log("Aucun objectif trouvé pour la leçon ID: $lessonId");
        // }

        $selectedInstruction = $lessonToEdit->getInstrLes();
        $abonnementChecked = '';
        if ($lessonToEdit->getIdSub() === 2) {
            $abonnementChecked = 'checked';
        }
        
        // Récupérer les chapitres pour la liste déroulante
        $chapters = $this->daoPedacode->getChapitresByCategory($categoryId);
        if (empty($chapters)) {
            error_log("Aucun chapitre trouvé pour la catégorie ID: $categoryId");
            throw new \Exception("Aucun chapitre trouvé pour la catégorie ID: $categoryId");
        }

        // Afficher la vue d'édition de la leçon avec les objectifs
        require './view/admin/vadminEditLesson.php';
    }

    // public function addLessonByChapter(): void
    // {
    //     $chapterId = intval($_GET['chapitreId']);
    //     $lessonTitle = $_POST['addLesson'];

    //     if ($chapterId <= 0 || empty($lessonTitle)) {
    //         throw new \Exception("Paramètres invalides pour ajouter une leçon.");
    //     }

    //     try {
    //         $result = $this->daoPedacode->addLessonByChapter($chapterId, $lessonTitle);
    //         if ($result) {
    //             header("Location: " . APP_ROOT . "/adminLesson?chapitreId=" . $chapterId . "&categoryId=" . $_GET['categoryId']);
    //             exit();
    //         } else {
    //             throw new \Exception("Échec de l'ajout de la leçon.");
    //         }
    //     } catch (\Exception $e) {
    //         error_log("Erreur lors de l'ajout de la leçon : " . $e->getMessage());
    //         throw $e;
    //     }
    // }

    public function addLessonByChapter(): void
{
    $chapterId = intval($_GET['chapitreId']);
    $lessonTitle = $_POST['addLesson'];

    if ($chapterId <= 0 || empty($lessonTitle)) {
        throw new \Exception("Paramètres invalides pour ajouter une leçon.");
    }

    try {
        // Récupération de l'objet Chapter à partir de l'ID
        $chapter = $this->daoPedacode->selectChapitreById($chapterId);
        if (!$chapter) {
            throw new \Exception("Chapitre introuvable.");
        }

        // Création de l'objet Lesson
        $lesson = new Lesson(0, $chapter, null, $lessonTitle, null);

        // Ajout de la leçon via la méthode DAO
        $result = $this->daoPedacode->addLessonByChapter($chapter, $lesson);
        if ($result) {
            header("Location: " . APP_ROOT . "/adminLesson?chapitreId=" . $chapterId . "&categoryId=" . $_GET['categoryId']);
            exit();
        } else {
            throw new \Exception("Échec de l'ajout de la leçon.");
        }
    } catch (\Exception $e) {
        error_log("Erreur lors de l'ajout de la leçon : " . $e->getMessage());
        throw $e;
    }
}

    public function deleteLesson(): void
    {
        $lessonId = intval($_POST['idDelLess']);

        if ($lessonId <= 0) {
            throw new \Exception("Identifiant de leçon invalide.");
        }

        try {
            $result = $this->daoPedacode->delLesson($lessonId);
            if ($result) {
                header("Location: " . APP_ROOT . "/adminLesson?chapitreId=" . $_GET['chapitreId'] . "&categoryId=" . $_GET['categoryId']);
                exit();
            } else {
                throw new \Exception("Échec de la suppression de la leçon.");
            }
        } catch (\Exception $e) {
            error_log("Erreur lors de la suppression de la leçon : " . $e->getMessage());
            throw $e;
        }
    }

    public function updateLesson(): void
    {
        $categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : 0;
        if ($categoryId <= 0) {
            throw new \Exception("Identifiant de catégorie invalide.");
        }
        $chapters = $this->daoPedacode->getChapitresByCategory($categoryId);
        $chapterId = isset($_GET['chapitreId']) ? (int)$_GET['chapitreId'] : 0;
        if ($chapterId <= 0) {
            throw new \Exception("Identifiant de chapitre invalide.");
        }
    
        $lessonId = isset($_GET['lessonId']) ? (int)$_GET['lessonId'] : 0;
        $lessonTitle = isset($_POST['title-lesson']) ? $_POST['title-lesson'] : '';
        $lessonInstructions = isset($_POST['instruction']) ? $_POST['instruction'] : '';
        $sub = isset($_POST['abonnement']) && $_POST['abonnement'] === 'on' ? 2 : 1;

        // var_dump($lessonId);
        // var_dump($lessonTitle);
        // var_dump($lessonInstructions);
        // var_dump($sub);
        // var_dump($chapterId);
        // var_dump($categoryId);
        if ($lessonId <= 0 || empty($lessonTitle) || empty($lessonInstructions) || $sub <= 0) {
            throw new \Exception("Paramètres invalides pour la mise à jour de la leçon.");
        }
    
        $existingChapter = $this->daoPedacode->selectChapitreById($chapterId); 
        $lesson = new Lesson(
            $lessonId,
            $existingChapter, 
            $sub,
            $lessonTitle,
            $lessonInstructions
        );

    
        try {
            $result = $this->daoPedacode->updateLesson($lesson);
            if ($result) {
                header("Location: " . APP_ROOT . "/adminEditLesson?categoryId=" . $categoryId . "&chapitreId=" . $chapterId . "&lessonId=" . $_GET['lessonId']);
                exit();
            } else {
                throw new \Exception("Échec de la mise à jour de la leçon.");
            }
        } catch (\Exception $e) {
            error_log("Erreur lors de la mise à jour de la leçon : " . $e->getMessage());
            throw $e;
        }
    }
    



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
}
