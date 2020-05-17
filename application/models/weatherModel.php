<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class weatherModel extends CI_Model
{
    function get($city)
    {
        $url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . $city . '&units=metric&appid=271da6b323b05ebaf2b4aaa0f3378f89';
        $json = file_get_contents($url, false);

        //convert json ke array
        $data = json_decode($json, true);

        //return data array()
        return $data['list'];
    }
}
