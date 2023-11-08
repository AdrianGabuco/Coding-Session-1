<?php

require 'vendor/autoload.php'; 


$faker = Faker\Factory::create('en_PH');


$servername = "localhost";
$username = "root";
$password = "captainbuko";
$dbname = "recordapp";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


for ($i = 1; $i <= 15; $i++) {
    $officeName = $faker->company;
    $contactNum = $faker->unique()->numerify('09#########');
    $email = $faker->email;
    $address = substr($faker->address, 45);
    $city = $faker->city;
    $country = $faker->country;
    $postal = $faker->numerify('####');

    $sql = "INSERT INTO office (name, contactnum, email, address, city, country, postal)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $officeName, $contactNum, $email, $address, $city, $country, $postal);
    if ($stmt->execute() === false) {
        echo "Error inserting into Office: " . $conn->error;
    }
}


for ($i = 1; $i <= 15; $i++) {
    $lastName = $faker->lastName;
    $firstName = $faker->firstName;
    $officeId = $faker->numberBetween(1, 10);
    $address = $faker->address;

    $sql = "INSERT INTO Employee (lastname, firstname, office_id, address)
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $lastName, $firstName, $officeId, $address);
    if ($stmt->execute() === false) {
        echo "Error inserting into Employee: " . $conn->error;
    }
}


for ($i = 1; $i <= 15; $i++) {
    $employeeId = $faker->numberBetween(1, 20);
    $officeId = $faker->numberBetween(1, 10);
    $dateLog = $faker->dateTimeThisDecade('now', 'Asia/Manila')->format('Y-m-d H:i:s');
    $allowedActions = ['IN', 'OUT', 'COMPLETE'];
    $action = $faker->randomElement($allowedActions);
    $remarks = $faker->word;
    $documentCode = $faker->unique()->numerify('###');

    $sql = "INSERT INTO Transaction (employee_id, office_id, datelog, action, remarks, documentcode)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssi", $employeeId, $officeId, $dateLog, $action, $remarks, $documentCode);
    if ($stmt->execute() === false) {
        echo "Error inserting into Transaction: " . $conn->error;
    }
}

echo "Fake data inserted successfully.";


$conn->close();
?>
