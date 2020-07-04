<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=searchengine','root','');

$search = $_GET['q'];


$searche = explode(" ",$search);
$x = 0;
$construct="";
$params = array();
foreach($searche as $tern)
{
	$x++;
	if($x==1)
	{
		$construct .= "title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";
	}
	else
	{
		$construct .= " AND title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";
	}
	$params[":search$x"] = $tern;
}


$results = $pdo->prepare("SELECT * FROM 'index' WHERE $construct");
$results->execute($params);
if($results->rowCount() == 0)
{
	echo "0 results found <hr />";
}
else
{
	echo $results->rowCount()." results found <hr />";
}
echo "<pre>";

foreach ($results->fetchAll() as $result)
{
	echo $result["title"]."<br />";
	if ($result["description"]== "")
		echo "No description available";
	else
		echo $result["description"]."<br />";
	echo $result["url"]."<br />";
	echo "<hr />";
}



?>
