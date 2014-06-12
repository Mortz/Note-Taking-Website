<?php

    $id = $_GET["id"];
    $course = $_GET["course"];

    echo "Are you sure? ";
    echo "<a href='delete.php?id=" . $id . "&course=" . $course . "'>Yes</a>";

?>