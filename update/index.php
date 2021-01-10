<?php

require_once("../functions.php");

$configs = include("../config.php");

$file = $configs["json_path"];

$params = validateParams(["tag" => "required", "key" => "required", "value" => "required"]);

echo encodeJSON(updateEntry($file, $params["tag"], $params["key"], $params["value"]));