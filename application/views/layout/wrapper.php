<?php
// Load all layout parts
$this->load->view('layout/header');
$this->load->view('layout/sidebar');
$this->load->view($content);
$this->load->view('layout/footer');
