<?php
/*************************************************************************************************
 * Copyright 2014 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
 * You can copy, adapt and distribute the work under the "Attribution-NonCommercial-ShareAlike"
 * Vizsage Public License (the "License"). You may not use this file except in compliance with the
 * License. Roughly speaking, non-commercial users may share and modify this code, but must give credit
 * and share improvements. However, for proper details please read the full License, available at
 * http://vizsage.com/license/Vizsage-License-BY-NC-SA.html and the handy reference for understanding
 * the full license at http://vizsage.com/license/Vizsage-Deed-BY-NC-SA.html. Unless required by
 * applicable law or agreed to in writing, any software distributed under the License is distributed
 * on an  "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations under the
 * License terms of Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (the License).
 *************************************************************************************************
 *  Module       : coreBOSwsWebform
 *  Version      : 1.0
 *  Author       : JPL TSolucio, S. L.
 *************************************************************************************************/

$DEBUG = true;
$redirect = "";

ob_start();

if ($DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}

// Config data for the REST service
$defaults = array(
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
                    ),
                    'defaults' => array(
                        'sales_stage' => 'Qualification',
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
$config = array();
@include('config.php');
$config += $defaults;

require_once('WsWebform.php');

// Emulate data filled from FORM submit data, this replaces: $data = $_REQUEST;
$uid = time();
$data = array(
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'potential_name' => $_POST['potential_name'],
    'potential_closingdate' => $_POST['potential_closingdate'],
);

try {
    $webform = new WsWebform($config);
    // Create entity
    if (!$webform->send($data) && $DEBUG) {
        var_dump($webform->lastError());
    }
    // Update
    if (!$webform->send($data) && $DEBUG) {
        var_dump($webform->lastError());
    }
    // Test for duplicate
    if (!$webform->send($data, false) && $DEBUG) {
        $error = $webform->lastError();
        if (!$error) {
            echo "<p>Already exists.</p>";
        } else {
            var_dump($error);
        }
    }
} catch (Exception $e) {
    if ($DEBUG) {
        echo $e->getMessage();
    }
}

if (!$DEBUG) {
    header('Location: ' . $redirect);
} else {
    ob_end_flush();
}

