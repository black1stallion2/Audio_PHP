<?php

function saveAlbumCover($img, $mydirectory, $pretrackName)
{
    $preName  = $mydirectory . '.jpg';
    $fileName = preg_replace('/\s+/', '', $preName);

    $trackName    = str_replace("'", '', $pretrackName);

    if ($trackName !== '') {

        if (file_put_contents($fileName, $img)) {

        	echo 'New Album Cover Created: ' . $fileName . '</br>';
            copy($fileName, '../../../images/' . $fileName);
            copy($fileName, '../../../images/thumbs/' . $fileName);

        } else {
            echo ' - No Image - ';
        }

    }
}
?>