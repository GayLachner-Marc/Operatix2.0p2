<?php
$pdo = new PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT id_viajero, password FROM transfer_viajeros");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id_viajero'];
    $password = $row['password'];

    // Solo hasheamos si aún no lo está
    if (strpos($password, '$2y$') !== 0) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        $update = $pdo->prepare("UPDATE transfer_viajeros SET password = ? WHERE id_viajero = ?");
        $update->execute([$hashed, $id]);

        echo "Contraseña actualizada para ID $id<br>";
    } else {
        echo "Ya estaba hasheada (ID $id)<br>";
    }
}
?>
