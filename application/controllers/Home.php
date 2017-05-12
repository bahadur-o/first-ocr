<?php
/**
 * @package     Allshore
 * @author      Bahadur O
 * @copyright   Copyright (c) 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{

    /**
     * Home constructor.
     */
    public function __construct()
    {

        // called parent constructor
        parent::__construct();

        // Loading helpers as required.
        $this->load->helper('directory');
        $this->load->helper('form');
    }


    /**
     * index
     */
    public function index()
    {

        // set the view


        $tesseract = shell_exec(sprintf("which tesseract"));

        if(empty($tesseract)) {
            $data['err'] = "Tesseract library is not installed.";
            $data['view'] = 'home/errors';
        } else {

            $data['view'] = 'home/index';
        }


        // Load the view
        $this->load->view('template/index', $data);
    }

    /**
     * doUpload and process image
     */
    public function doUpload(){

        // configuration for uploading file
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|';
        $config['max_size']             = 2000;
        $config['max_width']            = 12000;
        $config['max_height']           = 8000;

        // loading upload library
        $this->load->library('upload', $config);

        // if upload not success
        if ( ! $this->upload->do_upload('hin_file'))
        {

            // sent the error
            $error = array('status' => 'fail', 'error' => $this->upload->display_errors());
            echo json_encode($error);

        } else { // if upload success

            // get the upload data
            $data = $this->upload->data();

            // run shell command for tesseract library
            exec('tesseract ' . $data['full_path'] . ' ' . $data['file_path'] . 'output');

            // get the file content
            $file = fopen($data['file_path'] . 'output.txt', 'r');

            $parseLines = array();
            // parsing content
            while( !feof($file)) {

                // get each line
                $line = trim(fgets($file));
                if($line != "") {

                    // parsing each line
                    $parseLines[] = preg_replace('/(\s|&#09;|&nbsp;)+/mu',' ',$line);
                }
            }
            // sleep for 2 second and then delete the uploaded file
            sleep(2);
            unlink($data['full_path']);

            // send the result
            echo json_encode(['status' => 'success', 'content' => $parseLines]);
        }
    }
}