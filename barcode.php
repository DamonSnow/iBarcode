<?php
/**
 * Created by PhpStorm.
 * User: Damon
 * Date: 2018/3/15
 * Time: 9:31
 */

require './vendor/autoload.php';
$barcode = new \IBarcode\Barcode();
$text = empty($_GET['text']) ? 'TEST' : $_GET['text'];
$codeType = empty($_GET['codeType']) ? 'code128' : $_GET['codeType'];
$font = empty($_GET['font']) ? 1 : $_GET['font'];
$rotation = empty($_GET['rotation']) ? 0 : $_GET['rotation'];
$dpi = empty($_GET['dpi']) ? 0 : $_GET['dpi'];
$fileType = empty($_GET['fileType']) ? 'PNG' : $_GET['fileType'];
$barcode->render($text, 'code128', $font, $rotation, $dpi, $fileType);