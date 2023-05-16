<?php 

$arquivo = 'consolidado.xls';

$html = '';
$html .= '<table border="0">';
$html .= '<tr>';
$html .= '<td><b>Codigo</b></td>';
$html .= '<td><b>Codigo Fantasia</b></td>';
$html .= '<td><b>Cep</b></td>';
$html .= '<td><b>Cidade</b></td>';
$html .= '<td><b>Logradouro</b></td>';
$html .= '<td><b>UF</b></td>';
$html .= '</tr>';

foreach ($customers as $customer) {
        $html .= '<tr>';
        $html .= '<td>' . $customer->codigo . '</td>';
        $html .= '<td>' . $customer->fantasia . '</td>';
        $html .= '<td>' . $customer->cep . '</td>';
        $html .= '<td>' . $customer->cidade . '</td>';
        $html .= '<td>' . $customer->logradouro . '</td>';
        $html .= '<td>' . $customer->uf . '</td>';
    }


    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/charset='utf-8'");
    header("Content-type: application/x-msexcel");
    header("Content-type: application/charset='utf-8'");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: PHP Generated Data");  	   
    echo $html;

?>


 