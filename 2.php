<?php

/**
 * Class Counter - файловый счётчик.
 */
class Counter {

    // Предполагаем, что DOC_ROOT задан выше в проекте.
    const COUNTER_FILENAME =  DOC_ROOT . '/counter.txt';

    /**
     * Увеличивает файловый счётчик на 1.
     *
     * @return void
     */
    public static function inc()
    {
        ignore_user_abort(true);
        if ($fp = fopen(static::COUNTER_FILENAME, 'c+b')) {
            if (flock($fp, LOCK_EX)) {
                $counter = 0;
                if ($size = filesize(static::COUNTER_FILENAME)) {
                    $counter = (int)fread($fp, $size);
                }
                fseek($fp, 0);
                fwrite($fp, ++$counter);
                fflush($fp);
                flock($fp, LOCK_UN);
                fclose($fp);
            }
        }
        ignore_user_abort(false);
    }
}
