<?php
// データベースに接続
define('DSN', 'mysql:host=17bc9bb41b81;dbname=image');
define('DB_USER', 'root');
define('DB_PASS', 'secret');
function connectDB() {
    try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        return $pdo;

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
?>
