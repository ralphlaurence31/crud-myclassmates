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
    
    <h2 class="mt-10 mb-5">List of Classmates</h2>
    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" onclick="window.location.href='/myclassmates/create.php'">Add Classmate</button>
    <br>

    <table class="table">
      
      <div class="relative overflow-x-auto">
        <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class='border-b border-gray-300 dark:border-gray-700'>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NAME
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EMAIL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        CONTACT NUMBER
                    </th>
                    <th scope="col" class="px-6 py-3">
                      ADDRESS
                  </th>
                  <th scope="col" class="px-6 py-3">
                      CREATED AT
                  </th>
                  <th scope="col" class="px-6 py-3">
                      ACTION
                  </th>
                </tr>
            </thead>
      
            <tbody>

              <?php 
              $servername = "localhost";
              $username = "root";
              $password = "";
              $database = "myclassmates";

              // Create connection for database
              $connection = new mysqli($servername, $username, $password, $database);

              //CHECK CONNECTION
              if ($connection->connect_error){
                die("Connection Failed: " .$connection->connect_error);
              }

              //READ ALL THE ROW FROM DATABASE TABLE
              $sql = "SELECT * FROM classmates";
              $result = $connection->query($sql);

              if (!$result){
                die("Invalid query: " .$connection->error);              
              }

              //READ THE DATA OR INFORMATION EACH ROW
              while($row = $result->fetch_assoc()){
                echo "
                <tr class='border-b border-gray-300 dark:border-gray-700'>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['contact_number']}</td>
                  <td>{$row['address']}</td>
                  <td>{$row['created_at']}</td>
                  <td>
                    <button type='button' class='focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' onclick=\"window.location.href='/myclassmates/edit.php?id={$row['id']}'\">Edit</button>
                    <button type='button' class='focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900' onclick=\"window.location.href='/myclassmates/delete.php?id={$row['id']}'\">Delete</button>
                  </td>
                </tr>
                ";
              }

              ?>
              
            </tbody>
        </table>
      </div>

    </table>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

</body>
</html>