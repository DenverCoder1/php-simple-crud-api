<?php

require_once("../functions.php");

$configs = include("../config.php");

$file = $configs["json_path"];

$params = validateParams(["tag" => "required", "key" => "required"]);

echo encodeJSON(deleteEntry($file, $params["tag"], $params["key"]));