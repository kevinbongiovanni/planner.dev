<?php

require_once 'filestore.php';

class AddressDataStore extend Filestore
{

    function read_file()
    {
        $handle = fopen($this->filename, 'r');

        $addressBook = [];

        while(!feof($handle)) {
            $row = fgetcsv($handle);

                if (!empty($row)) {
                  $addressBook[] = $row;
                }
        }

        fclose($handle);
        return $addressBook;
    }



    function save_file($addressesArray)
     {

        $handle = fopen($this->filename, 'w');

            foreach ($addressesArray as $row) {
            fputcsv($handle, $row);
            }

        fclose($handle);
      }

    function openfile($filename) {
        $handle = fopen($filename, 'r');
        $contents = trim(fread($handle, filesize($filename)));
        $array = explode("\n", $contents);
        fclose($handle);
        return $array;
    }   

    // Code to write $addressesArray to file $this->filename

    $addressesArray = $this-.$filename;

}