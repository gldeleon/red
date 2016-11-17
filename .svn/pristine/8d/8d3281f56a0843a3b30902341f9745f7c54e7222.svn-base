<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'modelAltaClinic.php';
$model = new model();
//include "../config.inc.php";
if (isset($_POST['nombre'])) {
    $checa = $model->ChecaExist($_POST);
    if (count($checa) > 0) {
        $rs = array('error');
        echo json_encode($rs);
    } else {
        $rs = array('ok');
        echo json_encode($rs);
    }
    exit();
} else {
    if (!empty($_POST) && isset($_POST)) {

        //$user = $_POST['usr'];
        //die($user);
        $clinic = $model->GuardaClinica($_POST);
        //die($clinic);
        if ($clinic) {
            $treatprice = $model->GuardaTreatPrice($_POST);
            if ($treatprice) {
                $user = $model->GuardaUser($_POST);
                if ($user) {
                    $userClinic = $model->GuardaUserClinic($_POST);
                    if ($userClinic) {
                        $ok = 'OK';
                        echo json_encode($ok);
                        exit();
                    } else {
                        die('Algo salió mal al guardar el userClinic');
                    }
                } else {
                    die('Algo salió mal al guardar el user');
                }
            } else {
                die('Algo salió mal al guardar el treatuser');
            }
        } else {
            die('Algo salió mal al guardar la clinic');
        }
    }
}

