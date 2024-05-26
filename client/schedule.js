document.addEventListener("DOMContentLoaded", () => {
    const schedule = [
        { date: "03.06.2024", match: "Los Angeles Lakers vs Golden State Warriors" },
        { date: "10.06.2024", match: "Phoenix Suns vs Dallas Mavericks" },
        { date: "17.06.2024", match: "Milwaukee Bucks vs Brooklyn Nets" }
    ];

    const scheduleContainer = document.querySelector(".schedule-container");
    schedule.forEach(game => {
        const gameItem = document.createElement("section");
        gameItem.classList.add("game-item");
        gameItem.innerHTML = `<h3>${game.date}</h3><p>${game.match}</p>`;
        scheduleContainer.appendChild(gameItem);
    });
});