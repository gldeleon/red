<?php
if (!isset($_SERVER['HTTP_REFERER']) || strlen($_SERVER['HTTP_REFERER']) < 1)
    exit();
session_name("pra8atuw");
session_start();
if (count($_SESSION) > 0)
    extract($_SESSION);
else {
    $_SESSION = array();
    session_destroy();
    header("Location: logout.php");
}

/** Llama al archivo de configuracion. */
include "../config.inc.php";

$cli = (isset($_GET["profile"]) && !empty($_GET["profile"])) ? $_GET["profile"] : "0";
$cli = (isset($_GET["cli"]) && !empty($_GET["cli"])) ? $_GET["cli"] : $cli;
$uname = empty($uname) ? "Usuario" : $uname;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $AppTitle; ?></title>
        <link href="../red.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../modules/jquery/themes/default/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/themes/light/light.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/themes/dark/dark.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/themes/bar/bar.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/css/nivo-slider.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../modules/jquery/css/cupertino/jquery-ui-1.9.2.custom.css" type="text/css" media="screen" />

        <script type="text/javascript">
            /* [CDATA[ */
            var cli = "<?= $cli; ?>";
            /* ]] */
        </script>
        <script type="text/javascript" src="../modules/ajax.js"></script>
        <script type="text/javascript" src="../modules/createMenu.js"></script>
        <script type="text/javascript" src="../modules/welcome.js"></script>
        <script type="text/javascript" src="../modules/newPatientDialog.js"></script>
        <script type="text/javascript" src="../modules/jquery/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="../modules/jquery/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="../modules/jquery/jquery.nivo.slider.js"></script>
        <script type="text/javascript" src="../modules/jquery/jquery.youtubepopup.min.js"></script>
