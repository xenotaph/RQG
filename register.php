<?php
// Include database connection file
include 'db_connect.php';
include 'session.php';
include 'menu.php';


// Check if user is admin
if ($role != 'admin') {
    die('You must be an admin to register a new user.');
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user data from POST request
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $status = 'pending';
    $token = bin2hex(random_bytes(50)); // Generate a random token

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die('A user with this email already exists.');
    }

    // Prepare SQL query
    $query = "INSERT INTO users (email, password, role, status, token) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sssss', $email, $password, $role, $status, $token);

    // Execute SQL query
    if ($stmt->execute()) {
        echo 'Registration successful. Please send the following activation link to the user: ';
        echo "<a href='activate.php?token=$token'>Activate account</a>";
    } else {
        echo 'Failed to register: ' + $stmt->error;
    }
}
?>




<!-- HTML form goes here -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
