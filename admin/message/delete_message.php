<?php
include '../../includes/koneksi.php';
$admin_name = $_SESSION['admin_name'];

function deleteMessage($id) {
    global $link;

    // Pastikan ID valid
    $id = intval($id);

    $query = "DELETE FROM messages WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
