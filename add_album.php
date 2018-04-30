<?php

require_once '../../getid3/getid3.php';
include '../../getid3/simple_html_dom.php';

include '../../modules/filetype.php';
include '../../modules/database.php';
include '../../modules/cover_artist.php';
include '../../modules/cover_album.php';
include '../../modules/rename_mp3.php';
include '../../modules/add_artist.php';
include '../../modules/add_track.php';

$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];
$directory     = basename(dirname(__FILE__));
$Directory_URL = dirname(dirname($url)) . '/' . $directory;
$CoverFileName = $directory . '.jpg';
$getID3        = new getID3;
$OpenDirectory = opendir('./');
$CoverTitle    = preg_replace('/\s+/', '', $CoverFileName);
$ParsedDIR     = str_replace('_', ' ', $directory);
$totaltrack    = 0;

if (createAlbum($directory) == 0) {

// Scan & Get MP3 File
    while (($file = readdir($OpenDirectory)) !== false) {

        $mp3RealPath = realpath('.//' . $file);
        if ((substr($file, 0, 1) != '.') && is_file($mp3RealPath)) {
            set_time_limit(30);

            if (!((strpos(strtolower($file), '.mp3')) === false)) {

                $ThisFileInfo = $getID3->analyze($mp3RealPath);
                getid3_lib::CopyTagsToComments($ThisFileInfo);

                $MP3_Title    = $ThisFileInfo['comments_html']['title'][0];
                $MP3_Artist   = $ThisFileInfo['comments_html']['artist'][0];
                $MP3_PreAlbum = $ThisFileInfo['comments_html']['album'][0];
                $MP3_Duration = $ThisFileInfo['playtime_string'];
                $MP3_Album    = str_replace("'", '', $MP3_PreAlbum);
                $NewTitle     = str_replace("'", '', $MP3_Title);
                $MP3_File     = str_replace(' ', '_', $NewTitle);
                $NewMP3File   = $MP3_File . '.mp3';
                $mytrackName  = $ThisFileInfo['comments_html']['title'][0];

                if ($NewTitle !== '') {

                    if (isset($ThisFileInfo['comments']['picture']['0']['data'])) {
                        $image = $ThisFileInfo['comments']['picture']['0']['data'];

                        saveAlbumCover($image, $directory, $mytrackName);

                    }

                    $mynewid = addArtist($MP3_Artist);

                    renameMP3($mp3RealPath, $MP3_Title);

                    $NewArtist        = str_replace("'", '', $MP3_Artist);
                    $MyMP3Title       = str_replace(' ', '_', $MP3_Title);
                    $MyTitle          = str_replace("'", '', $MyMP3Title);
                    $MP3_Album        = str_replace("'", '', $MP3_PreAlbum);
                    $NewDir           = str_replace('http://hostfile.xyz/', 'http://hostfile.xyz//', $Directory_URL);
                    $MP3_FileLocation = $NewDir . '/' . $MyTitle . '.mp3';
                    $MP3_ArtistJPG    = $NewArtist . '.jpg';
                    $MP3JPGFinal      = str_replace("&amp;", '-', $MP3_ArtistJPG);
                    $FormattedTitle   = str_replace("'", '', $MP3_Title);
                    $TitleFormatted   = str_replace('_', ' ', $FormattedTitle);

                    saveArtistCover($NewArtist);
                    addTrack($mynewid, $MP3_Title, $directory, $MP3_Artist, $MP3_Duration, $MP3_PreAlbum);
                    echo $directory . $Directory_URL . $ParsedDIR;
                    $totaltrack++;
           
                }
            }

        }
    }
         echo 'Total Tracks Added: ' . $totaltrack;
}
?>