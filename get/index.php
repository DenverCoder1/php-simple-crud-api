<?php

require_once("../functions.php");

$configs = include("../config.php");

$file = $configs["json_path"];

$params = validateParams(["tag" => "optional", "key" => "optional"]);

echo encodeJSON(getEntryOrTag($file, $params["tag"], $params["key"]));