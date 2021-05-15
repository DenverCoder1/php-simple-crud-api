<?php

require_once("../functions.php");

$configs = include("../config.php");

$file = $configs["json_path"];

$paramsToCheck = [
    "tag" => "required",
    "key" => "required",
];

// check the secret for inserting if it is set
if (isset($configs["secret"]) && $configs["secret"] != "") {
    $paramsToCheck["secret"] = "required";
}

$params = validateParams($paramsToCheck);

// check that secret is correct
if (isset($params["secret"])) {
    validateSecret($params["secret"], $configs["secret"]);
}

$response = deleteEntry($file, $params["tag"], $params["key"]);

echo encodeJSON($response);