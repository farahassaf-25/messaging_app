<?php

function imageToBase64($file)
{
    if (!file_exists($file))
        return null;
    $mimeType = mime_content_type($file);
    $imageData = file_get_contents($file);
    $base64 = base64_encode($imageData);
    return 'data:' . $mimeType . ';base64,' . $base64;
}
