<?php
function getContent(
    string $directory = '.',
    string $finalSpan = '',
    string $sizeSpan = '    ',
    string $transfer = "\n",
    int $linkCount = 5,
    int $count = 0,
    bool $isLink = false
)
{
    try {
        $files = scandir($directory);
        foreach ($files as $file) {
            $enclosed = $directory . '/' . $file;
            if ($count == $linkCount) {
                break;
            } elseif ($file == '.' || $file == '..') {
                continue;
            } else {
                echo $finalSpan . $file . $transfer;
            }

            if (is_link($enclosed) && !$isLink) {
                getContent($enclosed, $finalSpan . $sizeSpan, $sizeSpan, $transfer, $linkCount, $count + 1, true);
            } elseif (is_dir($enclosed)) {
                $localCount = $isLink ? $count + 1 : $count;
                getContent($enclosed, $finalSpan . $sizeSpan, $sizeSpan, $transfer, $linkCount, $localCount, $isLink);
            }
        }
    } catch (Error $error) {
        $errorMessage = is_link($directory) && is_file($directory) ? '' : "$finalSpan error read: $directory" . $transfer;
        echo $errorMessage;
    }catch (Exception $exception) {
        echo '(exception)' . $transfer;
    }
}

function configurationsParametrs()
{
    set_error_handler("getContent");
    $transfer = '';
    $sizeSpan = '';
    if ('cli' != php_sapi_name()) {
        $transfer = '<br/>';
        $sizeSpan = '&nbsp;&nbsp;&nbsp;&nbsp;';
    } else {
        $sizeSpan = '    ';
    }
    $transfer .= "\n";
    getContent('.', '', $sizeSpan, $transfer);
}
configurationsParametrs();
?>