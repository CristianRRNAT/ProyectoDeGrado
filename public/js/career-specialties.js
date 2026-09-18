document.addEventListener("DOMContentLoaded", () => {
    const institutions = Array.isArray(window.careerInstitutions) ? window.careerInstitutions : [];
    const institutionsBox = document.querySelector(".institutions-box");
    if (institutionsBox && institutions.length > 5) {
        institutionsBox.querySelectorAll(":scope > p").forEach((paragraph) => {
            if (paragraph.textContent.trim().startsWith("Y ") && paragraph.textContent.includes("instituciones más")) {
                paragraph.remove();
            }
        });

        const openButton = document.createElement("button");
        openButton.type = "button";
        openButton.className = "show-all-institutions";
        openButton.innerHTML = "<span>Ver todas las instituciones</span><b>" + institutions.length + "</b>";
        institutionsBox.appendChild(openButton);

        const modal = document.createElement("div");
        modal.className = "institutions-modal";
        modal.hidden = true;
        modal.innerHTML = '<div class="institutions-modal-backdrop"></div><section class="institutions-modal-panel" role="dialog" aria-modal="true" aria-labelledby="institutions-modal-title"><header><div><small>OFERTA ACADÉMICA</small><h2 id="institutions-modal-title">Instituciones disponibles</h2><p>' + institutions.length + ' opciones registradas para esta carrera.</p></div><button type="button" class="institutions-modal-close" aria-label="Cerrar">×</button></header><div class="institutions-modal-list"></div></section>';
        document.body.appendChild(modal);

        const list = modal.querySelector(".institutions-modal-list");
        institutions.forEach((institution) => {
            const link = document.createElement("a");
            link.href = institution.url;
            const name = document.createElement("b");
            const location = document.createElement("span");
            const details = document.createElement("small");
            name.textContent = institution.name;
            location.textContent = institution.location;
            details.textContent = institution.level + " · " + institution.modality;
            link.append(name, location, details);
            list.appendChild(link);
        });

        const closeButton = modal.querySelector(".institutions-modal-close");
        const close = () => {
            modal.hidden = true;
            document.body.classList.remove("modal-open");
            openButton.focus();
        };
        const open = () => {
            modal.hidden = false;
            document.body.classList.add("modal-open");
            closeButton.focus();
        };
        openButton.addEventListener("click", open);
        closeButton.addEventListener("click", close);
        modal.querySelector(".institutions-modal-backdrop").addEventListener("click", close);
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && !modal.hidden) close();
        });
    }

    const about = document.querySelector(".detail-main > article:first-child");
    if (!about) return;

    const grid = [...about.querySelectorAll(".scope-grid")].find((item) => item.querySelector("h3"));
    if (!grid) return;

    const heading = grid.previousElementSibling?.previousElementSibling;
    const introduction = grid.previousElementSibling;
    if (heading?.tagName === "H3") heading.textContent = "ESPECIALIDADES";
    if (introduction?.tagName === "P") {
        introduction.textContent = "Selecciona una especialidad para conocer brevemente en qué consiste. Su disponibilidad puede variar según la institución.";
        introduction.classList.add("specialties-intro");
    }

    grid.classList.add("specialties-grid");
    grid.querySelectorAll(":scope > div").forEach((card, index) => {
        const title = card.querySelector("h3");
        const description = card.querySelector("p");
        const icon = card.querySelector(":scope > span");
        if (!title || !description) return;

        card.classList.add("specialty-card");
        card.tabIndex = 0;
        card.setAttribute("role", "button");
        card.setAttribute("aria-expanded", "false");
        description.id = "specialty-description-" + index;
        card.setAttribute("aria-controls", description.id);
        if (icon) icon.innerHTML = '<i class="bi bi-chevron-down" aria-hidden="true"></i>';

        const toggle = () => {
            const open = card.classList.toggle("is-open");
            card.setAttribute("aria-expanded", String(open));
        };
        card.addEventListener("click", toggle);
        card.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                toggle();
            }
        });
    });

    const professionalArticle = [...document.querySelectorAll(".detail-main > article")].find((article) =>
        article.querySelector("h2")?.textContent.trim().toLowerCase().includes("campo laboral")
    );
    if (!professionalArticle) return;

    professionalArticle.classList.add("professional-field-card");
    const professionalGrid = professionalArticle.querySelector(".scope-grid");
    if (!professionalGrid) return;

    const illustration = document.createElement("div");
    illustration.className = "professional-illustration";
    illustration.setAttribute("aria-hidden", "true");
    professionalArticle.appendChild(illustration);

    const illustrations = [
        {
            type: "laboral",
            label: "Campo laboral",
            icon: "bi-briefcase-fill",
            accent: "bi-buildings",
        },
        {
            type: "economico",
            label: "Ámbito económico",
            icon: "bi-graph-up-arrow",
            accent: "bi-currency-dollar",
        },
        {
            type: "social",
            label: "Ámbito social",
            icon: "bi-people-fill",
            accent: "bi-heart-fill",
        },
    ];

    const drawIllustration = (item) => {
        illustration.dataset.type = item.type;
        illustration.innerHTML = '<span class="illustration-orbit"></span><i class="bi ' + item.icon + ' illustration-main"></i><i class="bi ' + item.accent + ' illustration-accent"></i><small>' + item.label + '</small>';
    };

    drawIllustration(illustrations[0]);
    professionalGrid.querySelectorAll(":scope > div").forEach((card, index) => {
        const item = illustrations[index + 1];
        if (!item) return;
        card.classList.add("professional-scope-card");
        card.tabIndex = 0;
        card.addEventListener("pointerenter", () => drawIllustration(item));
        card.addEventListener("pointerleave", () => drawIllustration(illustrations[0]));
        card.addEventListener("focusin", () => drawIllustration(item));
        card.addEventListener("focusout", () => drawIllustration(illustrations[0]));
    });
});
