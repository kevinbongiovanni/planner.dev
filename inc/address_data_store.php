<?php

require_once('../inc/filestore.php');

class AddressDataStore extends Filestore
{

    function __construct($filename)
    {
        parent::__construct(strtolower($filename));
    }

}