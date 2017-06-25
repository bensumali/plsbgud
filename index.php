<?php
$parserFolderStatic = "./parsers/static/";
foreach (glob($parserFolderStatic . "*.parser.php") as $filename)
{
    require_once($filename);
}

echo "it worked!";

?>
