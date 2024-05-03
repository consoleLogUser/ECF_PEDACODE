console.log("Hello World");

// document.addEventListener('DOMContentLoaded', function (event) {
//     event.preventDefault();

//     const langage = getCookie('langage');
//     const form = document.querySelector('form');

//     if (langage) {
//         const listeLangages = document.getElementById('langage');

//         const options = listeLangages.options;
//         for (let i = 0; i < options.length; i++) {
//             const option = options[i];
//             if (option.value === langage) {
//                 option.selected = true;
//                 break;
//             }
//         }
//     }

//     const nouveauChapitreInput = document.getElementById('inputChapitre');
//     const selectChapitre = document.getElementById('selectChapitre');
//     const nouveauChapitreCheckbox = document.getElementById('checkNewChapitre');

//     chapitres.forEach(chapitre => {
//         const option = document.createElement('option');
//         option.value = chapitre.value;
//         option.textContent = chapitre.text;
//         selectChapitre.appendChild(option);
//     });

//     form.addEventListener('submit', function (event) {
//         event.preventDefault();
//         if (nouveauChapitreCheckbox.checked) {
//             const nouveauChapitre = nouveauChapitreInput.value;
//             const chapitreExisteDeja = Array.from(selectChapitre.options).some(option => option.text === nouveauChapitre);
//             if (!chapitreExisteDeja && nouveauChapitre.trim() !== '') {
//                 const option = document.createElement('option');
//                 option.text = nouveauChapitre;
//                 selectChapitre.add(option);
//                 alert("Chapitre ajouté !");
//             } else {
//                 alert("Erreur : Le chapitre existe déjà ou le champ est vide.");
//             }
//         }
//     });

//     const supprimerBouton = document.querySelector('.button button:last-of-type');
//     supprimerBouton.addEventListener('click', function (event) {
//         event.preventDefault();
//         const selectedOption = selectChapitre.options[selectChapitre.selectedIndex];
//         if (selectedOption) {
//             selectChapitre.removeChild(selectedOption);
//             alert("Chapitre supprimé !");
//         }
//     });

//     const modifierBouton = document.querySelector('.button a');
//     modifierBouton.addEventListener('click', function(event) {
//         event.preventDefault();
//         const chapitreSelectionne = selectChapitre.value;
//         document.cookie = `chapitre=${chapitreSelectionne};path=/`;
//         window.location.href = '../../src/view/adminLesson.php';
//     });

//     selectChapitre.addEventListener('change', function(event) {
//         const selectedChapitre = selectChapitre.value;
//         document.cookie = "selectChapitre=" + selectedChapitre + ";path=/";
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



