<?php

session_start();
spl_autoload_register();

$template = new \Core\Template();
$dataBinder = new \Core\DataBinder();
$dbInfo = parse_ini_file("Config/db.ini");
$pdo = new PDO($dbInfo['dsn'], $dbInfo['user'], $dbInfo['pass']);
$db = new \Database\PDODatabase($pdo);
$userRepository = new \App\Repository\UserRepository($db, $dataBinder);
$bookRepository = new \App\Repository\Books\BookRepository($db, $dataBinder);
$encryptionService = new \App\Service\Encryption\ArgonEncryptionService();
$userService = new \App\Service\UserService($userRepository, $encryptionService);
$bookService = new \App\Service\Books\BookService($bookRepository, $userService);
$userHttpHandler = new \App\Http\UserHttpHandler($template, $dataBinder);
$bookHttpHandler = new \App\Http\BookHttpHandler($template, $dataBinder, $bookService, $userService);