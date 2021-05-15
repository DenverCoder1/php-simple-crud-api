<?php

require_once "../functions.php";

$configs = include "../config.php";

$file = $configs["json_path"];

$params = validateParams([
    "tag" => "optional",
    "key" => "optional",
]);

// check the secret for reading if 'private' is set to true
if (isset($configs["private"]) && $configs["private"]) {
    $paramsToCheck["secret"] = "required";
}

$response = getEntryOrTag($file, $params["tag"], $params["key"]);

echo encodeJSON($response);
