<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('test');
    }

    public function show($param = '')
    {
        if($param === 'php-info') {
            $this->load->view('test/show');
        } else {
            show_404();
        }
    }
}
