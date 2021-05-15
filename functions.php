<?php

// read JSON file and return contents decoded as an array
function readJSON($file): array
{
    // check if file exists
    if (file_exists($file)) {
        // load json from file
        $contents = file_get_contents($file);
        $data = json_decode($contents, true);
    }
    // create an empty JSON file
    else {
        $data = array();
        // create data directory if it doesn't exist
        $directory = preg_replace("/([\/\\\\])[^\/\\\\]*?$/", "$1", $file);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        // create data.json file
        file_put_contents($file, encodeJSON($data));
    }

    return $data;
}

// encode array as JSON and store in a JSON file
function writeJSON($file, $data): void
{
    // overwrite file
    $fh = fopen($file, 'w') or die(encodeJSON([
        "responseType" => "error",
        "message" => "failed to open file for writing",
    ]));
    fwrite($fh, encodeJSON($data));
    fclose($fh);
}

// encode array as JSON with pretty print for readability
function encodeJSON($data): string
{
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

// get data from JSON file
// filter by tag if tag is not null
// show single entry if key is not null
function getEntryOrTag($file, $tag, $key): array
{
    $data = readJSON($file);

    if ($tag !== null) {
        // found the tag to filter by
        if (array_key_exists($tag, $data)) {
            // return entries for a single tag
            $data = $data[$tag];

            // check if key exists in data
            if ($key !== null) {
                // found a single key
                if (array_key_exists($key, $data)) {
                    // filter to just a single key
                    $data = [$key => $data[$key]];
                }
                // specified key is not valid
                else {
                    die(encodeJSON([
                        "responseType" => "error",
                        "message" => "key '$key' does not exist in tag '$tag'",
                        "data" => $data,
                    ]));
                }
            }
        }
        // specified tag does not exist
        else {
            die(encodeJSON([
                "responseType" => "error",
                "message" => "tag '$tag' does not exist",
                "data" => $data,
            ]));
        }
    }

    return [
        "responseType" => "success",
        "data" => $data,
    ];
}

// add an entry to the JSON file
function addEntry($file, $tag, $key, $value): array
{
    // load json
    $data = readJSON($file);

    // create tag if it is missing
    if (!array_key_exists($tag, $data)) {
        $data[$tag] = array();
    }

    // check that entry does not already exist
    if (!array_key_exists($key, $data[$tag])) {
        // update data
        $data[$tag][$key] = $value;
    }
    // key already exists
    else {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "key '$key' already exists in tag '$tag'",
            "data" => $data,
        ]));
    }

    // overwrite file
    writeJSON($file, $data);

    return [
        "responseType" => "success",
        "data" => $data,
    ];
}

// update an entry in the JSON file
function updateEntry($file, $tag, $key, $value): array
{
    // load json
    $data = readJSON($file);

    // check that tag exists
    if (!array_key_exists($tag, $data)) {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "tag '$tag' does not exist",
            "data" => $data,
        ]));
    }

    // check that key exists
    if (!array_key_exists($key, $data[$tag])) {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "key '$key' does not exist in tag '$tag'",
            "data" => $data,
        ]));
    }

    // update entry
    $data[$tag][$key] = $value;

    // overwrite file
    writeJSON($file, $data);

    return [
        "responseType" => "success",
        "data" => $data,
    ];
}

// delete an entry in the JSON file
function deleteEntry($file, $tag, $key): array
{
    // load json
    $data = readJSON($file);

    // check that tag exists
    if (!array_key_exists($tag, $data)) {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "tag '$tag' does not exist",
            "data" => $data,
        ]));
    }

    // check that key exists
    if (!array_key_exists($key, $data[$tag])) {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "key '$key' does not exist in tag '$tag'",
            "data" => $data,
        ]));
    }

    // delete entry
    unset($data[$tag][$key]);

    // overwrite file
    writeJSON($file, $data);

    return [
        "responseType" => "success",
        "data" => $data,
    ];
}

// validate a list of parameters given required/optional status for each
// return the list of validated parameters with their values
// example usage: validateParams(["tag" => "required", "key" => "optional"]);
function validateParams($params): array
{
    $validated = array();
    foreach ($params as $key => $value) {
        // find parameter
        if (isset($_REQUEST[$key])) {
            $validated[$key] = $_REQUEST[$key];
        }
        // insert optional parameter as null if not found
        else if ($value == "optional") {
            $validated[$key] = null;
        }
        // required parameter is not found
        else {
            die(encodeJSON([
                "responseType" => "error",
                "message" => "missing required parameter: $key",
            ]));
        }
    }
    return $validated;
}

// exits with an error message if the value does not match the secret
function validateSecret($value, $secret)
{
    if ($value != $secret) {
        die(encodeJSON([
            "responseType" => "error",
            "message" => "The secret does not match",
        ]));
    }
}
