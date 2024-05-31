<?php
header('Content-Type: application/json');

$db = new mysqli('localhost', 'reverendo_throw', 'Synyster7', 'reverendo_throw');

if ($db->connect_error) {
    die(json_encode(['error' => 'Ошибка соединения: ' . $db->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $db->real_escape_string($_POST['Mail']);
    $password = $db->real_escape_string($_POST['Password']);

    $query = "INSERT INTO USERS (`Mail`, `Password`) VALUES ('$mail', '$password')";

    if ($db->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Ошибка: ' . $db->error]);
    }
}

$db->close();
?>