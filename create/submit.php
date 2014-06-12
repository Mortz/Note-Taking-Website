<?php



$course = $_POST["course"];
$name = $_POST["name"];
$description = $_POST["description"];
$content = $_POST["content"];
$tags = $_POST["tags"];
$links = $_POST["links"];

ini_set('display_errors', 'On');

// connect to a remote host at a given port
$m = new MongoClient( "mongodb://daniel:____@ds053937.mongolab.com:53937/notes" );

// select a database
$db = $m->notes;

// select a collection (analogous to a relational database's table)
$collection = $db->selectCollection($course);

// add a record
#$name = htmlspecialchars($name);
#$description= htmlspecialchars($description);
#$content = htmlspecialchars($content);
#$tags = htmlspecialchars($tags);
#$links = htmlspecialchars($links);

#$code = array("^","*","~");
#$html = array("<ul>","<li>","</ul>");
#$text = str_replace($code,$html,$content);
#$text = str_replace(array("<br /><ul>","<ul><br />"),array("<ul>","<ul>"),str_replace($code,$html,$content));
#$text = preg_replace("/\n(\s*\*\s+.*)+/","<ul>\n$1\n</ul>",$content);

#

$list = explode("\n", $content);
$text = "";
foreach ($list as $line) {

    $newtext = preg_replace("/^\s*\*\*\*\s+(.*)/","<ul><ul><ul><li>$1</li></ul></ul></ul>",$line);
    $newtext = preg_replace("/^\s*\*\*\s+(.*)/","<ul><ul><li>$1</li></ul></ul>",$newtext);
    $newtext = preg_replace("/^\s*\*\s+(.*)/","<ul><li>$1</li></ul>",$newtext);    

	if ($newtext == $line) { //didn't replace
        $newtext .= "<br />"; //add a new line if its not a bullet
    }
	
	
	//now do replacing non bullet syntax
    $newtext = preg_replace("/\[\[(.*)\s*\|\s*(.*)\]\]/","<a href='$1'>$2</a>",$newtext);
    $newtext = preg_replace("/==(.*?)==/","<b>$1</b>",$newtext);
    $newtext = preg_replace("/\-\->/"," &#8594; ",$newtext);
	$newtext = preg_replace("/<\-\-/"," &#8592; ",$newtext);
    $newtext = preg_replace("/\t/","    ",$newtext); //convert tabs to four spaces
    $newtext = preg_replace("/\ \ \ \ /"," &emsp; ",$newtext); //convert four spaces to html tab (approximately 4 spaces)
    $text .= $newtext;   	
}

$text = str_replace("\t","&emsp;",$text);

$document = array( "name" => $name, "description" => $description, "content" => $text, "tags" => $tags, "links" => $links, "timeSubmitted" => time() );
$collection->insert($document);

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
