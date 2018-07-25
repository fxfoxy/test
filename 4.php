<?php

/**
 * Складывает оооочень большие чилса.
 *
 * @param string $a Одно число, может быть больше 64-битного int.
 * @param string $b Второе число, может больше 64-битного int.
 *
 * @return string Сумма в виде строки.
 * @throws InvalidArgumentException Если передать что-то кроме цифр в строках.
 */
function sum(string $a, string $b): string
{
    if (!ctype_digit($a) || !ctype_digit($b)) {
        throw new InvalidArgumentException('Error! Only integers are accepted');
    }

    // Максимально кол-во разрядов, что можно складывать как целые без переполнения.
    $maxChunkSize = strlen(substr((string)PHP_INT_MAX, 1));

    $la = strlen($a);
    $lb = strlen($b);

    // Оптимизация.
    if ($la <= $maxChunkSize && $lb <= $maxChunkSize) {
        return (string)((int)$a + (int)$b);
    }

    if ($la >= $lb) {
        $b = str_pad($b, $la, '0', STR_PAD_LEFT);
    } else {
        $a = str_pad($a, $lb, '0', STR_PAD_LEFT);
    }

    $arA = str_split($a, $maxChunkSize);
    $arB = str_split($b, $maxChunkSize);

    $arS = [];
    $next = 0;
    $max = count($arA);
    for ($i = $max - 1; $i >= 0; $i--) {

        $sum = (string)((int)$arA[$i] + (int)$arB[$i] + $next);
        // Должен ли один разряд перенестись дальше?
        if (strlen($sum) > strlen($arA[$i])) {
            $sum = substr($sum, 1);
            $next = 1;
        } else {
            $next = 0;
        }
        $arS[] = $sum;
    }
    if ($next) {
        $arS[] = $next;
    }

    return implode(array_reverse($arS));
}


$a = '9223372036854775807333';
$b = '9223372036854775807555';
$sum = '18446744073709551614888';

$result = sum($a, $b);
if (assert($result === $sum)) {
    echo 'Работает!', PHP_EOL;
}
