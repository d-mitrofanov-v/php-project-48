<?php

namespace Hexlet\Code\Formatters;

function formatArrayValue($value, $level): string
{
    $indent = str_repeat('    ', $level + 1);
    $keys = array_keys($value);
    $values = [];

    foreach ($keys as $key) {
        if (is_array($value[$key])) {
            $values[] = "$indent    $key: " . formatArrayValue($value[$key], $level + 1);
        } else {
            $values[] = "$indent    $key: $value[$key]";
        }
    }

    $result = implode(PHP_EOL, $values);
    return "{\n$result\n$indent}";
}

function formatValue($value, $level): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_array($value)) {
        return formatArrayValue($value, $level);
    }

    if (is_null($value)) {
        return 'null';
    }

    return $value;
}

function renderStylishValues($data, $level = 0): string
{
    $indent = str_repeat('    ', $level);

    $handlers = [
        'nested' => function ($element) use ($indent, $level) {
            $children = renderStylishValues($element['values'], $level + 1);
            return "$indent    {$element['key']}: {\n$children\n    $indent}";
        },
        'added' => fn($element) => "$indent  + {$element['key']}: " . formatValue($element['values'][0], $level),
        'removed' => fn($element) => "$indent  - {$element['key']}: " . formatValue($element['values'][0], $level),
        'unchanged' => fn($element) => "$indent    {$element['key']}: " . formatValue($element['values'][0], $level),
        'changed' => fn($element) => "$indent  - {$element['key']}: " . formatValue($element['values'][0], $level) .
            "\n$indent  + {$element['key']}: " . formatValue($element['values'][1], $level)
    ];

    $values = [];

    foreach ($data as $element) {
        $handler = $handlers[$element['type']];
        $values[] = $handler($element);
    }

    return implode(PHP_EOL, $values);
}

function renderStylish(array $data): string
{
    $result = renderStylishValues($data);
    return "{\n$result\n}";
}
