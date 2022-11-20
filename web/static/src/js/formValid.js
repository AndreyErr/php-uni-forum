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

    if(fname){
        const fnameValue = fname.value.trim();
        if(fnameValue === '') {
            che = 1;
            setErrorFor(fname, 'Имя не может быть пустым');
        }else if(fnameValue.length < 2 || fnameValue.length > 25) {
            che = 1;
            setErrorFor(fname, 'Имя в длинну не меньше 2 и не больше 25');
        }else{
            setSuccessFor(fname);
        }
    }
    if(login){
        const loginValue = login.value.trim();
        if(loginValue === '') {
            che = 1;
            setErrorFor(login, 'Логин не может быть пустым');
        }else if(loginValue.length < 4 || loginValue.length > 20) {
            che = 1;
            setErrorFor(login, 'Логин в длинну не меньше 4 и не больше 20');
        }else{
            setSuccessFor(login);
        }
    }
    if(email){
        const emailValue = email.value.trim();
        if(emailValue === '') {
            che = 1;
            setErrorFor(email, 'Email не может быть пустым');
        }else if(!isEmail(emailValue)) {
            che = 1;
            setErrorFor(email, 'Не правильный формат email');
        }else if(emailValue.length > 40) {
            che = 1;
            setErrorFor(email, 'Логин в длинну не больше 40');
        }else{
            setSuccessFor(email);
        }
    }
    if(password){
        const passwordValue = password.value.trim();
        if(passwordValue === '') {
            che = 1;
            setErrorFor(password, 'Пароль не может быть пустым');
        }else if(!passCheck(passwordValue)) {
            che = 1;
            setErrorFor(password, 'Пароль в длинну не меньше 5 и не больше 16, содеррить цифры, буквы и спец символ');
        }else{
            setSuccessFor(password);
        }
    }
    if(password2){
        const passwordValue = password.value.trim();
        const password2Value = password2.value.trim();
        if(password2Value === '') {
            che = 1;
            setErrorFor(password2, 'Поле подтверждения не может быть пустым');
        } else if(passwordValue !== password2Value) {
            che = 1;
            setErrorFor(password2, 'Пароли не совпадают, запомните ваш пароль');
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

function passCheck(pass) {
	return /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{5,16}$/.test(pass);
}