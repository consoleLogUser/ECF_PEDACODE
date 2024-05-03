<?php
namespace pedacode;

use pedacode\controller\CtrlPedacode;
use pedacode\metier\UserProfile;

require_once '../../vendor/autoload.php';

session_start();
// var_dump($_SESSION);
$ctrlPedacode = new CtrlPedacode();


// ###### Dans le if = instructions exécutées que pour requête ajax ########
// ###### Dans le else = instructions exécutées que pour requête http standard ########
// ###### au delà = instructions exécutées pour les 2 types de requête ########
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $isRequestAjax = true;
}
else {
    $isRequestAjax = false;
}


if (file_exists("./param.ini")) {
    $param = parse_ini_file("./param.ini", true);
    extract($param['APPWEB']);
}

define('APP_ROOT', $app_root);
define('PUBLIC_ROOT', $public_root);

$uri = $_SERVER['REQUEST_URI']; // = partie de l'url après le nom de domaine

$route = explode('?',$uri)[0]; // on garde la partie avant le ? ex /rubrique?id=1

$method = strtolower($_SERVER['REQUEST_METHOD']);
// echo $route . ' - ' . $method;


// Évaluation de la requête pour traitement
if ($method == 'get' && !$isRequestAjax){ // Non ajax et methode get (lecture seule)
    match($route){
        APP_ROOT                            => $ctrlPedacode->getIndex(),
        APP_ROOT .'/'                       => $ctrlPedacode->getIndex(),
        APP_ROOT .'/adminGlobal'            => $ctrlPedacode->getadminGlobal(),
        APP_ROOT .'/adminEditCat'           => $ctrlPedacode->getadminEditCat(),
        APP_ROOT .'/adminEditLang'          => $ctrlPedacode->getadminEditLang(),
        APP_ROOT .'/adminChapter'           => $ctrlPedacode->getadminChapter(),
        APP_ROOT .'/adminEditChap'          => $ctrlPedacode->getadminEditChap(),
        APP_ROOT .'/adminLesson'            => $ctrlPedacode->getadminLesson(),
        APP_ROOT .'/adminEditLesson'          => $ctrlPedacode->getadminEditLesson(),
        APP_ROOT .'/accueil'                => $ctrlPedacode->getIndex(),
        APP_ROOT .'/login'                  => $ctrlPedacode->getLogin(),
        APP_ROOT .'/create-account'         => $ctrlPedacode->getCreateAccount(),
        APP_ROOT .'/logout'             => $ctrlPedacode->getLogout(),
        APP_ROOT .'/my-account'             => $ctrlPedacode->getMyAccount(),
        APP_ROOT .'/cursus'                 => $ctrlPedacode->getCursus(),
        APP_ROOT .'/playground'             => $ctrlPedacode->getPlayground(),
        default                             => $ctrlPedacode->getNotFound(),
        
    };
}
elseif ($method == 'post' && !$isRequestAjax) { // Non ajax et methode post (modification de données)
    match($route){
        APP_ROOT .'/login'                 => $ctrlPedacode->getLogin(),
        APP_ROOT .'/create-account'        => $ctrlPedacode->getCreateAccount(),
        APP_ROOT .'/adminGlobalAjoutLang'  => $ctrlPedacode->postAjoutLangage(),
        APP_ROOT .'/adminGlobalAjoutCat'   => $ctrlPedacode->postAjoutCat(),
        APP_ROOT .'/adminGlobalDelLang'    => $ctrlPedacode->postDelLangage(),
        APP_ROOT .'/adminGlobalDelCat'     => $ctrlPedacode->postDelCat(),
        APP_ROOT .'/adminChapterAjoutChap' => $ctrlPedacode->postAjoutChap(),
        APP_ROOT .'/adminChapterDelChap'   => $ctrlPedacode->delChap(),
        APP_ROOT .'/adminLessonDel'        => $ctrlPedacode->postLessonDel(),
        APP_ROOT .'/adminUpdateCat'        => $ctrlPedacode->postadminUpdateCat(),
        APP_ROOT .'/adminUpdateLang'       => $ctrlPedacode->postadminUpdateLang(),
        APP_ROOT .'/adminUpdateChap'       => $ctrlPedacode->postadminUpdateChap(),
        APP_ROOT .'/adminLesson'           => $ctrlPedacode->postadminAddLesson(),
        default                            => $ctrlPedacode->getNotFound(),
    };
}
elseif ($method == 'get' && $isRequestAjax) { // Ajax et methode get (lecture seule)
    match($route){
        APP_ROOT .'/playground/loadWorkspace'   => $ctrlPedacode->loadUserDataFromSlot(),
        // APP_ROOT .'/adminEditLesson'   => $ctrlPedacode->loadDataFromLesson(),
        default                                 => ajaxError(),
    };
}
elseif ($method == 'post' && $isRequestAjax) { // Ajax et methode post (modification de données)
    match($route){
        APP_ROOT .'/playground/deleteWorkspace' => $ctrlPedacode->deleteUserDataFromSlot(),
        APP_ROOT .'/playground/saveWorkspace'   => $ctrlPedacode->saveUserDataFromSlot(),
        APP_ROOT .'/adminEditLesson'            => $ctrlPedacode->updateLesson(),
       
        // APP_ROOT .'/adminEditLesson'            => $ctrlPedacode->adminUpdateLesson(),
        default                                 => ajaxError(),
    };
}
else {
    $cntrlFavoris->getIndex();
}
// Pas de code à partir d'ici (sauf functions)


function ajaxError() {
    http_response_code(404);
    exit();
}