<?php
// update_ticket.php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (empty($id) || empty($status)) {
        header("Location: admin.php?error=missing_data");
        exit();
    }

    try {
        $stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        header("Location: admin.php?success=updated");
        exit();

    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>
