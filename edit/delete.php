<?php

    $id = $_GET["id"];
    $course = $_GET["course"];

    $connection = new MongoClient( "mongodb://daniel:____@ds053937.mongolab.com:53937/notes" ); 

    // select a database
    $db = $connection->notes;

    // select a collection (analogous to a relational database's table)
    $collection = $db->selectCollection($course);

    $objId = new MongoId($id);

    $query = array("_id" => $objId);

    $doc = $collection->findOne($query);
    $newconnection = new MongoClient( "mongodb://daniel:____@ds027628.mongolab.com:27628/trash" ); 
    $newdb = $newconnection->trash;
    $newcollection = $newdb->selectCollection($course);
    // $newdoc = array("")
    $newcollection->insert($doc);

    $collection->remove( $query, array("justOne" => true) );

    // find everything in the collection
    $cursor = $collection->find();

    // iterate through the results
    echo '<head><style type="text/css">ul {margin: 0;}</style></head><body>';
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