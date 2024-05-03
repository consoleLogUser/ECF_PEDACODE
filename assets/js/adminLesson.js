import { chapitres, lecons } from './dataOption.js';

document.addEventListener('DOMContentLoaded', function (event) {
    event.preventDefault();
    const form = document.querySelector('form');
    const nouveauLeconInput = document.getElementById('inputLecon');
    const selectLecon = document.getElementById('selectLecon');
    const nouvelleLeconCheckbox = document.getElementById('checkNewLecon');

    const selectChapitre = document.getElementById('selectChapitre');
    const chapitreCookie = getCookie('chapitre');

    lecons.forEach(lecon => {
        const option = document.createElement('option');
        option.value = lecon.value;
        option.textContent = lecon.text;
        selectLecon.appendChild(option);
    });

    chapitres.forEach(chapitre => {
        const option = document.createElement('option');
        option.value = chapitre.value;
        option.textContent = chapitre.text;
        if (chapitre.value === chapitreCookie) {
            option.selected = true;
        }
        selectChapitre.appendChild(option);
    });

    document.cookie = 'chapitre=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (nouvelleLeconCheckbox.checked) {
            const nouvelleLecon = nouveauLeconInput.value;
            const leconExisteDeja = Array.from(selectLecon.options).some(option => option.text === nouvelleLecon);
            if (!leconExisteDeja && nouvelleLecon.trim() !== '') {
                const option = document.createElement('option');
                option.text = nouvelleLecon;
                selectLecon.add(option);
                alert("Leçon ajoutée !");
            } else {
                alert("Erreur : La leçon existe déjà ou le champ est vide.");
            }
        }
    });

    const supprimerBouton = document.querySelector('.button button:last-of-type');
    supprimerBouton.addEventListener('click', function (event) {
        event.preventDefault();
        const selectedOption = selectLecon.options[selectLecon.selectedIndex];
        if (selectedOption) {
            selectLecon.removeChild(selectedOption);
            alert("Leçon supprimée !");
        }
    });

    selectLecon.addEventListener('change', function(event) {
        const selectedLecon = selectLecon.value;
        document.cookie = "selectLecon=" + selectedLecon + ";path=/";
    });
});

function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
