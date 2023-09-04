<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $birthday = $_POST["birthday"];

    

    try {
      

        $sql = "UPDATE student SET name = :name, age = :age, birthday = :birthday WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':birthday', $birthday);

        if ($stmt->execute()) {
            echo "Data updated successfully!";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $stmt->close();
    $conn->close();
}
?>
