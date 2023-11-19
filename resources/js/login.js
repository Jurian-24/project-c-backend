// import './bootstrap';
import { checkInputEmail } from './check.js';

const dropdownMenu = document.querySelector('#dropdown'),
    dropdownBtn = document.querySelector(".dropdown_btn"),
    dropdownBtnText = document.querySelector(".dropdown_btn span"),
    dropdownOptions = document.querySelectorAll(".dropdown_option");

// dropdown menu toggle
dropdownBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("dropdown_active");
});

// dropdown menu events
dropdownOptions.forEach(option => {
    option.addEventListener("click", () => {
        let selectedOption = option.querySelector("span").innerText;
        selectedOption.innerHTML = "{{ config('app.locale') }}";
        dropdownBtnText.innerText = selectedOption;
        dropdownMenu.classList.toggle("dropdown_active");
    });
})

// forget password
const forgetPassword = document.querySelector(".forget_password");
const inputEmail = document.querySelector("#email");
const inputEmailLabel = document.querySelector(".email_label");
forgetPassword.addEventListener("click", () => {
    if (! checkInputEmail(inputEmail.value)) {
        inputEmailLabel.style.display = "block";
    }
    else {
        location.href = "/forget-password";
    }
});
