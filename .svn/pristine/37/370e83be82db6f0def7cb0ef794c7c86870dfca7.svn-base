<?php

$status = "";

if ($_POST["action"] == "subir") {
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    $prefijo = substr(md5(uniqid(rand())), 0, 6);
    if ($archivo != "") {
        $destino = "images/slider/" . $prefijo . "_" . $archivo;
        if (copy($_FILES['archivo']['tmp_name'], $destino)) {
            $status = "Archivo subido: <b>" . $archivo . "</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }
}
else
    echo "No se completo el proceso"
    
?>