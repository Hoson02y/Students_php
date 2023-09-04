<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <style>
      /* Additional CSS Styles */

/* Style the headings */
h1 {
    font-size: 24px;
    text-align: center;
    color: #333;
}

h2 {
    font-size: 18px;
    color: #666;
    margin-top: 20px;
}

/* Style the forms */
form {
    background-color: #f9f9f9;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
}

/* Style the submit buttons */
input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 10px 20px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Style the table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Responsive styles for smaller screens */
@media (max-width: 768px) {
    form {
        padding: 10px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
        padding: 8px;
    }

    table {
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <h1>Student Management</h1>

    <!-- Insert Student Form -->
    <h2>Insert Student Data</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br><br>
        <label for="birthday">Birthday:</label>
        <input type="date" id="birthday" name="birthday" required>
        <br><br>
        <input type="submit" name="insert" value="Insert">
    </form>

    <!-- Update Student Form -->
    <h2>Update Student Data</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="update_id">Student ID:</label>
        <input type="number" id="update_id" name="update_id" required>
        <br><br>
        <label for="update_name">Name:</label>
        <input type="text" id="update_name" name="update_name" required>
        <br><br>
        <label for="update_age">Age:</label>
        <input type="number" id="update_age" name="update_age" required>
        <br><br>
        <label for="update_birthday">Birthday:</label>
        <input type="date" id="update_birthday" name="update_birthday" required>
        <br><br>
        <input type="submit" name="update" value="Update">
    </form>

    <!-- Delete Student Form -->
    <h2>Delete Student Data</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="delete_id">Student ID:</label>
        <input type="number" id="delete_id" name="delete_id" required>
        <br><br>
        <input type="submit" name="delete" value="Delete">
    </form>

    <!-- View Student Data -->
    <h2>View Student Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Birthday</th>
        </tr>
        <?php
        // Database connection code here (you can include a separate file)
       include_once "conn.php";

        // Insert Student Data
        if (isset($_POST["insert"])) {
            $name = $_POST["name"];
            $age = $_POST["age"];
            $birthday = $_POST["birthday"];

            $sql = "INSERT INTO student (name, age, birthday) VALUES (:name, :age, :birthday)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':birthday', $birthday);

            if ($stmt->execute()) {
                echo "Data inserted successfully!";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }

        // Update Student Data
        if (isset($_POST["update"])) {
            $update_id = $_POST["update_id"];
            $update_name = $_POST["update_name"];
            $update_age = $_POST["update_age"];
            $update_birthday = $_POST["update_birthday"];

            $sql = "UPDATE student SET name = :name, age = :age, birthday = :birthday WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $update_id);
            $stmt->bindParam(':name', $update_name);
            $stmt->bindParam(':age', $update_age);
            $stmt->bindParam(':birthday', $update_birthday);

            if ($stmt->execute()) {
                echo "Data updated successfully!";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }

        // Delete Student Data
        if (isset($_POST["delete"])) {
            $delete_id = $_POST["delete_id"];

            $sql = "DELETE FROM student WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $delete_id);

            if ($stmt->execute()) {
                echo "Data deleted successfully!";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }

        // View Student Data
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . $row["birthday"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
