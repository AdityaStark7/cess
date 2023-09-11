<!-- <?php
// Database connection details
// $servername = "localhost";   // The hostname of your MySQL server (usually "localhost" for XAMPP)
// $username = "root";          // MySQL username (default is "root" for XAMPP)
// $password = "";              // MySQL password (default is empty for XAMPP)
// $dbname = "cess_notices";    // The name of your database

// // Create a connection to MySQL
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Check if the form was submitted
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Collect form data
//     $type = $_POST["type"];
//     $district = $_POST["district"];
//     $date = $_POST["date"];
//     $company = $_POST["company"];

//     // Validate and process date (you can add more validation here)
//     $dateParts = explode('/', $date);
//     if (count($dateParts) === 3) {
//         $day = intval($dateParts[0]);
//         $month = intval($dateParts[1]);
//         $year = intval($dateParts[2]);

//         // Create a valid date string for MySQL
//         $mysqlDate = date("Y-m-d", strtotime("$year-$month-$day"));

//         // Insert data into the database
//         $sql = "INSERT INTO notices ('type', district, 'date', company) VALUES (?, ?, ?, ?)";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("ssss", $type, $district, $mysqlDate, $company);

//         if ($stmt->execute()) {
//             echo "Data inserted into the database successfully";
//         } else {
//             echo "Error inserting data into the database: " . $stmt->error;
//         }

//         $stmt->close();
//     } else {
//         echo "Invalid date format. Please use DD/MM/YYYY format.";
//     }
// }

// // Close the database connection
// $conn->close();
//?>
 -->

 //mongodb+srv://ak511046:<password>@cluster0.s3qwqlk.mongodb.net/


 <?php
// MongoDB connection settings
$mongoHost = 'localhost'; // MongoDB server host
$mongoPort = 27017; // MongoDB server port
$mongoDatabase = 'cess'; // Your MongoDB database name

// Connect to MongoDB
try {
    $mongoClient = new MongoDB\Client("mongodb://$mongoHost:$mongoPort");
    $db = $mongoClient->$mongoDatabase;
} catch (MongoDB\Driver\Exception\Exception $e) {
    die('Error connecting to MongoDB: ' . $e->getMessage());
}
?>


<?php
// Function to insert data into MongoDB
function insertData($type, $district, $date, $company, $db) {
    try {
        // Select the collection you want to insert data into
        $collection = $db->cesss;

        // Define the document to insert
        $document = [
            'type' => $type,
            'district' => $district,
            'date' => $date,
            'company' => $company,
        ];

        // Insert the document into the collection
        $insertResult = $collection->insertOne($document);

        // Check if the insertion was successful
        if ($insertResult->getInsertedCount() == 1) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        die('Error inserting data into MongoDB: ' . $e->getMessage());
    }
}
?>
