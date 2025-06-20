<?php
// --- Database Configuration ---
$host = "localhost";
$username = "root";      // MySQL username (default for XAMPP/WAMP)
$password = "";          // MySQL password (empty by default in local setups)
$database = "railway";   // Name of your MySQL database

// --- Create a new MySQL connection ---
$conn = new mysqli($host, $username, $password, $database);

// --- Check connection ---
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Handle Deletion ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    $deleteStmt = $conn->prepare("DELETE FROM tour_requests WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);

    if ($deleteStmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $deleteStmt->error;
    }

    $deleteStmt->close();
    $conn->close();
    exit();
}

// --- Collect data sent via POST method from the HTML form ---
$officerName = $_POST['officerName'] ?? '';
$designation = $_POST['designation'] ?? '';
$leavingDate = $_POST['leavingDate'] ?? '';
$returnDate = $_POST['returnDate'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$location = $_POST['location'] ?? '';
$type = $_POST['type'] ?? '';

// --- Check if any field is empty ---
if (!$officerName || !$designation || !$leavingDate || !$returnDate || !$purpose || !$location || !$type) {
    die("All fields are required."); // Show error if any required field is missing
}

// --- Prepare the SQL INSERT statement with placeholders to avoid SQL injection ---
$stmt = $conn->prepare("INSERT INTO tour_requests (officer_name, designation, leaving_date, return_date, purpose, location, type)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

// --- Bind the variables to the placeholders in the prepared statement ---
$stmt->bind_param("sssssss", $officerName, $designation, $leavingDate, $returnDate, $purpose, $location, $type);

// --- Execute the SQL statement ---
if ($stmt->execute()) {
    header("Location: toursuccessful.html"); // Redirect to success page if insert is successful
    exit();
} else {
    echo "Error: " . $stmt->error; // Display error message if insert fails
}

// --- Close the statement and the database connection ---
$stmt->close();
$conn->close();
?>
