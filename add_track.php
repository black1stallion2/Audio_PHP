<?php

function addTrack($myid, $mp3title, $mydirectory, $myartist, $myduration, $preAlbum)
{

    $parsedTitle = str_replace(' ', '_', $mp3title);
    $ParsedURL   = str_replace("'", '', $parsedTitle);

    $myartistmp3 = str_replace('_', ' ', $mydirectory);
    $mp3artist   = str_replace('_', ' ', $myartistmp3);

    $description = str_replace("'", '', $preAlbum);

    $trackStatus = '1';

    $albumDisplayName = str_replace('_', ' ', $mydirectory);

    $artistimg = str_replace("&amp;", '-', $myartist) . '.jpg';
    $artistmp3 = str_replace("&amp;", '-', $myartist);

    $url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url .= $_SERVER['SERVER_NAME'];
    $url .= $_SERVER['REQUEST_URI'];

    $Directory_URL = dirname(dirname($url)) . '/' . $mydirectory;

    $mp3type = "server_url";

    $FormattedTitle = str_replace("'", '', $mp3title);
    $mp3title       = str_replace('_', ' ', $FormattedTitle);

    $NewDir = str_replace('http://hostfile.xyz/', 'http://hostfile.xyz//', $Directory_URL);

    $mp3type  = "server_url";
    $mp3title = str_replace('_', ' ', $FormattedTitle);
    $mp3url   = $NewDir . '/' . $ParsedURL . '.mp3';
    $mynewid  = $myid;

    $Server   = '10.16.16.4';
    $Username = 'nmsv3-hj1-u-179537';
    $Password = 'hostfile';
    $Database = 'nmsv3-hj1-u-179537';

    $conn = new mysqli($Server, $Username, $Password, $Database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO tbl_mp3 (
    id,
    cat_id,
    mp3_type,
    mp3_title,
    mp3_url,
    mp3_thumbnail,
    mp3_duration,
    mp3_artist,
    mp3_description,
    status
    )
        VALUES (
    '',
    '$myid',
    '$mp3type',
    '$mp3title',
    '$mp3url',
    '$artistimg',
    '$myduration',
    '$mp3artist',
    '$description',
    '$trackStatus')";

    if ($conn->query($sql) === true) {

        echo $myid . " - New Track Created" . "</br>";
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }
   echo 'URLS --' . $NewDir . '/' . $ParsedURL . '.mp3';
    mysqli_close($conn);

}
