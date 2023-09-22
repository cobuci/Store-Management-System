const button = document.querySelector(".dark-toogle");

button.addEventListener("click", () => {
    // Ative o dark mode
    document.body.classList.toggle("dark");

    // Salve o estado no localstorage
    localStorage.setItem("dark_mode", document.body.classList.contains("dark"));
});

// Recupera o estado do localstorage
const isDarkMode = localStorage.getItem("dark_mode") === "true";

if (isDarkMode) {
    document.body.classList.add("dark");
} else {
    document.body.classList.remove("dark");
}
