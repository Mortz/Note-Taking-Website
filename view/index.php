<?php

    $course = $_GET["course"]; 

    // connect to a remote host at a given port
    $m = new MongoClient( "mongodb://daniel:____@ds053937.mongolab.com:53937/notes" ); 

    // select a database
    $db = $m->notes;



    // select a collection (analogous to a relational database's table)
    $collection = $db->selectCollection($course);
    
    // find everything in the collection
    $cursor = $collection->find()->sort(array ("timeSubmitted" => 1));

    // iterate through the results
    echo '<head><style type="text/css">ul {margin: 0;}</style></head><body>';
    echo "<h2><a href='http://www.danielmorton.net/notes'>Home</a></h2>";
    foreach ($cursor as $document) {
        echo "<h2>" . $document["name"] . "</h2>";
        echo "<a href=../edit/edit.php?course=".$course."&id=".$document["_id"]."&name=".$document["name"].">Edit</a>";
        echo "<h3>" . $document["description"] . "</h3>";
        echo $document["content"];
        echo "<h5>" . $document["links"] . "</h5>";
        echo "<h5>" . $document["tags"] . "</h5>";
        echo "<hr>";
    }


?>
