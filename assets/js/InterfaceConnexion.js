
//fonction pour log-in
function login(username, password) {
    
    if (username === 'email' && password === 'password') {
        console.log('Bienvenue');
    } else {
        console.log('Mot de passe ou email incorrect, veuillez réessayer');
    }
}

//qunit tests
QUnit.test("Email Test", function(assert) {
    assert.ok(validateEmail("test@example.com"), "Email ok");
    assert.ok(validateEmail("john.doe@test.co"), "Email ok");
    assert.notOk(validateEmail("invalid_email.com"), "Not ok");
    assert.notOk(validateEmail("test@.com"), "Not ok");
  });
  
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }