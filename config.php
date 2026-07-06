<?php
declare(strict_types=1);

session_start();

// base de donnees
$db      = 'forum_maisonneuve';
$user    = 'root';
$pass    = '12378';
$charset = 'utf8mb4';

$dsn = "mysql:unix_socket=/tmp/mysql.sock;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lève des exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // retourne des tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                   // requêtes préparées natives (protection injection SQL)
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données.');
} 
