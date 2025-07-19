<?php

namespace Hexlet\Code\Formatters;

function flattenAll(array $collection): array
{
    return array_reduce($collection, function ($acc, $value) {
        if (is_array($value)) {
            return array_merge($acc, flattenAll($value));
        }
        return array_merge($acc, [$value]);
    }, []);
}

function getPlainValue(mixed $value): float|int|string
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

    if (is_numeric($value)) {
        return $value;
    }

    return "'$value'";
}

function getPropertyName(string $name, ?string $parent): string
{
    if (is_null($parent)) {
        return $name;
    }
    return "$parent.$name";
}

function renderPlainValues(array $data, ?string $parent = null): array
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

    $values = array_reduce($data, function ($acc, $element) use ($handlers) {
        if ($element['type'] === 'unchanged') {
            return $acc;
        }
        $handler = $handlers[$element['type']];
        return [...$acc, $handler($element)];
    }, []);

    return flattenAll($values);
}


function renderPlain(array $data): string
{
    $result = renderPlainValues($data);
    return implode(PHP_EOL, $result);
}
