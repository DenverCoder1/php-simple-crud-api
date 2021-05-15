<?php

require_once("../functions.php");

$configs = include("../config.php");

$file = $configs["json_path"];

$params = validateParams([
    "tag" => "required",
    "key" => "required"
]);

// check the secret for deleting if it is set
if (isset($configs["secret"]) && $configs["secret"] != "") {
    $paramsToCheck["secret"] = "required";
}

$response = deleteEntry($file, $params["tag"], $params["key"]);

echo encodeJSON($response);