<?php
/* Before ANY HTML code */
    if(!session_id()){
        session_start();
        session_regenerate_id(true);
    }
