<?php

class Filestore
{
    public $filename;
    protected $isCSV = false;

    function __construct($filename = '')
    {
        $this->filename = $filename;

        $extension = substr($filename, -3);

        if ($extension == 'csv') {
            $this->isCSV = true;
        }

        if (!file_exists($filename)) {
            touch ($filename);
        }
    }


    public function read()
    {
        if ($this->isCSV) {
            return $this->readCSV();
        }
        else {
            return $this->readFile();
        }
    }

    public function write($array)
    {
        if ($this->isCSV) {
            $this->writeCSV($array);
        }
        else {
            $this->writeFile($array);
        }
    }
    /**
    * Returns array of lines in $this->filename
    */
    private function readFile()
    {

        if (filesize($this->filename) == 0) {
            return [];
        }

        $handle = fopen($this->filename, 'r');
        $contents = trim(fread($handle, filesize($this->filename)));
        $contentsArray = explode("\n", $contents);
        fclose($handle);

        return $contentsArray;
    }
    /**
    * Writes each element in $array to a new line in $this->filename
    */
    private function writeFile($array)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $value) {
            fwrite($handle, $value . PHP_EOL);
        }
        fclose($handle);
    }
    /**
    * Reads contents of csv $this->filename, returns an array
    */
    private function readCSV()
    {

        $handle = fopen($this->filename, 'r');

        $array = [];

        while(!feof($handle)) {
            $row = fgetcsv($handle);

                if (!empty($row)) {
                  $array[] = $row;
                }
        }

        fclose($handle);
        return $array;
    }

    /**
    * Writes contents of $array to csv $this->filename
    */
    private function writeCSV($array)
    {
        $handle = fopen($this->filename, "w");

        foreach ($array as $line)
        {
            fputcsv($handle, $line);
        }

        fclose($handle); 
    }

 }




class CustomException extends Exception {

}

class GenericException extends Exception {

}



