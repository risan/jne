<?php
// Include our JNE class
require_once('classes/JNE.php');

// Create an instance of JNE class
$jne = new JNE();
// Echoing JNE locations suggestions list
echo $jne->getLocations();