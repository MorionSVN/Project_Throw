document.getElementById("registration-form").addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const responseMessage = document.getElementById("response-message");

    try {
        const response = await fetch("reg.php", {
            method: "POST",
            body: formData
        });

        if (response.ok) {
            const result = await response.text();
            responseMessage.innerHTML = "Регистрация прошла успешно!";
            window.location.href = "../index.php";
        } else {
            responseMessage.innerHTML = "Ошибка регистрации. Попробуйте снова.";
        }
    } catch (error) {
        responseMessage.innerHTML = "Ошибка регистрации. Попробуйте снова.";
    }
});