<?php

function renameMP3($currentfile, $filename)
{
	$myName = str_replace("'", "", $filename);

    $name = str_replace(" ", "_", $myName) . ".mp3";

    if (rename($currentfile, $name)) {

        echo "Track Renamed: " . $name . ' ';
    } else {
        echo "Failed To Rename: ";
    }
}

?>