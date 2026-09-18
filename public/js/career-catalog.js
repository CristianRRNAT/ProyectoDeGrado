document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".catalog-search");
    const searchIcon = form?.querySelector(".search-input > span");
    if (!form || !searchIcon) return;

    searchIcon.setAttribute("role", "button");
    searchIcon.setAttribute("tabindex", "0");
    searchIcon.setAttribute("aria-label", "Buscar carrera");
    searchIcon.title = "Buscar";

    const submitSearch = () => form.requestSubmit();
    searchIcon.addEventListener("click", submitSearch);
    searchIcon.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            submitSearch();
        }
    });
});
