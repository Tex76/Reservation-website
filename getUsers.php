<?php
$id = $_GET['id'];
try {
    require('connect.php');
    $r = $db->query("SELECT * FROM users where id='$id'");
    if ($r->rowCount() == 0)
        die("problem in select");
    else {
        foreach ($r as $row) {
            echo "<table border='1px'>";
            echo "<tr>";
            echo "<td>User ID: </td>";
            echo "<td>" . $row[0] . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>UserName: </td>";
            echo "<td>" . $row[1] . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td> Name: </td>";
            if ($row[2] == "")
                echo "<td> not set yet</td>";
            else
                echo "<td>" . $row[2] . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td> email: </td>";
            echo "<td>" . $row[3] . "</td>";
            echo "</tr>";


            echo "<tr>";
            echo "<td> profile picture: </td>";
            if ($row[5] == "defaultimg.jpg")
                echo "<td> No profile picture set yet </td>";
            else
                echo "<td><img style='width:100px; ' src='meta/Persons/" . $row[5] . "'></td>";
            echo "</tr>";


            echo "<tr>";
            echo "<td>about: </td>";
            if ($row[6] == "")
                echo "<td>not set yet</td>";
            else
                echo "<td>" . $row[6] . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>type: </td>";
            echo "<td>" . $row[7] . "</td>";
            echo "</tr>";



            echo "</table>";
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
