<?php

/**
 * Складывает оооочень большие чилса
 *
 * @param string $a Одно число больше 64-битного int
 * @param string $b Второе число больше 64-битного int
 *
 * @return string Сумма в виде строки.
 */
function summ(string $a, string $b): string
{
    return number_format((float)$a + (float)$b, 0, '', '');
}
