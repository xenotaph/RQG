<?php
// Log POST data
error_log(print_r($_POST, true));
// Include database connection file
include 'db_connect.php';
include 'session.php';
//include 'menu.php';


// Get character data from POST request
$character = $_POST;

// Convert all checkbox values to integers
foreach ($character as $field => $value) {
    if (is_bool($value)) {
        $character[$field] = $value ? 1 : 0;
    }
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Prepare SQL query
if (isset($character['id'])) {
    // Update existing character
    $query = "UPDATE characters SET ";
    $values = [];
    foreach ($character as $field => $value) {
        if ($field != 'id') {
            $query .= "$field = ?, ";
            $values[] = $value;
        }
    }
    $query = rtrim($query, ', ');
    $query .= " WHERE id = ?";
    $values[] = $character['id'];
    $stmt = $db->prepare($query);
    $stmt->bind_param(str_repeat('s', count($values)), ...$values);
    // Debug: Print the final SQL query
    $debugQuery = str_replace('?', "'%s'", $query);
    $debugQuery = sprintf($debugQuery, ...$values);
    error_log("Debug SQL query: $debugQuery");
} else {
    // Insert new character
    $character['user_id'] = $user_id;  // Add user_id to character data
    $fields = array_keys($character);
    $query = "INSERT INTO characters (" . implode(', ', $fields) . ") VALUES (" . str_repeat('?, ', count($fields) - 1) . "?)";
    $values = array_values($character);
    $stmt = $db->prepare($query);
    $stmt->bind_param(str_repeat('s', count($values)), ...$values);
    // Debug: Print the final SQL query
    $debugQuery = str_replace('?', "'%s'", $query);
    $debugQuery = sprintf($debugQuery, ...$values);
    error_log("Debug SQL query: $debugQuery");
}

// Log SQL query
error_log('SQL query: ' . $query);

// Log values
error_log('Values: ' . print_r($values, true));

// Execute SQL query
if ($stmt->execute()) {
    // Query was successful
    if (!isset($character['id'])) {
        // If a new character was inserted, get the last inserted ID
        $character['id'] = $db->insert_id;
    }
    echo json_encode(['success' => true, 'id' => $character['id']]);
} else {
    // Query failed
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}
