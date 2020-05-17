<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class weatherController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('weatherModel');
    }

    function index()
    {
        if (!empty($_GET['city'])) { //Jika telah input city
            $data['city'] = $_GET['city'];
            $data['dataWeather'] = $this->weatherModel->get($_GET['city']);
        } else {
            $data['dataWeather'] = null;
            $data['city'] = array('Australia', 'Bandung', 'Bangkok', 'China', 'Jakarta', 'Jambi', 'New York', 'Singapore', 'Surabaya', 'Yogyakarta');
        }

        $this->load->view('weather.php', $data);
    }
}
