const form = document.getElementById('form');
const fname = document.getElementById('name');
const login = document.getElementById('login');
const email = document.getElementById('email');
const password = document.getElementById('pass');
const password2 = document.getElementById('pass2');
che = 0;

form.addEventListener('submit', e => {
	e.preventDefault();
	che = 0;
	checkInputs();

    if(che == 0){
        $(form).unbind('submit').submit()
    }

});

function checkInputs() {
	// trim to remove the whitespaces

    if(fname){
        const fnameValue = fname.value.trim();
        if(fnameValue === '') {
            che = 1;
            setErrorFor(fname, 'fname cannot be blank');
        } else {
            setSuccessFor(fname);
        }
    }
    if(login){
        const loginValue = login.value.trim();
        if(loginValue === '') {
            che = 1;
            setErrorFor(login, 'login cannot be blank');
        } else {
            setSuccessFor(login);
        }
    }
    if(email){
        const emailValue = email.value.trim();
        if(emailValue === '') {
            che = 1;
            setErrorFor(email, 'Email cannot be blank');
        } else if (!isEmail(emailValue)) {
            che = 1;
            setErrorFor(email, 'Not a valid email');
        } else {
            setSuccessFor(email);
        }
    }
    if(password){
        const passwordValue = password.value.trim();
        if(passwordValue === '') {
            che = 1;
            setErrorFor(password, 'Password cannot be blank');
        } else {
            setSuccessFor(password);
        }
    }
    if(password2){
        const passwordValue = password.value.trim();
        if(passwordValue === '') {
            che = 1;
            setErrorFor(password, 'Password cannot be blank');
        } else {
            setSuccessFor(password);
        }
        const password2Value = password2.value.trim();
        if(password2Value === '') {
            che = 1;
            setErrorFor(password2, 'Password2 cannot be blank');
        } else if(passwordValue !== password2Value) {
            che = 1;
            setErrorFor(password2, 'Passwords does not match');
        } else{
            setSuccessFor(password2);
        }
    }
}

function setErrorFor(input, message) {
	const formControl = input.parentElement;
	const small = formControl.querySelector('small');
    formControl.className = 'form-group error';
	small.innerText = message;
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
    formControl.className = 'form-group success';
}
	
function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}