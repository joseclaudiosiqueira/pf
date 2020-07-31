<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
?>
<!--new font-->
<link rel="stylesheet" type="text/css" href="/pf/login/css/main.css" />
<link rel="stylesheet" type="text/css" href="/pf/login/css/util.css" />
<!--google fonts
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Abel:400,400i,700">
<!--demais css-->
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/bootstrap/bootstrap.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/font-awesome/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/pf/css/dimension.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/pf/css/radio-style.css">
<link rel="stylesheet" type="text/css" href="/pf/css/checkbox-style.css">
<link rel="stylesheet" type="text/css" href="/pf/css/bootstrap-toggle.min.css">
<link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/semantic.css">
<link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/components/label.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/datepicker/datepicker.min.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/tagmanager/tagmanager.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/jquery.bootstrap-touchspin.min.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/selectize/selectize.bootstrap3.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/sweetalert/sweetalert.css">
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/box-table/box-table.css">
<link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/style.css">
<link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/blueimp-gallery.min.css">
<link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" type="text/css" href="/pf/vendor/fileUpload/css/jquery.fileupload-ui-noscript.css"></noscript>
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/labelholder/labelholder.min.css" />
<!-- the new chart.css-->
<link rel="stylesheet" type="text/css" href="/pf/css/vendor/chartjs/Chart.css" />