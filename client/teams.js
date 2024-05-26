document.addEventListener("DOMContentLoaded", () => {
    const teams = [
        { name: "Los Angeles Lakers", description: "Описание" },
        { name: "Команда 2", description: "Описание команды 2" },
        { name: "Команда 3", description: "Описание команды 3" },
    ];

    const teamsContainer = document.querySelector(".teams-container");
    teams.forEach(team => {
        const teamItem = document.createElement("section");
        teamItem.classList.add("team-item");
        teamItem.innerHTML = `<h3>${team.name}</h3><p>${team.description}</p>`;
        teamsContainer.appendChild(teamItem);
    });
});