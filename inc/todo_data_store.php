<?php

require_once('../inc/filestore.php');

class ToDoDataStore extends Filestore
{

    function __construct($filename)
    {
        parent::__construct(strtolower($filename));
    }

}