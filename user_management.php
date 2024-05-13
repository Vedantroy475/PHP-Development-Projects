<?php
// Database credentials
$servername = "your_mysql_servername"; // Replace with your MySQL server name
$username = "your_mysql_username"; // Replace with your MySQL username
$password = "your_mysql_password"; // Replace with your MySQL password
$database = "user_management_system"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// User registration
if(isset($_POST['register'])){
    // Sanitize input data
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// User login
if(isset($_POST['login'])){
    // Sanitize input data
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management System</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="hidden" name="csrf_token" value="<?php echo uniqid(); ?>"> <!-- CSRF protection -->
        <button type="submit" name="register">Register</button>
    </form>

    <h2>User Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="hidden" name="csrf_token" value="<?php echo uniqid(); ?>"> <!-- CSRF protection -->
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
