<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jogo_da_velha extends CI_Controller
{
    /**
     * Jogo_da_velha constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     *
     */
    public function index()
    {
        $this->load->view('jogo_da_velha');
    }
}