<?php

/**
 * Response helper
 * @param int $code
 * @param mixed $content 
 * @param string $type Content-Type header value
 * @param bool $encode use json_encode($content) if true, otherwise just send $content as is
 */
function res($code, $content, $type = "application/json", $encode = true)
{
    http_response_code($code);
    header("Content-Type: $type");
    echo $encode ? json_encode($content) : $content;
}
