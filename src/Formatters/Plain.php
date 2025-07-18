<?php

namespace Hexlet\Code\Formatters;

function flattenAll($collection): array
{
    $result = [];

    foreach ($collection as $value) {
        if (is_array($value)) {
            $result = array_merge($result, flattenAll($value));
        } else {
            $result[] = $value;
        }
    }

    return $result;
}

function getPlainValue($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_array($value)) {
        return "[complex value]";
    }

    if (is_null($value)) {
        return 'null';
    }

    return "'$value'";
}

function getPropertyName($name, $parent)
{
    if (is_null($parent)) {
        return $name;
    }
    return "$parent.$name";
}

function renderPlainValues($data, $parent = null): array
{
    $handlers = [
        'nested' => function ($element) use ($parent) {
            $currentPath = getPropertyName($element['key'], $parent);
            return renderPlainValues($element['values'], $currentPath);
        },
        'added' => function ($element) use ($parent) {
            $propertyName = getPropertyName($element['key'], $parent);
            $value = getPlainValue($element['values'][0]);
            return "Property '$propertyName' was added with value: $value";
        },
        'removed' => function ($element) use ($parent) {
            $propertyName = getPropertyName($element['key'], $parent);
            return "Property '$propertyName' was removed";
        },
        'changed' => function ($element) use ($parent) {
            $propertyName = getPropertyName($element['key'], $parent);
            $oldValue = getPlainValue($element['values'][0]);
            $newValue = getPlainValue($element['values'][1]);
            return "Property '$propertyName' was updated. From $oldValue to $newValue";
        }
    ];

    $values = [];

    foreach ($data as $element) {
        if ($element['type'] == 'unchanged') {
            continue;
        }
        $handler = $handlers[$element['type']];
        $values[] = $handler($element);
    }

    return flattenAll($values);
}


function renderPlain($data): string
{
    $result = renderPlainValues($data);
    return implode(PHP_EOL, $result);
}
