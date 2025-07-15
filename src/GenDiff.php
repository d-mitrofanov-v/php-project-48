<?php

namespace Hexlet\Code;

function formatString(string $key, $value, string $sign = " "): string
{
    if (is_bool($value)) {
        $value = json_encode($value);
    }
    return "  $sign $key: $value";
}

function sortByKeys(array $keys): array
{
    sort($keys);
    return $keys;
}

function genDiff(string $filePath1, string $filePath2): string
{
    $fileExtension1 = pathinfo($filePath1)['extension'];
    $fileExtension2 = pathinfo($filePath2)['extension'];
    $fileData1 = getFileContent($filePath1, $fileExtension1);
    $fileData2 = getFileContent($filePath2, $fileExtension2);

    $keys = array_keys(array_merge($fileData1, $fileData2));

    $sortedKeys = sortByKeys($keys);

    $result = [];
    $result[] = "{";

    foreach ($sortedKeys as $key) {
        if (!array_key_exists($key, $fileData2)) {
            $result[] = formatString($key, $fileData1[$key], "-");
        } elseif (!array_key_exists($key, $fileData1)) {
            $result[] = formatString($key, $fileData2[$key], "+");
        } elseif ($fileData2[$key] === $fileData1[$key]) {
            $result[] = formatString($key, $fileData1[$key]);
        } else {
            $result[] = formatString($key, $fileData1[$key], "-");
            $result[] = formatString($key, $fileData2[$key], "+");
        }
    }
    $result[] = "}";

    return implode("\n", $result);
}
