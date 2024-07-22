const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');

var modal = document.getElementById("contactModal");
var contactLink = document.querySelector(".navigation a:nth-child(4)");
var span = document.getElementsByClassName("close")[0];

var aboutModal = document.getElementById("aboutModal");
var aboutLink = document.getElementById("aboutLink");
var closeAboutModal = aboutModal.querySelector(".close");

var homeLink = document.getElementById("homeLink");

// Function to close contact modal
function closeContactModal() {
    modal.style.display = "none";
}

// Function to close about modal
function closeAboutModalFunc() {
    aboutModal.style.display = "none";
}

registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
    wrapper.classList.remove('active');
});

contactLink.onclick = function () {
    modal.style.display = "block";
    closeAboutModalFunc(); // Close about modal if open
}

aboutLink.onclick = function (event) {
    event.preventDefault();
    closeContactModal();
    aboutModal.style.display = "block";
}

closeAboutModal.onclick = function () {
    aboutModal.style.display = "none";
}

span.onclick = function () {
    modal.style.display = "none";
}

homeLink.onclick = function (event) {
    event.preventDefault();
    modal.style.display = "none";
    aboutModal.style.display = "none";
    wrapper.classList.remove('active');
    wrapper.classList.remove('active-popup');
}

var forgotPasswordModal = document.getElementById("forgotPasswordModal");

// Get the button that opens the modal
var forgotPasswordLink = document.querySelector(".forgot-password-link");

// Get the <span> element that closes the modal
var closeForgotPasswordModal = document.querySelector("#forgotPasswordModal .close");

// When the user clicks on the link, open the modal
forgotPasswordLink.onclick = function () {
    forgotPasswordModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeForgotPasswordModal.onclick = function () {
    forgotPasswordModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == forgotPasswordModal) {
        forgotPasswordModal.style.display = "none";
    }
}

// Handle dynamic input box creation
var additionalInputBox = document.getElementById("additionalInputBox");
var addInputBoxBtn = document.getElementById("addInputBoxBtn");

addInputBoxBtn.addEventListener('click', function () {
    var newInputBox = document.createElement('div');
    newInputBox.classList.add('input-box');
    newInputBox.innerHTML = `
        <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
        <input type="password" placeholder="Enter temporary code" required>
    `;
    additionalInputBox.appendChild(newInputBox);
});