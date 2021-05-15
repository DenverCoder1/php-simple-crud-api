<?php

require_once "../functions.php";

$configs = include "../config.php";

$file = $configs["json_path"];

$paramsToCheck = [
    "tag" => "optional",
    "key" => "optional",
];

// check the secret for reading if 'private' is set to true
if (isset($configs["private"]) && $configs["private"]) {
    $paramsToCheck["secret"] = "required";
}

$params = validateParams($paramsToCheck);

// check that secret is correct
if (isset($params["secret"])) {
    validateSecret($params["secret"], $configs["secret"]);
}

$response = getEntryOrTag($file, $params["tag"], $params["key"]);

echo encodeJSON($response);
