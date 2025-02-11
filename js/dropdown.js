const customUrl = {
    maldives: 'https://maldives-packages.outmazedtourism.com/',
};

function appendDropdownToElement(triggerId) {
    const triggerElement = document.getElementById(triggerId);

    if (triggerElement) {
        triggerElement.style.position = "relative";

        // Create the dropdown menu
        const dropdownMenu = document.createElement("ul");
        dropdownMenu.classList.add("dropdown-content");
        dropdownMenu.style.display = "none"; // Hide by default
        dropdownMenu.style.position = "absolute";

        // Append the dropdown menu to the trigger element
        triggerElement.appendChild(dropdownMenu);

        // Add hover behavior
        triggerElement.addEventListener("mouseenter", () => {
            dropdownMenu.style.display = "block";
        });

        document.addEventListener("click", (event) => {
            if (!triggerElement.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = "none";
            }
        });

        const url = window.location.origin + '/wp-json/custom-api/v1/menu';

        const xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const responseData = JSON.parse(xhr.responseText);

                    if (Array.isArray(responseData) && responseData.length > 0) {
                        responseData.forEach((item) => {
                            const { endpoint_url: link, title: name } = item;
                            const listItem = document.createElement("li");
                            const linkElement = document.createElement("a");

                            if (name === 'Maldives') {
                                linkElement.href = customUrl.maldives;
                            } else {
                                linkElement.href = link;
                            }

                            linkElement.textContent = name;
                            listItem.appendChild(linkElement);
                            dropdownMenu.appendChild(listItem);
                        });
                    } else {
                        const listItem = document.createElement("li");
                        listItem.textContent = "No data available";
                        dropdownMenu.appendChild(listItem);
                    }
                } else {
                    const listItem = document.createElement("li");
                    listItem.textContent = "Failed to fetch data";
                    dropdownMenu.appendChild(listItem);
                }
            }
        };

        xhr.send();
    } else {
        console.error(`Element with ID ${triggerId} not found.`);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const element431 = document.getElementById("menu-item-431");
    const element490 = document.getElementById("menu-item-490");
    if (element431) {
        appendDropdownToElement("menu-item-431");
    }
    if (element490) {
        appendDropdownToElement("menu-item-490");
    }
});