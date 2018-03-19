<?php
/**
 * Created by PhpStorm.
 * User: Damon
 * Date: 2018/3/15
 * Time: 9:16
 */

namespace IBarcode;


use iBarcode\Barcode\BCGcodabar;
use iBarcode\Barcode\BCGcode11;
use iBarcode\Barcode\BCGcode128;
use iBarcode\Barcode\BCGcode39;
use iBarcode\Barcode\BCGcode39extended;
use iBarcode\Barcode\BCGcode93;
use iBarcode\Barcode\BCGean13;
use iBarcode\Barcode\BCGean8;
use iBarcode\Barcode\BCGi25;
use iBarcode\Barcode\BCGisbn;
use iBarcode\Barcode\BCGmsi;
use iBarcode\Barcode\BCGothercode;
use iBarcode\Barcode\BCGpostnet;
use iBarcode\Barcode\BCGs25;
use iBarcode\Barcode\BCGupca;
use iBarcode\Barcode\BCGupce;
use iBarcode\Barcode\BCGupcext2;
use iBarcode\Barcode\BCGupcext5;
use iBarcode\Common\BCGColor;
use iBarcode\Common\BCGDrawing;
use iBarcode\Common\BCGFontFile;

class Barcode
{
    protected $codeType;

    /**
     * Barcode constructor.
     * @param $codeType
     */
    public function __construct($codeType = 'code128')
    {
        $this->codeType = $codeType;
    }

    public function render($text, $codeType, $font = null, $rotation = 0, $dpi = 72, $fileType = 'PNG')
    {
        $filetypes = ['PNG' => BCGDrawing::IMG_FORMAT_PNG, 'JPEG' => BCGDrawing::IMG_FORMAT_JPEG, 'GIF' => BCGDrawing::IMG_FORMAT_GIF];
        // The arguments are R, G, B for color.
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $font = (empty($font)) ? 0 : new BCGFontFile(__DIR__ . '/../font/Arial.ttf', (int)$font);
        $drawException = null;
        $code = $this->code($codeType, $color_black, $color_white, $font, $text);


        /* Here is the list of the arguments
        1 - Filename (empty : display on screen)
        2 - Background color */
        $drawing = new BCGDrawing('', $color_white);
        if ($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->setRotationAngle($rotation);
            $drawing->setDPI($dpi);
            $drawing->draw();
        }
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="barcode.png"');
        // Draw (or save) the image into PNG format.
        $drawing->finish($filetypes[$fileType]);
    }

    /**
     * @return string
     */
    public function getCodeType(): string
    {
        return $this->codeType;
    }

    /**
     * @param string $codeType
     */
    public function setCodeType(string $codeType)
    {
        $this->codeType = $codeType;
    }

    public function code($codeType, $color_black, $color_white, $font, $text)
    {
        $code = $this->getObj($codeType);
        $code->setScale(2); // Resolution
        $code->setThickness(30); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->setStart(null);
        $code->setTilde(true);
        $code->parse($text); // Text
        return $code;
    }

    public function getObj($codeType)
    {
        switch ($codeType) {
            case "code128":
                return new BCGcode128();
                break;
            case "codabar":
                return new BCGcodabar();
                break;
            case "code11":
                return new BCGcode11();
                break;
            case "code39":
                return new BCGcode39();
                break;
            case "code39extended":
                return new BCGcode39extended();
                break;
            case "code93":
                return new BCGcode93();
                break;
            case "ean8":
                return new BCGean8();
                break;
            case "ean13":
                return new BCGean13();
                break;
            case "i25":
                return new BCGi25();
                break;
            case "isbn":
                return new BCGisbn();
                break;
            case "msi":
                return new BCGmsi();
                break;
            case "othercode":
                return new BCGothercode();
                break;
            case "postnet":
                return new BCGpostnet();
                break;
            case "s25":
                return new BCGs25();
                break;
            case "upca":
                return new BCGupca();
                break;
            case "upce":
                return new BCGupce();
                break;
            case "upcext2":
                return new BCGupcext2();
                break;
            case "upcext5":
                return new BCGupcext5();
                break;
            default:
                return new BCGcode128();
        }
    }
}