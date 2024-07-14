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

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', ()=> {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-popup');
    wrapper.classList.remove('active');
});

contactLink.onclick = function() {
    modal.style.display = "block";
    closeAboutModalFunc(); // Close about modal if open
}

aboutLink.onclick = function(event) {
    event.preventDefault();
    closeContactModal();
    aboutModal.style.display = "block";
}

closeAboutModal.onclick = function() {
    aboutModal.style.display = "none";
}

span.onclick = function() {
    modal.style.display = "none";
}

homeLink.onclick = function(event) {
    event.preventDefault();
    modal.style.display = "none";
    aboutModal.style.display = "none";
    wrapper.classList.remove('active');
    wrapper.classList.remove('active-popup');
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Basic authentication logic (replace with server-side validation in real application)
        if (username === 'admin' && password === 'adminpassword') {
            window.location.href = 'admin_dashboard.html'; // Redirect admin to admin dashboard
        } else if (username === 'user' && password === 'userpassword') {
            window.location.href = 'dashboard.html'; // Redirect standard user to standard dashboard
        } else {
            alert('Invalid username or password');
        }
    });
});