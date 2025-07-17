<?php

namespace Hexlet\Code;

function getSortedKeys(array $keys): array
{
    $sorted = $keys;
    sort($sorted);
    return $sorted;
}

function getDifference(array $fileData1, array $fileData2): array
{
    $keys = array_keys(array_merge($fileData1, $fileData2));
    $sortedKeys = getSortedKeys($keys);

    return array_map(function ($key) use ($fileData1, $fileData2): array {
        $existsInFile1 = array_key_exists($key, $fileData1);
        $existsInFile2 = array_key_exists($key, $fileData2);

        if (!$existsInFile1) {
            return ['key' => $key, 'type' => 'added', 'values' => [$fileData2[$key]]];
        }
        if (!$existsInFile2) {
            return ['key' => $key, 'type' => 'removed', 'values' => [$fileData1[$key]]];
        }
        if (is_array($fileData1[$key]) && is_array($fileData2[$key])) {
            return [
                'key' => $key,
                'type' => 'nested',
                'values' => getDifference($fileData1[$key], $fileData2[$key])
            ];
        }
        if ($fileData1[$key] !== $fileData2[$key]) {
            return ['key' => $key, 'type' => 'changed', 'values' => [$fileData1[$key], $fileData2[$key]]];
        }
        return ['key' => $key, 'type' => 'unchanged', 'values' => [$fileData1[$key]]];
    }, $sortedKeys);
}
