<?php

function createAlbum($albumName)
{
    $Server   = '10.16.16.4';
    $Username = 'nmsv3-hj1-u-179537';
    $Password = 'hostfile';
    $Database = 'nmsv3-hj1-u-179537';

    $conn = new mysqli($Server, $Username, $Password, $Database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = str_replace('_', ' ', $albumName);
    $img  = $albumName . '.jpg';

    $albumquery = mysqli_query($conn, "SELECT * FROM `tbl_artist` WHERE artist_name='$name'");
    if (mysqli_num_rows($albumquery) > 0) {
        echo 'Album Already Exists ' . "<br />\n";
        return 1;
    } else {
        $obj     = mysqli_fetch_object($albumquery);
      
        $sql     = "INSERT INTO tbl_artist (artist_name, artist_image) VALUES ('$name', '$img')";
        if ($conn->query($sql) === true) {
            echo "New Album Created - " . $name . ", Album ID: " . mysqli_insert_id($conn) . "<br />\n";
            $Category_ID = mysqli_insert_id($conn);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        return 0;
    }

    $conn->close();
}

?>