// import { dataCard } from './dataOption.js';

// function creerCarteCategorie(categorie) {
//   const carteHTML = `
//     <div class=" rounded-lg p-2 bg-nightsky-dark-dm flex flex-col gap-2 items-center justify-center ">
//       <img class=" w-12 " src="${categorie.image}" alt="logo-${categorie.titre}">
//       <span class=" text-center font-semibold ">${categorie.titre}</span>
//       <div class=" flex flex-row items-center gap-2 ">
//         <a href="${categorie.lien}" onclick="setCookie('langage', '${categorie.titre}', 1)" class=" rounded p-1 bg-primary-regular-dm text-white hover:text-gray-50 hover:bg-primary-dark-dm ">Modifier</a>
//         <button onclick="supprimerCarte(event, '${categorie.titre}')" class=" rounded p-1 !bg-red-600 text-white !hover:bg-red-800 ">Supprimer</button>
//       </div>
//     </div>
//   `;
//   return carteHTML;
// }

function supprimerCategorie(event, nomCategorie) {
    event.preventDefault(); // Empêche le comportement par défaut du bouton

    // Confirmation de la suppression
    if (confirm("Êtes-vous sûr de vouloir supprimer la catégorie " + nomCategorie + " ?")) {
        // Envoi d'une requête AJAX pour supprimer la catégorie
        const xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200 && xhr.response) {
                    // La catégorie a été supprimée avec succès, rafraîchir la page ou effectuer d'autres actions nécessaires
                    // location.reload(); // Recharge la page pour mettre à jour la liste des catégories
                    console.log("Suppression de la catégorie " + nomCategorie + " effectuée");
                } else {
                    // Gérer les erreurs éventuelles
                    console.error("Erreur lors de la suppression de la catégorie : " + xhr.responseText);
                }
            }
        };

        xhr.open("POST", "./supprimer_categorie.php"); // Assurez-vous d'ajuster le chemin vers votre script de suppression
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send("action=deleteCategory&categoryName=" + nomCategorie); // Envoyer le nom de la catégorie à supprimer
    }
}
// function ajouterCarte(titre, image) {
//   if (!titre.trim()) {
//     alert("Veuillez saisir un titre pour la catégorie.");
//     return; 
//   }

//   if (!image.trim()) {
//     alert("Veuillez sélectionner une image pour la catégorie.");
//     return; 
//   }


//   const newCategory = {
//     titre: titre,
//     image: image,
//     lien: "/src/html/adminChapter.html" 
//   };

//   dataCard.push(newCategory);
//   chargerCartes();
// }


// function chargerCartes() {
//   const gestionCategoriesSection = document.getElementById('gestionCategories');
//   gestionCategoriesSection.innerHTML = '';


//   dataCard.forEach(categorie => {
//     const card = document.createElement('div');
//     card.classList.add('card');
//     card.innerHTML = creerCarteCategorie(categorie);
//     gestionCategoriesSection.appendChild(card);
//   });
// }

// document.addEventListener('DOMContentLoaded', function () {
//   chargerCartes();

//   const formulaireAjoutCategorie = document.getElementById('formulaireAjoutCategorie');

//   formulaireAjoutCategorie.addEventListener('submit', function (event) {
//     event.preventDefault();

//     const titre = document.getElementById('title').value;
//     const image = document.getElementById('image').value;

//     try {
//       ajouterCarte(titre, image);
//     } catch (error) {
//       console.error("Erreur lors de l'ajout de la carte:", error.message);
//     }

//     formulaireAjoutCategorie.reset();
//   });
// });
