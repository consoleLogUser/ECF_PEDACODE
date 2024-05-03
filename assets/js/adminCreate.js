import { Editor } from './editor.js';

let lessonId = document.getElementById('id-lesson');
let lessonTitleInput = document.getElementById('title-lesson');
let instructionInput = document.getElementById('instruction');
let chapitreSelect = document.getElementById('chapitre');
let subscription = document.getElementById('abonnement');
let goalsInput = document.getElementById('objectif');
// let conditions = document.getElementById('');
let button = document.getElementById('submit');

button.addEventListener('click', updateLesson);

const liveEditor = new Editor("editor", Editor.syntaxMode.html );

function setEditorData(dataJson) {
    let data = JSON.parse(dataJson);

    if (data) { // Vérifier si les données ne sont pas nulles
        liveEditor.setLangage('html');
        liveEditor.editor.getSession().setValue(data.data_cod);
    }
}

function updateLesson() {
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // succès dans l'update de la leçon
            } else {
                console.error('Erreur lors de la création de la leçon : ' + xhr.status);
            }
        }
    };

    let data = {
        lessonId: lessonId.value,
        lessonTitle: lessonTitleInput.value,
        instruction: instructionInput.value,
        chapterId: chapitreSelect.value,
        subscription: subscription.value,
        goalsDescription: goalsInput.value,
        goalsConditions: 'conditions.value',
        code: liveEditor.editor.getValue(),
        langageName: liveEditor.getLangage(),
        langageExtension: liveEditor.getLangagePretty()
    };
    
    // charge la fonction avec le paramètre slotIndex
    let params = 'dataJson=' + JSON.stringify(data);

    // envoi la requête sur cette même page
    xhr.open('post', window.location.href + '/updateLesson', true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.send(params);
}

// function requestLoadDataFromLesson() {
//     let xhr = new XMLHttpRequest();

//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 // traitement des données
//                 let dataJson = xhr.responseText;
//                 if (dataJson !== '') setEditorData(dataJson);
//             } else {
//                 console.error('Erreur lors du chargement des données utilisateur : ' + xhr.status);
//             }
//         }
//     };
    
//     xhr.open('GET', window.location.href  + '?lessonId=' + idLecon.value, true);
//     xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
//     xhr.send();
// }

// requestLoadDataFromLesson();




// document.addEventListener('DOMContentLoaded', function () {
//     // const chapitreSelect = document.getElementById('chapitre');
//     // const leconSelect = document.getElementById('lecon');
//     // const langageSelect = document.getElementById('langage');


//     // const chapitreCookie = getCookie('selectChapitre');
//     // const leconCookie = getCookie('selectLecon');
//     // const langageCookie = getCookie('langage');


//     // dataCard.forEach(langage => {
//     //     const option = document.createElement('option');
//     //     option.textContent = langage.titre;
        
//     //     if (langage.titre === langageCookie) {
//     //         option.selected = true;
//     //     }
//     //     langageSelect.appendChild(option);


//     // });

 
//     // chapitres.forEach(chapitre => {
//     //     const option = document.createElement('option');
//     //     option.value = chapitre.value;
//     //     option.textContent = chapitre.text;

//     //     if (chapitre.value === chapitreCookie) {
//     //         option.selected = true;
//     //     }
//     //     chapitreSelect.appendChild(option);
//     // });


//     // lecons.forEach(lecon => {
//     //     const option = document.createElement('option');
//     //     option.value = lecon.value;
//     //     option.textContent = lecon.text;

//     //     if (lecon.value === leconCookie) {
//     //         option.selected = true;
//     //     }
//     //     leconSelect.appendChild(option);
//     // });

//     const form = document.querySelector('form');

//     form.addEventListener('submit', function (event) {
//         event.preventDefault(); 

    
//         // const langageSelectionne = langageSelect.value;
//         // const chapitreSelectionne = chapitreSelect.value;
//         // const leconSelectionnee = leconSelect.value;
//         // const dateModification = document.getElementById('date').value;
//         // const abonnementNecessaire = document.getElementById('abonnement').checked;
//         // const instruction = document.getElementById('instruction').value;
//         // const objectif = document.getElementById('objectif').value;
//         const htmlCode = EditorHtml.editor.getValue();
//         const cssCode = EditorCss.editor.getValue();


//         // if (!dateModification.trim() || !instruction.trim() || !objectif.trim()) {
//         //     alert("Veuillez remplir tous les champs.");
//         //     return; 
//         // }

//         // console.log("Langage sélectionné:", langageSelectionne);
//         // console.log("Chapitre sélectionné:", chapitreSelectionne);
//         // console.log("Leçon sélectionnée:", leconSelectionnee);
//         // console.log("Dernière modification:", dateModification);
//         // console.log("Abonnement nécessaire:", abonnementNecessaire);
//         // console.log("Instruction:", instruction);
//         // console.log("Objectif:", objectif);
//         console.log("Code HTML:", htmlCode);
//         console.log("Code CSS:", cssCode);

//     });
// });

// function getCookie(cname) {
//     const name = cname + "=";
//     const decodedCookie = decodeURIComponent(document.cookie);
//     const ca = decodedCookie.split(';');
//     for (let i = 0; i < ca.length; i++) {
//         let c = ca[i];
//         while (c.charAt(0) === ' ') {
//             c = c.substring(1);
//         }
//         if (c.indexOf(name) === 0) {
//             return c.substring(name.length, c.length);
//         }
//     }
//     return "";
// }


