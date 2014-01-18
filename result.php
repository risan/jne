<?php
// Start a session
session_start();
// Include our JNE class
require_once('classes/JNE.php');

// Create an instance of JNE class
$jne = new JNE();
// Get the response
$response = $jne->getResponse();
// Parse response
$data = $jne->parseResponse($response);
$header = $data['header'];
$content = $data['content'];
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>JNE Tariff Scraper</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <div class="container result">
            <h1>JNE Tariff Result</h1>
            <table class="header">
                <tbody>
                    <tr>
                        <th>From</th>
                        <td><?php echo $header['from'] ;?></td>
                    </tr>
                    <tr>
                        <th>To</th>
                        <td><?php echo $header['to'] ;?></td>
                    </tr>
                    <tr>
                        <th>Weight (kgs)</th>
                        <td><?php echo $header['weight'] ;?></td>
                    </tr>
                </tbody>
            </table>

            <table class="content">
                <thead>
                    <tr>
                        <?php foreach ($header['header'] as $field): ?>
                            <th><?php echo $field; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($content as $row): ?>
                        <tr>
                            <?php foreach ($row as $col): ?>
                                <td><?php echo $col;?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="index.php" class="btn">Check Another Tariff</a>
        </div>
    </body>
</html>