<?php
    function convert_date ($value){
        return date('H:i:s - d M Y', strtotime($value));
    }
    function format_date ($value){
        return date('d-m-Y', strtotime($value));
    }
?>