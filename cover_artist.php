<?php

function saveArtistCover($artist_name)
{
    $artistmp3     = str_replace("&amp;", '-', $artist_name);
    $imgarray      = 0;
    $filename      = $artistmp3 . '.jpg';
    $search_query  = $artistmp3 . " Album";
    $search_query  = urlencode($search_query);
    $googleRealURL = "https://www.google.com/search?hl=en&biw=1360&bih=652&tbs=isz%3Alt%2Cislt%3Asvga%2Citp%3Aphoto&tbm=isch&sa=1&q=" . $search_query . "&oq=" . $search_query . "&gs_l=psy-ab.12...0.0.0.10572.0.0.0.0.0.0.0.0..0.0....0...1..64.psy-ab..0.0.0.wFdNGGlUIRk";

    $ch = curl_init($googleRealURL);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686; rv:20.0) Gecko/20121230 Firefox/20.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $google        = curl_exec($ch);
    $array_imghtml = explode("\"ou\":\"", $google); //the big url is inside JSON snippet "ou":"big url"
    foreach ($array_imghtml as $key => $value) {
        if ($key > 0) {
            $array_imghtml_2 = explode("\",\"", $value);
            $array_imgurl[]  = $array_imghtml_2[0];
        }
    }



    while (is_valid_type($array_imgurl[$imgarray]) == 0) {
        echo "false";
        $imgarray++;




    }

    echo ' Cover Created Successfully' . '</br>';
    $ch = curl_init($array_imgurl[$imgarray]);
    $fp = fopen($filename, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    copy($filename, '../../../images/' . $filename);
    copy($filename, '../../../images/thumbs/' . $filename);

}
