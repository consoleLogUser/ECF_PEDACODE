const accountCreationForm = {
    email: '',
    password: '',
    nom: '',
    prenom: '',
    dateDeNaissance: '',
    ville: '',
    pays: ''
  };
  
  // Logique de Création de Compte
  function createAccount(accountData) {
    if (accountData.email && accountData.password) {
      // Logique de création de compte
      console.log('Compte créé avec succès ! Bienvenu sur pédacode');
    } else {
      console.log('Veuillez fournir une adresse e-mail et un mot de passe valide.');
    }
  }



