<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myclassmates";

 // Create connection for database
$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$name = "";
$email = "";
$contact_number = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //GET METHOD THAT SHOWS THE DATA OF THE CLASSMATE
    if(!isset($_GET["id"])){
        header("location: /myclassmates/index.php");
        exit;
    }

    $id = $_GET["id"];

    //READ THE ROW OF THE SELECTED CLIENT FROM THE DATABASE TABLE
    $sql = "SELECT * FROM classmates WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header("location: /myclassmates/index.php");
        exit;
    }
    $name = $row['name'];
    $email = $row['email'];
    $contact_number = $row['contact_number'];
    $address = $row['address'];


}
else{
    //POST METHOD THAT UPDATE THE DATA OF THE CLASSMATE
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    do{
        if (empty($id) || empty($name) || empty($email) || empty($contact_number) || empty($address)){
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "UPDATE classmates SET name = ?, email = ?, contact_number = ?, address = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);

        // Check if preparation was successful
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($connection->error));
        }

        $stmt->bind_param("ssssi", $name, $email, $contact_number, $address, $id);

        if ($stmt->execute()) {
            $successMessage = "Classmate updated successfully!";
            header("Location: /myclassmates/index.php");
            exit;
        } else {
            $errorMessage = "Error executing query: " . htmlspecialchars($stmt->error);
        }

        // Close the statement
        $stmt->close();

        $successMessage = "New Classmate is added correctly!";

        header("location: /myclassmates/index.php");
        exit;

    }while(false);
}


?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Classmates</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>

  <div class="container px-10">

     <h2 class="mt-10">New Classmate</h2> 

     <?php
     if (!empty($errorMessage)){
        echo "
        <div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400' role='alert'>
            <span class='font-medium'>$errorMessage</span>
        </div>
        ";
     }
     ?>

    <form method="post" class="max-w-sm mx-auto mt-5">

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Name</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Name" required />
        </div>

        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@classmate.com" required />
        </div>

        <div class="mb-5">
            <label for="contact_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contact number (0912-3456-789)" required />
        </div>

        <div class="mb-5">
            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Home Address</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Address" required />
        </div>

        <?php
        if(!empty($successMessage)){
            echo "
            <div class='p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400' role='alert'>
            <span class='font-medium'>$successMessage</span>
            </div>
            ";
        }

        ?>
        
        <div class="action-buttons text-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            <button type="button" class="text-gray-900 bg-white border border-gray-700 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" onclick="window.location.href='/myclassmates/index.php'">Cancel</button>
        </div>
    </form>

    
    

  </div>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

</body>
</html>