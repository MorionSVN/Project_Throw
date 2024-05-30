<?php
$db = new mysqli('localhost', 'reverendo_throw', 'Synyster7', 'reverendo_throw');

if ($db -> connect_error) {
    die('Ошибка соединения: ' . $db -> connect_error);
}

$mail = $db -> real_escape_string($_POST['Mail']);
$password = $db->real_escape_string($_POST['Password']);

$query = "INSERT INTO USERS (`Mail`, `Password`) VALUES ('$mail', '$password')";

if ($db->query($query)) {
    header('Location: ../index.php');
} else {
    echo "Ошибка: " . $db->error;
}

$db->close();
?>