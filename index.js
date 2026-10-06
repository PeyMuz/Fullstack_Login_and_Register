const authModal = document.querySelector('.auth-modal');
const loginModal = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const loginBtnModal = document.querySelector('.login-btn-modal');
const closeBtnModal = document.querySelector('.close-btn-modal');


registerLink.addEventListener("click", () => authModal.classList.add('slide'));
loginModal.addEventListener("click", () => authModal.classList.remove('slide'));


//This code functions if the user clicked the login button from the navbar. It will also close if the user clicked X btn.
loginBtnModal.addEventListener("click", () => authModal.classList.add('show'));
closeBtnModal.addEventListener("click", () => authModal.classList.remove('show', 'slide'));