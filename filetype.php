<?php
function is_valid_type($file)
{
    $size = getimagesize($file);
    if(!$size) {
        return 0;
    }
    else{
    	return 1;
    }

   
}

?>