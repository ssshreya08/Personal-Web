<?php
// Database connection
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=Website', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate form data
    if (!empty($first_name) && !empty($last_name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phone) && !empty($subject) && !empty($message)) {
        // Insert data into the database
        $sql = "INSERT INTO contacts (first_name, last_name, email, phone, subject, message) VALUES (:first_name, :last_name, :email, :phone, :subject, :message)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Error inserting data!";
        }
    } else {
        echo "Please provide valid inputs for all fields.";
    }
}
?>
