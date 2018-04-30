<?php

function addArtist($artistname)
{

    $artistparse = str_replace("&amp;", '-', $artistname);
    $artist   = str_replace("'", '', $artistparse);
 $artistcover = str_replace("&amp;", '-', $artistname) . '.jpg';

    $Server   = '10.16.16.4';
    $Username = 'nmsv3-hj1-u-179537';
    $Password = 'hostfile';
    $Database = 'nmsv3-hj1-u-179537';

    $conn = new mysqli($Server, $Username, $Password, $Database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = mysqli_query($conn, "SELECT * FROM `tbl_category` WHERE category_name='$artist'");
    if (mysqli_num_rows($query) > 0) {
        $obj     = mysqli_fetch_object($query);
        $photoid = $obj->cid;
        echo 'Artist Already Exists: ' . $artist . ', Artist ID: ' . $photoid . '</br>';
    } else {

        $sql = "INSERT INTO tbl_category (cid, category_name, category_image) VALUES ('', '$artist', '$artistcover')";
        if ($conn->query($sql) === true) {

            echo 'New Artist Created: ' . $artist . ', Artist ID: ' . mysqli_insert_id($conn) . '</br>';
            $photoid = mysqli_insert_id($conn);
        } else {
            echo ', Failed To Create Artist ';
        }
    }

    $myid = $photoid;
    $conn->close();

    return $myid;
}
?>