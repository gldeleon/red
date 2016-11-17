<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once '../config.inc.php';


abstract class database {

    private $DBServer = "localhost";
    private $DBUser = "kobemxco_dental";
    private $DBPaswd = "*h!qj6e29usE";
    private $DBName = "kobemxco_red";
    private $cnx;
    protected $query;

    /* private static $usr = "kobemxco_dental";
      private static $pwd = "*h!qj6e29usE";
      private $cnx;
      protected $query;
      private $host = "localhost";
      private $dbname = "kobemxco_red"; */

    #Abre la conexión a la base de datos

    private function AbreCnx() {
        $this->cnx = mysqli_connect($this->DBServer, $this->DBUser, $this->DBPaswd);
        if (!$this->cnx) {
            die('no se pudo conectar 1' . mysqli_error());
        }
        $sdb = mysqli_select_db($this->cnx, $this->DBName);
        if (!$sdb) {
            die('no se pudo conectar 2 ' . mysqli_error($sdb));
        }
    }

    #Cierra la conexion a la base de datos

    private function CierraCnx() {
        mysqli_close($this->cnx);
    }

    #Ejecuta un query simple del tipo INSERT, DELETE, UPDATE

    protected function Create() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query);
        return $resultado;
        $this->CierraCnx();
    }

    protected function Read() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query);
        return $this->FetchArray($resultado);
        $this->CierraCnx();
    }

    protected function Update() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query);
        $r = $this->NumRows($result);
        return $r;
        $this->CierraCnx();
    }

    protected function Delete() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query);
        $r = $this->NumRows($result);
        return $r;
        $this->CierraCnx();
    }

    #Obtiene la cantidad de filas afectadas en BD

    function NumRows($result) {
        return mysqli_num_rows($result);
    }

    #Regresa arreglo de datos asociativo

    function FetchArray($result) {
        return mysqli_fetch_array($result);
    }

}
