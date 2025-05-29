<?php
require_once("../../../pages/connect.php");

if (!isset($_GET['id'])) {
    header("Location: management.php?error=invalid_id");
    exit();
}

$id = (int)$_GET['id'];

try {
    // Start transaction
    $conn->begin_transaction();

    // Delete booking details first (foreign key constraint)
    $stmt = $conn->prepare("DELETE FROM booking_details WHERE booking_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Then delete the booking
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    // Redirect with success message
    header("Location: management.php?success=delete");
    exit();

} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();

    // Log error for debugging (optional)
    error_log("Error deleting booking #$id: " . $e->getMessage());
    
    // Redirect with error message
    header("Location: management.php?error=delete");
    exit();
}