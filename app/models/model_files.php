<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.04.2017
 * Time: 21:49
 */
class Model_files extends Model
{
    public function get_data()
    {


        $filesList = scandir('assets/template/img/');
        $fileNameArray = array_slice($filesList, 2);
        var_dump($filesList);

        return $fileNameArray;
    }
}