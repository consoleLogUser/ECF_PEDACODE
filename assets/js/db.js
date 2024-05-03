
//search user dans une database
const users = [ ];
// ^database à ajouter
  
function searchUser() {
    // pour html, à ajouter <input type="text" id="searchInput" placeholder="Chercher email"> pour pouvoir chercher
    const input = document.getElementById('searchInput').value;
    const result = searchUsername(input);
    if (result) {
      alert(`Email ${result.username} trouvé`);
    } else {
      alert('Email non trouvé, compte inexistant');
    }
  }
