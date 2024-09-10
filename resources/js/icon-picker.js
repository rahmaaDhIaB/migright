/**
 * @constructor
 * @param {string} buttonSelectors
 * @param {string} inputSelectors
 * @param {string} modalSelectors
 */
async function IconPicker(buttonSelectors, inputSelectors, modalSelectors) {
    const button = document.querySelector(buttonSelectors);
    const input = document.querySelector(inputSelectors);
    const modal = document.querySelector(modalSelectors);

    if (!button || !modal || !input) {
        console.warn("Unable to find one of the required elements");
        return;
    }

    /** @type {HTMLElement|null} */
    let current = null;

    function updateButton(value) {
        if (value === "") {
            button.innerHTML = button.dataset.placeholder;
            return;
        }

        const icon = document.createElement("i");

        icon.style.setProperty("font-size", "30px");

        value.split(" ").forEach((className) => {
            icon.classList.add(className);
        });

        button.innerHTML = "";

        button.appendChild(icon);
    }

    if (input.value) {
        updateButton(input.value);
    }

    await fetchJSON().then((icons) => {
        const body = modal.querySelector(".modal-body");

        body.innerHTML = "";

        const classNames = Object.values(icons);

        classNames.forEach((classNames) => {
            const iconOption = option(classNames);

            if (classNames === input.value) {
                iconOption.classList.add("btn-success");
                current = iconOption;
            }

            iconOption.addEventListener("click", function (event) {
                if (iconOption.classList.contains("btn-success")) {
                    iconOption.classList.remove("btn-success");
                    current = null;
                    updateButton("");
                    input.setAttribute("value", "");
                    return;
                }

                current?.classList.remove("btn-success");
                iconOption.classList.add("btn-success");
                button.classList.remove("is-invalid");
                input.setAttribute("value", classNames);
                current = iconOption;
                updateButton(classNames);
            });

            body.appendChild(iconOption);
        });
    });
}

/**
 * @function ClickCallback
 * @param {MouseEvent} event
 */

/**
 * @function option - create icon option
 * @param {string} iconClassNames
 * @returns {HTMLElement}
 */
function option(iconClassNames) {
    const container = document.createElement("div");

    container.classList.add("btn");
    container.classList.add("d-flex");
    container.classList.add("btn-outline-dark");

    const icon = document.createElement("i");

    icon.style.setProperty("font-size", "30px");
    icon.style.setProperty("width", "30px");
    icon.style.setProperty("height", "30px");

    addClassNames(icon, iconClassNames);

    container.appendChild(icon);

    return container;
}

/**
 * @function addClassNames
 * @param {HTMLElement} element
 * @param {string} classNames
 */
function addClassNames(element, classNames) {
    classNames.split(" ").forEach((className) => {
        element.classList.add(className);
    });
}

function fetchJSON() {
    return fetch("/fontawesome.json")
        .then((response) => response.json())
        .catch((error) => {
            console.log("error", error);
        });
}

export default IconPicker;
