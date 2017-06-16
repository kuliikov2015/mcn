<?php
$host = 'localhost';
$name = 'mcn';
$user = 'homestead';
$pass = 'secret';


$db = new PDO("mysql:host={$host};dbname={$name}", $user, $pass);

$items = $steel_types = $roll_types = [];
foreach ($db->query('SELECT * FROM items', PDO::FETCH_ASSOC) as $row) {
    $items[$row['id']] = $row;
};
foreach ($db->query('SELECT * FROM steel_types', PDO::FETCH_ASSOC) as $row) {
    $steel_types[$row['id']] = $row;
};
foreach ($db->query('SELECT * FROM roll_types', PDO::FETCH_ASSOC) as $row) {
    $roll_types[$row['id']] = $row;
};

return [$items, $steel_types, $roll_types];