<?php

include_once '../class/dbh.inc.php';
include_once '../class/variables.inc.php';
include_once '../class/generateQRCodes.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();
$action = $received_data->action;


function getQRData($dataType) {
    switch ($dataType) {
        case 'machine':
            $qr = "SELECT machineid FROM machine";
            break;
        case 'staff':
            $qr = "SELECT staffid FROM admin_staff";
            break;
    }
    #echo "qr = " . $qr . "<br>";
    $objSQL = new SQL($qr);
    $data_array = $objSQL->getResultRowArray();
    return $data_array;
}

switch ($action) {
    case 'getListByDataType':
        $dataType = strtolower($received_data->dataType);
        if ($dataType == 'staff') {
            $qr = "SELECT * FROM admin_staff ORDER BY sfid ASC";
        } elseif ($dataType == 'machine') {
            $qr = "SELECT * FROM machine ORDER BY mcid ASC";
        }
        $objSQL = new SQL($qr);
        $result = $objSQL->getResultRowArray();
        if (!empty($result)) {
            foreach ($result as $key => $data_row) {
                $result[$key]['qrcode'] = "<img src='" . $data_row['qrcode'] . "' width='85' height='85' />";
            }
            echo json_encode($result);
        } else {
            $errArray[0] = array('status' => 'error', 'msg' => 'Cannot find any data.', 'query' => $qr);
            echo json_encode($errArray);
        }
        break;
    case 'generateQRCodes':
        $dataType = strtolower($received_data->dataType);
        switch ($dataType) {
            case 'machine':
                $dataKey = 'machineid';
                break;
            case 'staff':
                $dataKey = 'staffid';
                break;
        }
        $data_array = getQRData($dataType);
        #echo "dataType = $dataType<br>";
        $objGenQR = new QRCode_Generate($dataType, $data_array, $dataKey);
        $result = $objGenQR->generateQRCode();
        break;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

