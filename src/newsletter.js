document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".subscribeForm").addEventListener("submit", function (event) {
        event.preventDefault();
        let email = document.getElementById("email").value;
        let message = document.getElementById("message");

        if (validateEmail(email)) {
            message.textContent = "Вы подписались на рассылку.";
            message.style.color = "#00ff00";
        } else {
            message.textContent = "Пожалуйста, введите правильную электронную почту.";
            message.style.color = "#ff0000";
        }
    });

    function validateEmail(email) {
        let re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }
});