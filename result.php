<?php
// Start a session
session_start();
// Include our JNE class
require_once('classes/JNE.php');

// Create an instance of JNE class
$jne = new JNE();
// Get the result!
$jne->getResult();