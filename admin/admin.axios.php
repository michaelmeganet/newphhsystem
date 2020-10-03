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
    case 'processData':
        $dataType = $received_data->dataType;
        if ($dataType == 'Staff'){//create array for staff
            $data_array = array(
                'staffid' => $received_data->staffid,
                'name' => $received_data->name,
                'division' => $received_data->division,
                'qrcode' => $received_data->qrcode,
                'status' => $received_data->status,
                'staff_level' => $received_data->staff_level
            );
            $id = $received_data->sfid;
            $table = 'admin_staff';
            $tableKey = 'sfid';
        }elseif($dataType == 'Machine'){
            $data_array = array(
                'machineid' => $received_data->machineid,
                'name' => $received_data->name,
                'model' => $received_data->model,
                'machine_no' => $received_data->machine_no,
                'index_per_hour' => $received_data->index_per_hour,
                'max_table_load_kg' => $received_data->max_table_load_kg,
                'qrcode' => $received_data->qrcode
            );
            $id = $received_data->mcid;
            $table = 'machine';
            $tableKey = 'mcid';
        }       
        
        $mdlType = $received_data->mdlType;
        switch($mdlType){
            case 'edit': //this is update data
                $arrCount = count($data_array);
                $cnt = 0;
                $qr = "UPDATE $table SET ";
                foreach($data_array as $key => $val){
                    $cnt++;
                    $qr .= " $key =:$key";
                    if ($cnt != $arrCount){
                        $qr.= " , ";
                    }
                           
                }
                $qr .= " WHERE $tableKey = $id";
                #echo "qr = $qr\n";
                $objSQLU = new SQLBINDPARAM($qr,$data_array);
                $result = $objSQLU->UpdateData2();
                if ($result == 'Update ok!'){
                    echo "Successfully Updated $table\n"
                    . "($tableKey = $id)";
                }else{
                    echo "Failed to update.\n"
                    . "Please Contact Administrator";
                }
                break;
            case 'create': //this is create data
                $arrCount = count($data_array);
                $cnt = 0;
                $qr = "INSERT INTO $table SET ";
                foreach($data_array as $key => $val){
                    $cnt++;
                    $qr .= " $key =:$key";
                    if ($cnt != $arrCount){
                        $qr.= " , ";
                    }
                           
                }
                #echo "qr = $qr\n";
                $objSQLU = new SQLBINDPARAM($qr,$data_array);
                $result = $objSQLU->InsertData2();
                if ($result == 'insert ok!'){
                    echo "Successfully Inserted new Data into : $table\n";
                }else{
                    echo "Failed to insert.\n"
                    . "Please Contact Administrator";
                }
                break;
            case 'delete':
                $qr = "DELETE FROM $table WHERE $tableKey = $id";
                $objSQLD = new SQL($qr);
                $result = $objSQLD->getDelete();
                if ($result == 'deleted'){
                    echo "Successfully Deleted data from $table !\n"
                            . "$tableKey = $id";
                }else{
                    echo "Failed to delete data.\n"
                    . "Please Contact Administrator";
                }
                break;
        }
        
        #var_dump($received_data);
        break;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

