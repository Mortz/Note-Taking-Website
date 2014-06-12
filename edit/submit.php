<?php

    ini_set('display_errors', '1');

    $name = $_POST["name"];
    $description = $_POST["description"];
    $content = $_POST["content"];
    $tags = $_POST["tags"];
    $links = $_POST["links"];
    $course = $_POST["course"];
    $id = $_POST["id"];
    $timeSubmitted = $_POST["timeSubmitted"];

    
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

    $newdata = array("name" => $name, "description" => $description, "content" => $content, "tags" => $tags, "links" => $links, "timeSubmitted" => $doc['timeSubmitted']);

    $collection->update( $query, $newdata );

    // find everything in the collection
    $cursor = $collection->find();

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