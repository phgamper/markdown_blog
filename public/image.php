<?php

if(isset($_GET['src'])){
    if(isset($_GET['width'])) {
        $width = ceil($_GET['width'] / 10) * 10;
        $out = 'w'.$width.'_'.basename($_GET['src']);
        if(!is_file('cache/'.$out)){
            exec('convert .'.$_GET['src'].' -interlace Plane -strip  -quality 70 -resize '.$width.' cache/'.$out );
        }
        echo '/cache/'.$out;
    }else{
        echo $_GET['src'];
    }
}else{
    echo 'hallo';
}
