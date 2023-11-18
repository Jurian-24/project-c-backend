const dropdownMenu = document.querySelector('#dropdown'),
    dropdownBtn = document.querySelector(".dropdown_btn"),
    dropdownBtnIcon = document.querySelector(".dropdown_btn i"),
    dropdownBtnText = document.querySelector(".dropdown_btn span"),
    dropdownOption = document.querySelector(".dropdown_options"),
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