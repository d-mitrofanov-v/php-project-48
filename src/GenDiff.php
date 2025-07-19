<?php

namespace Differ\Differ;

use function Hexlet\Code\getDifference;
use function Hexlet\Code\getFileContent;
use function Hexlet\Code\render;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $fileExtension1 = pathinfo($filePath1)['extension'];
    $fileExtension2 = pathinfo($filePath2)['extension'];
    $fileData1 = getFileContent($filePath1, $fileExtension1);
    $fileData2 = getFileContent($filePath2, $fileExtension2);

    $difference = getDifference($fileData1, $fileData2);
    return render($difference, $format);
}
