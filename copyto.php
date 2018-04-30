<?php

$albumnumber = 1;
$filetocopy = 'add_album.php';


while($albumnumber < 93){

$copylocation = '../series/Now_' . $albumnumber . '/';

	copy($filetocopy, $copylocation . $filetocopy);
	$albumnumber++;

	echo 'Successfully Copied ' .  $filetocopy . ' to ' . $copylocation . '</br>';
}



?>