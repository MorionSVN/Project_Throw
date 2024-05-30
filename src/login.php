<?php
$db = new mysqli('localhost', 'reverendo', 'Synyster7', 'reverendo_throw');

$query = (
    "SELECT id FROM users 
        WHERE `login`='${_POST["login"]}' AND `password`=MD5('${_POST["password"]}')"
);

$result = $db->query($query);

if ($result->num_rows) {
    header('Location: index.php');
} else {
    header('Location: index.php');
}