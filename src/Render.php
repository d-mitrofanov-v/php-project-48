<?php

namespace Hexlet\Code;

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

function renderValues($data, $level = 0): string
{
    $indent = str_repeat('    ', $level);

    $handlers = [
        'nested' => function ($element) use ($indent, $level) {
            $children = renderValues($element['values'], $level + 1);
            return "$indent    {$element['key']}: {\n$children\n    $indent}";
        },
        'added' => fn($element) => "$indent  + {$element['key']}: " . formatValue($element['values'][0], $level),
        'removed' => fn($element) => "$indent  - {$element['key']}: " . formatValue($element['values'][0], $level),
        'unchanged' => fn($element) => "$indent    {$element['key']}: " . formatValue($element['values'][0], $level),
        'changed' => fn($element) => "$indent  - {$element['key']}: " . formatValue($element['values'][0], $level) .
            "\n$indent  + {$element['key']}: " . formatValue($element['values'][1], $level)
    ];

    $values = array_reduce($data, function ($acc, $element) use ($handlers) {
        $handler = $handlers[$element['type']];
        $acc[] = $handler($element);
        return $acc;
    });

    return implode(PHP_EOL, $values);
}

function render($data, $format): string
{
    $renderer = [
        'stylish' => fn() => renderStylish($data),
    ];
    return $renderer[$format]();
}

function renderStylish(array $data): string
{
    $result = renderValues($data);
    return "{\n$result\n}";
}