<!--		<script type="text/javascript" src="../modules/jquery/videoselector.js"></script> -->
        <script>
            function popup(num) {
                var height = "auto";
                var width = 920;
                if (num == 2) {
                    height = 450;
                    width = "auto";
                }
                $("#dialog" + num).dialog({
                    title: "Sistema Kobe",
                    resizable: false,
                    modal: true,
                    width: width,
                    height: height,
                    close: function () {
                        $(this).dialog("close");
                    }
                });
            }
        </script>
    </head>
    <body>

        <script type="text/javascript">
            $(window).load(function () {
                $('#slider').nivoSlider();
                //$("#iPjQQQjKvZc").YouTubePopup({autoplay : 0, idAttribute: 'id'});
            });
        </script>

        <div id="cfg" style="display: none" ><?= $uid; ?></div>
        <div id="resFilter" style="top: 0px; left: 0px; overflow-x: hidden; overflow-y: scroll"></div>
        <? include "newPatient.inc.php"; ?>
        <div id="subMenu" style="position: absolute; visibility: hidden;"></div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white">
            <tr>
                <td width="40" height="20" style="border-top: 1px solid #E6701D; border-left: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="20" style="border-top: 1px solid #E6701D;">&nbsp;</td>
                <td style="border-top: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="20" style="border-top: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="20" style="border-top: 1px solid #E6701D; border-right: 1px solid #E6701D;">&nbsp;</td>
            </tr>
            <tr>
                <td width="40" height="10" style="border-left: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="10" style="background-color: #FDB031; border-bottom: 1px solid #E6701D; border-left: 1px solid #E6701D; border-top: 1px solid #E6701D;">&nbsp;</td>
                <td width="100%" height="10"  align="center" face="verdana" style="background-color: #FDB031; border-top: 1px solid #E6701D; border-bottom: 1px solid #E6701D"><b><label class="title1">BIENVENIDO A RED KOBE</label></b></td>
                <td width="40" height="10" style="background-color: #00ABA9; border-bottom: 1px solid #E6701D; border-right: 1px solid #E6701D; border-top: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="20" alt="" /></td>
                <td width="40" height="10" style="border-right: 1px solid #E6701D;">&nbsp;</td>
            </tr>
            <tr>
                <td width="20" height="5px" style="border-left: 1px solid #E6701D;">&nbsp;</td>
                <td align="center" height="5px" valign="middle" style="height: 10%; border-left: 1px solid #E6701D;"><!--<img src="../images/spacer.gif" width="40" height="40" alt="" /> --></td>
                <td valign="middle" height="5px" align="center" style="height: 5px; border-bottom: 1px solid rgb(230, 112, 29);" id="mn" rowspan="2">
                    <!--<div style="float: left; width: 625px;">
                             <p>Estimado(a) Doctor(a), para descargar el material publicitario, haz clic en el botón correspondiente:</p>
                            <input type="button" onclick="location.href='descargaPDF.php?f=Poster_AXA.pdf'" class="large" value="Cartel AXA"> (51.8 MB)<br><br>
                            <input type="button" onclick="location.href='descargaPDF.php?f=Poster_SMNYL.pdf'" class="large" title="Cartel Seguros Monterrey New York Life" value="Cartel SMNYL"> (85.1 MB)<br><br>
                            <input type="button" onclick="location.href='descargaPDF.php?f=Lona_Axa.pdf'" class="large" value="Lona AXA"> (60.2 MB)<br><br>
                            <input type="button" onclick="location.href='descargaPDF.php?f=Lona_SMNYL.pdf'" class="large" title="Lona Seguros Monterrey New York Life" value="Lona SMNYL"> (85.1 MB)<br><br>
                    </div>
                    <div style='text-align: center; float: right; width: 400px;'></div>
                    <div style="clear: both;"></div>-->
                    <!-- <img src="../images/lavaprom05.png" style="cursor: pointer;" width="900" height="305" alt="Promociones LAVA" title="Promociones 3M abril - junio 2013" onclick="location.href='descargaPDF.php?f=prom3m_abr-jun_13.pdf'" /> -->
                    <!-- <div id="wrapper">-->
                    <div id="wrapper" class="slider-wrapper theme-default">
                        <div id="slider" class="nivoSlider">
                            <a href="Manual_Capacitacion_Red_Kobe.pdf" target="_blank"><img src="../images/slider/banner_manual_capacitación_Kobe.jpg" data-thumb="../images/slider/banner_manual_capacitación_Kobe.jpg" data-transition="slideInLeft"/></a>
                            <img src="../images/slider/2016-04/Baja SMNYL.png" data-thumb="../images/slider/2016-04/Baja SMNYL.png" data-transition="slideInLeft"/>
                            <img src="../images/slider/2016-01/revisin y consulta banner-01.jpg" data-thumb="../images/slider/2016-01/revisin y consulta banner-01.jpg" data-transition="slideInLeft"/>
                            <img src="../images/slider/2015-12/Política de garantías_banner-01-02.jpg" data-thumb="../images/slider/2015-12/Política de garantías_banner-01-02.jpg" data-transition="slideInLeft"/>
                            <a href="TRATAMIENTOS POR ESPECIALIDAD.xlsx"><img src="../images/slider/2015-12/Tratamientos exclusivos de la especialidad-02.jpg" data-thumb="../images/slider/2015-12/Tratamientos exclusivos de la especialidad-02.jpg" data-transition="slideInLeft"/></a>
                            <!-- <img src="../images/slider/2015-11/supervision_dent.jpg" data-thumb="../images/slider/2015-11/supervision_dent.jpg" data-transition="slideInLeft"/> -->
                            <a href="Papelería Kobe Completa PDF.zip"><img src="../images/slider/2015-11/Formatos expediente clínico_banner-02.jpg" data-thumb="../images/slider/2015-11/Formatos expediente clínico_banner-02.jpg" data-transition="slideInLeft"/></a>
                            <a href="Consulta de Precios por Plan_RED KOBE.XLSX"><img src="../images/slider/2015-10/Procedimiento de atención al paciente parte 2-02.jpg" data-thumb="../images/slider/2015-10/Procedimiento de atención al paciente parte 2-02.jpg" data-transition="slideInLeft"/></a>
                            <img src="../images/slider/2015-10/Procedimiento de atención al paciente parte 1-02.jpg" data-thumb="../images/slider/2015-10/Procedimiento de atención al paciente parte 1-02.jpg" data-transition="slideInLeft"/>
                            <!-- <img src="../images/slider/2015-10/Lanzamiento y el porqué de la política kobe-02.jpg" data-thumb="../images/slider/2015-10/Lanzamiento y el porqué de la política kobe-02.jpg" data-transition="slideInLeft"/> -->
                            <img src="../images/slider/2015-08/atencion_red.jpg" data-thumb="../images/slider/2015-08/atencion_red.jpg" data-transition="slideInLeft"/>
                            <!-- <img src="../images/slider/2015-02/Día Odontólogo 2015.png" data-thumb="../images/slider/2015-02/Día Odontólogo 2015.png" data-transition="slideInLeft"/> -->
                            <!-- <img src="../images/slider/2014-05/postalaempresas01.jpg" data-thumb="../images/slider/2014-05/postalaempresas01.jpg" data-transition="slideInLeft"/> -->
                            <!-- <img src="../images/slider/2014-12/pagos-02.jpg" data-thumb="../images/slider/2014-12/pagos-02.jpg" data-transition="slideInLeft"/> -->
                            <!--<img src="../images/slider/2014-11/client2.jpg" data-thumb="../images/slider/2014-11/client2.jpg" data-transition="slideInLeft"/> -->
                            <img src="../images/slider/2014-12/recordar-01.jpg" data-thumb="../images/slider/2014-12/recordar-01.jpg" data-transition="slideInLeft"/>
                            <!-- <img src="../images/slider/2014-05/unknown.jpeg" data-thumb="../images/slider/2014-05/unknown.jpeg" data-transition="slideInLeft"/> -->
                            <a class ="youtube" id="WviNzcdvr2w"><img src="../images/slider/youtube.jpg" data-thumb="../images/slider/youtube.jpg" ></a>
                            <!-- <img src="../images/slider/tarjetas.jpg" data-thumb="../images/slider/tarjetas.jpg" data-transition="slideInLeft"/> -->
                            <!-- <img src="../images/slider/banner_kobe-03.jpg" data-thumb="../images/slider/banner_kobe-02.jpg" data-transition="slideInLeft"/> -->
                            <!--<img src="../images/slider/2014-04/1mayoRED.jpg" data-thumb="../images/slider/2014-04/1mayoRED.jpg" data-transition="slideInLeft"/>-->
                            <!-- img src="../images/slider/2014-04/BANNERREDAXA-01.jpg" data-thumb="../images/slider/2014-04/BANNERREDAXA-01.jpg" data-transition="slideInLeft"/ -->
                            <!--<img src="../images/slider/2014-04/internos01.jpg" data-thumb="../images/slider/2014-04/internos01.jpg" data-transition="slideInLeft"/>-->
                            <!-- <a href="#" id="bottle" onclick="popup(2);" >
                                <img src="../images/slider/2014-03/BANNER_RED_AXA-01.jpg" data-thumb="../images/slider/2014-03/BANNER_RED_AXA-01.jpg" data-transition="slideInLeft"/>
                            </a> -->
                            <!--							<a href="#" id="bottle" onclick="popup(1);" >
                                                            <img src="../images/slider/2013-08/bannerchico.jpg" data-thumb="../images/slider/2013-08/bannerchico.jpg" data-transition="slideInLeft"/>
                                                        </a>-->
                                                        <!-- <a href="descargaPDF.php?f=pdfManual.rar"><img src="../images/slider/2014-10/descarga-01.png" data-thumb="../images/slider/2014-09/descarga-01.png" data-transition="slideInLeft"/> -->
                                                        <!--<img src="../images/slider/2013-12/SISTEMA.JPG" data-thumb="../images/slider/2013-12/SISTEMA.JPG" data-transition="slideInLeft"/>-->
                                                        <!--<img src="../images/slider/2013-12/postal.jpg" data-thumb="../images/slider/2013-12/postal.jpg" data-transition="slideInLeft"/>-->
                                                        <!--<img src="../images/slider/2013-10/PlanSeguroPostal.jpg" data-thumb="../images/slider/2013-10/PlanSeguroPostal.jpg" data-transition="slideInLeft"/>-->
                                                        <!-- <a href="descargaPDF.php?f=3M-OCT-ENE2014Copy.pdf"><img src="../images/slider/2013-10/Unknown.png" data-thumb="../images/slider/2014-09/postal-01.jpg" data-transition="slideInLeft"/>-->
                                                        <!--<a href="https://3m.app.box.com/s/58to1hucairy24lirram" target="_BLANK"><img src="../images/slider/2013-10/Unknown.png" data-thumb="../images/slider/2013-10/Unknown.png" data-transition="slideInLeft"/>-->
                                                        <!--<a href="descargaPDF.php?f=Promo3MRedKobe_30nov.pdf"><img src="../images/slider/2013-10/BANNER-PROMO-OCTUBRE-03.jpg" data-thumb="../images/slider/2013-10/BANNER-PROMO-OCTUBRE-03.jpg" data-transition="slideInLeft"/>-->
                                                        <!--<a href="descargaPDF.php?f=Promo3MRedKobe_30nov.pdf"><img src="../images/slider/2013-10/BANNERPROMOOCTUBRE-04.jpg" data-thumb="../images/slider/2013-10/BANNERPROMOOCTUBRE-04.jpg" data-transition="slideInLeft"/>-->
                                                        <!--<img src="../images/slider/2013-08/nuevosclientes3M.jpg" data-thumb="../images/slider/2013-08/nuevosclientes3M.jpg" data-transition="slideInLeft"/>-->
                                                        <!--<img src="../images/slider/ClientesBanner.jpg" data-thumb="../images/slider/ClientesBanner.jpg" data-transition="slideInLeft"  class=""/>-->
                                                        <!--<a href="descargaPDF.php?f=TercerTrimestre.pdf"><img src="../images/slider/PromosTrimestral3mRedKobeJul18.jpg" data-thumb="../images/slider/PromosTrimestral3mRedKobeJul18.jpg" data-transition="slideInLeft"/>-->
                                                        <!-- <a href="descargaPDF.php?f=Promo3MRedKobeJulio.pdf"><img src="../images/slider/PromosVerano3mRedKobeJul18.jpg" data-thumb="../images/slider/PromosVerano3mRedKobeJul18.jpg" data-transition="slideInLeft"/> -->
                                                        <!--<img src="../images/slider/KOBE_BANNER.jpg" data-thumb="../images/slider/KOBE_BANNER.jpg" data-transition="slideInLeft"  class=""/>-->
                                                        <!-- <img src="../images/slider/entrega_doc.jpg" data-thumb="../images/slider/entrega_doc.jpg" data-transition="slideInLeft"/> -->
                                                        <!-- <img src="../images/slider/lavaprom05.png" data-thumb="../images/slider/lavaprom05.png"/> -->
                                                        <!-- <a href="descargaPDF.php?f=prom3m_abr-jun_13.pdf"><img src="../images/slider/promo_descarga.jpg" data-thumb="../images/slider/promo_descarga.jpg" data-transition="slideInLeft"/> -->
                        </div>
                        <div id="dialog1" style="display:none">
                            <img src="../images/slider/2013-08/BANNERUSOSISTEMA-02.jpg" width="900px" height="340px"/>
                        </div>
                        <div id="dialog2" style="display:none; overflow-y: scroll;" >
                            <img src="../images/slider/2014-03/COMUNICADO_AXA-01.jpg"/>
                        </div>
                    </div>
                    <script>
                        if (("a.youtube").length > 0) {
                            //alert($("a.youtube").length);
                            //alert($("a.youtube").attr("id"));
                            var id = $("a.youtube").attr("id");
                            $("a.youtube").YouTubePopup({autoplay: 0, youtubeId: 'WviNzcdvr2w'});
                        } else
                            alert("aaa");
                    </script>
                    <!-- </div> -->
                </td>
                <!--  <td rowspan="2" align="left" valign="bottom" id="mn" style="height: 100%; border-bottom: 1px solid #E6701D;">
                        <p>Estimado(a) Doctor(a), para descargar el material publicitario, haz clic en el bot&oacute;n correspondiente:</p>
                        <input type="button" value="Cartel AXA" class="large" onclick="location.href='descargaPDF.php?f=Poster_AXA.pdf'" /> (51.8 MB)<br /><br />
                        <input type="button" value="Cartel SMNYL" title="Cartel Seguros Monterrey New York Life" class="large" onclick="location.href='descargaPDF.php?f=Poster_SMNYL.pdf'" /> (85.1 MB)<br /><br />
                        <input type="button" value="Lona AXA" class="large" onclick="location.href='descargaPDF.php?f=Lona_Axa.pdf'" /> (60.2 MB)<br /><br />
                        <input type="button" value="Lona SMNYL" title="Lona Seguros Monterrey New York Life" class="large" onclick="location.href='descargaPDF.php?f=Lona_SMNYL.pdf'" /> (85.1 MB)<br /><br />
                </td>-->
                <td align="center" valign="middle" style="height: 100%; border-right: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" alt="" /></td>
                <td width="20" style="border-right: 1px solid #E6701D;">&nbsp;</td>
            </tr>
            <tr>
                <td width="40" style="border-left: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="10" style="border-left: 1px solid #E6701D; border-bottom: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="10" style="border-right: 1px solid #E6701D; border-bottom: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" style="border-right: 1px solid #E6701D;">&nbsp;</td>
            </tr>
            <tr>
                <td width="40" height="10" style="border-left: 1px solid #E6701D; border-bottom: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" alt="" /></td>
                <td width="40" height="10" style="border-bottom: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" alt="" /></td>
                <td style="border-bottom: 1px solid #E6701D;">&nbsp;</td>
                <td width="40" height="10" style="border-bottom: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" alt="" /></td>
                <td width="40" height="10" style="border-right: 1px solid #E6701D; border-bottom: 1px solid #E6701D;"><img src="../images/spacer.gif" width="40" height="40" alt="" /></td>
            </tr>
        </table>
    </body>
</html>