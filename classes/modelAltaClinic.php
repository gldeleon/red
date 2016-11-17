<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'database.php';

//include "config.inc.php";
class model extends database {

//class model{

    function GuardaClinica($datos) {
        $this->query = "INSERT INTO clinic
        (clt_id, cli_name, cli_shortname, cli_tel, cli_email, cli_dir, cli_webdir, cli_webloc, clc_id, cli_chairs, cli_type, cli_active, stt_id, cli_lat, cli_lng)
        values(1, '" . $datos['nclinica'] . "', '" . $datos['ncclinica'] . "', '" . $datos['tel'] . "', '" . $datos['email'] . "', '" . $datos['dir'] . ", " . $datos['municipio'] . ", " . $datos['edo'] . ", " . $datos['cp'] . "', 'web', 'webloc', '280', 1, 1, 1, '2', '" . $datos['lat'] . "', '" . $datos['lng'] . "')";
        $result = $this->Create();
        return $result;
    }

    function GuardaTreatPrice($datos) {
        $this->query = "INSERT INTO treatprice
                        SELECT
                            NULL, q.trt_id, (SELECT cli_id FROM clinic WHERE cli_shortname = '" . $datos['ncclinica'] . "') AS cli_id, q.trp_price, CURDATE(), 2
                        FROM
                            (SELECT
                                *
                            FROM
                                treatprice
                            WHERE
                                cli_class = 2
                            ORDER BY trt_id ASC , trp_date DESC) AS q";
        $result = $this->Create();
        return $result;
    }

    function GuardaUser($datos) {
        $this->query = "INSERT INTO user
                        values(null, 0, '" . $datos['usr'] . "', md5('" . $datos['pwd'] . "'), '110',
                            (SELECT concat(a.cli_id,':00:00:00:00') as Clinic
                              FROM (SELECT cli_id
                                    FROM clinic
                                    WHERE cli_shortname = 'DR GEOVAS') AS a)
                             , 1, CURDATE())";
        $result = $this->Create();
        return $result;
    }

    function GuardaUserClinic($datos) {
        $this->query = "INSERT INTO userclinic
                       (SELECT null, usr_id,
                       (SELECT cli_id
                        FROM clinic
                        WHERE cli_shortname = '" . $datos['ncclinica'] . "'), '111'
                        FROM user
                        where usr_name = '" . $datos['usr'] . "')";
        $result = $this->Create();
        return $result;
    }

    function ChecaExist($nombre) {
        $this->query = "SELECT * FROM clinic
                        WHERE cli_name = '" . $nombre['nombre'] . "'";
        $result = $this->Read();
        return $result;
    }

}
