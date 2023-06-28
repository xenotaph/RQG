<?php
// Include database connection file
include 'db_connect.php';

// Get character ID from POST request
$id = $_POST['id'];

// Prepare SQL query to select the character
$query = "SELECT * FROM characters WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id);

// Execute SQL query
$stmt->execute();
$result = $stmt->get_result();
$character = $result->fetch_assoc();

// Prepare SQL query to insert the character into the deleted_characters table
$query = "INSERT INTO deleted_characters SELECT * FROM characters WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id);

// Log SQL query
error_log('SQL query: ' . $query);

// Execute SQL query
if ($stmt->execute()) {
    // Query was successful, log success message
    error_log('Insertion into deleted_characters was successful.');
    
    // Now delete the character from the characters table
    $query = "DELETE FROM characters WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Redirect to load_character.php
    header('Location: load_character.php');
    exit;
} else {
    // Insertion into deleted_characters failed, show error message
    echo 'Failed to move character to deleted_characters: ' . $stmt->error;
    // Log detailed error message
    error_log('Detailed error: ' . print_r($db->errorInfo(), true));
}
?>
