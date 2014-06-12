<?php
    ini_set('display_errors', '1');
    $course = $_GET["course"];
    $id = $_GET["id"];
    // $name = $_GET["name"];

    // connect to a remote host at a given port
    $connection = new MongoClient( "mongodb://daniel:____@ds053937.mongolab.com:53937/notes" ); 

    // select a database
    $db = $connection->notes;

    // select a collection (analogous to a relational database's table)
    $collection = $db->selectCollection($course);
    // $db = $connection->thedb->users; 

    $objId = new MongoId($id);

    $query = array("_id" => $objId);

    $doc = $collection->findOne($query);

    echo "<a href='areyousure.php?id=" . $id . "&course=" . $course . "'>Delete this record</a>";

    echo "<form action='submit.php' method='post'>";
    echo "<table>";
    echo "<tr>";
    echo " <td>Title</td> <td><input type='text' name='name' value='" . $doc["name"] . "'></td>";
    echo "</tr>";
    echo "<tr>";
    echo " <td>Description</td> <td><input type='text' name='description' value='" . $doc["description"] . "'></td>";
    echo "</tr>";
    echo "<tr>";
    echo " <td>Content</td> <td><textarea rows='10' cols='50' name='content' value='".$doc["content"]. "'>" . $doc["content"] . "</textarea></td>";
    echo "</tr>";
    echo "</table>";
    echo " <br><br><br>";
    echo "<table>";
    echo "<tr>";
    echo " <td>Tags</td> <td><input type='text' name='tags' value='" . $doc["tags"] . "'></td>";
    echo "</tr>";
    echo "<tr>";
    echo " <td>Links</td> <td><input type='text' name='links' value='" . $doc["links"] . "'></td>";
    echo "</tr>";
    echo "</table>";
    echo "<input type='hidden' name='id' value='".$id."'>";
    echo "<input type='hidden' name='course' value='" . $course . "'>";
    echo "<input type='hidden' name='timeSubmitted' value='" . $doc["timeSubmitted"]. "'>";
    echo "<input type='submit' value='Submit'>";

    echo "</form>";

?>
