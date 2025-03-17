<?php 
include_once("db.php");
$dsn = "mysql:host=$server;dbname=$db;charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $userdb, $passdb, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);

  $queryCheckUser = "SELECT COUNT(*) FROM mysql.user WHERE user = 'mytbk';";
  $userExists = $pdo->query($queryCheckUser)->fetchColumn();

  if ($userExists == 0) {
    $queryCreateUser = "CREATE USER 'mytbk'@'%' IDENTIFIED BY 'admintbk';
            GRANT USAGE ON *.* TO 'mytbk'@'%' REQUIRE NONE;";
    $pdo->exec($queryCreateUser);
    // echo "<span style='color:green;'>User berhasil dibuat!</span><br>";
  }

  // $queryGrantPrivileges = "GRANT ALL PRIVILEGES ON `" . str_replace('_', '\_', $db) . "`.* TO 'mytbk'@'%' WITH GRANT OPTION;";
  $queryGrantPrivileges = "GRANT ALL PRIVILEGES ON `$db`.* TO 'mytbk'@'%' WITH GRANT OPTION;";

  $pdo->exec($queryGrantPrivileges);
  // echo "<span style='color:green;'>Hak akses berhasil diberikan!</span>";
} catch (PDOException $e) {
  echo "<span style='color:red;'>Gagal: " . $e->getMessage() . "</span>";
}
?>