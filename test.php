<?php
require_once('WsWebform.php');

// Emulate data filled from an array, this replaces: $data = $_REQUEST;
$uid = time();
$data = array(
    'firstname' => 'n' . $uid,
    'lastname' => 'ln' . $uid,
    'email' => $uid . '@example.com',
    'potential_name' => 'My Potential ' . $uid,
    'potential_amount' => $uid / 1000,
    'potential_closingdate' => date('Y-m-d'),
    'potential_sales_stage' => 'Prospecting',
);

// Config data for the REST service
$config = array(
    'url' => 'http://localhost/corebos/',
    'user' => 'admin',
    'password' => '',
    'map' => array(
        'Contacts' => array(
            'fields' => array(
                'firstname',
                'lastname',
                'email',
            ),
            'matching' => array(
                'or' => array(
                    'and' => array(
                        'firstname',
                        'lastname',
                    ),
                    'email',
                ),
            ),
            'has' => array(
                'Potentials' => array(
                    'fields' => array(
                        'related_to' => '[Contacts]',
                        'potentialname' => 'potential_name',
                        'closingdate' => 'potential_closingdate',
                        'sales_stage' => 'potential_sales_stage',
                    ),
                    'matching' => array(
                        'related_to',
                        'potentialname',
                    ),
                ),
            ),
        ),
    ),
);

$webform = new WsWebform($config);

// Process the form
$webform->send($data);

// Process the form again to test the duplicate matching
$webform->send($data);

