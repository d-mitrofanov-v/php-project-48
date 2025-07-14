<?php

namespace Hexlet\Code;

use function Funct\Collection\sortBy;

function getString($key, $value, $sign = " "): string
{
    if (is_bool($value)) {
        $value = json_encode($value);
    }
    return "  " . $sign . " " . $key . ": " . $value;
}

function genDiff(string $filePath1, string $filePath2): string
{
    $json1 = getFileContent($filePath1);
    $json2 = getFileContent($filePath2);
    $data1 = get_object_vars($json1);
    $data2 = get_object_vars($json2);

    $keys = array_keys(array_merge($data1, $data2));

    $sortedKeys = sortBy($keys, function ($key) {
        return $key;
    });

    $result = [];
    $result[] = "{";

    foreach ($sortedKeys as $key) {
        if (!array_key_exists($key, $data2)) {
            $result[] = getString($key, $data1[$key], "-");
        } elseif (!array_key_exists($key, $data1)) {
            $result[] = getString($key, $data2[$key], "+");
        } elseif ($data2[$key] === $data1[$key]) {
            $result[] = getString($key, $data1[$key]);
        } else {
            $result[] = getString($key, $data1[$key], "-");
            $result[] = getString($key, $data2[$key], "+");
        }
    }
    $result[] = "}";

    return implode("\n", $result);
}
