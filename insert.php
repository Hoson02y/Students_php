<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $birthday = $_POST["birthday"];

    include_once "conn.php"; 
   
    $sql = "INSERT INTO student (name, age, birthday) VALUES (:name, :age, :birthday)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':birthday', $birthday);

        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
