<?php
function getContent(string $directory, string $span)
{
    error_reporting(0);
    try {
        $files = scandir($directory);
        if (!$files) {
            throw new Exception();
        }
        foreach ($files as $file) {
            $enclosed = $directory . "/" . $file;
            if ($file == '.' || $file == '..') {
                continue;
            } elseif (is_file($enclosed) || is_link($enclosed)) {
                echo "\n" . $span . $file;
            } elseif (is_dir($enclosed)) {
                echo "\n" . $span . $file;
                getContent($enclosed, $span . '    ');
            }
        }
    } catch (Exception $exception) {}
}
getContent(".", "");