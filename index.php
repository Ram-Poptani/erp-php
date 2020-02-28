<?php

require_once("helper/init.php");


$db = new Database($di);

echo $di->get('util')->redirect("index.php");

?>