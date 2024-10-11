<?php
// Check if the 'id' parameter is set in the GET request
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); // Sanitize the input

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "myclassmates";

    // Create connection for database
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare and execute the delete query
    $sql = "DELETE FROM classmates WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($connection->error));
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to index.php on successful deletion
        header("Location: /myclassmates/index.php");
        exit;
    } else {
        echo "Error executing query: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
} else {
    // Redirect to index.php if 'id' parameter is not set
    header("Location: /myclassmates/index.php");
    exit;
}
?>
