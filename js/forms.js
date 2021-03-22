function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
 
function regformhash(form, uid, password, conf, usergroup) {
     // Check each field has a value
    if (uid.value == ''         || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
 
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 8 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 8) {
        alert('Passwords must be at least 8 characters long.  Please try again');
        form.password.focus();
        return false;
    }
    if ((password.value == uid.value)) {
        alert('Password is same as username.  Please try again');
        return false;
    }
    var re = /[^a-zA-Z0-9!@#\$%&\*\-_=\+\?]/; 
    if (re.test(password.value)) {
        alert('Password contains an illegal character.  Please try again');
        return false;
    }
    var re = /(?=.*\d).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number.  Please try again');
        return false;
    }
    var re = /(?=.*[a-z]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one lower case letter.  Please try again');
        return false;
    }
    var re = /(?=.*[A-Z]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one upper case letter.  Please try again');
        return false;
    }
    var re = /(?=.*[!@#\$%&\*\-_\=\+\?]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one special character.  Please try again');
        return false;
    }
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}

function updformhash(form, uid, password, conf) {
     // Check each field has a value
    if (uid == ''         || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
 
    re = /^\w+$/; 
    if(!re.test(uid)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 8 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 8) {
        alert('Passwords must be at least 8 characters long.  Please try again');
        form.password.focus();
        return false;
    }
    if ((password.value == uid)) {
        alert('Password is same as username.  Please try again');
        return false;
    }
    var re = /[^a-zA-Z0-9!@#\$%&\*\-_=\+\?]/; 
    if (re.test(password.value)) {
        alert('Password contains an illegal character.  Please try again');
        return false;
    }
    var re = /(?=.*\d).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number.  Please try again');
        return false;
    }
    var re = /(?=.*[a-z]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one lower case letter.  Please try again');
        return false;
    }
    var re = /(?=.*[A-Z]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one upper case letter.  Please try again');
        return false;
    }
    var re = /(?=.*[!@#\$%&\*\-_\=\+\?]).{8,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one special character.  Please try again');
        return false;
    }
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    var username = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(username);
    username.name = "username";
    username.type = "hidden";
    username.value = uid;
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}