<?php

namespace raphiz\passwordcards;

class PDFRenderer
{
    public static function render($front, $back)
    {
        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetAuthor('Raphael Zimmermann');
        $pdf->SetTitle('Password Card');
        $pdf->SetSubject('Password Card');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // add a page
        $pdf->AddPage();

        // Mark the position to fold...
        $pdf->Line(95, 10, 95, 13);
        $pdf->Line(95, 72, 95, 75);

        // Add the front svg
        $pdf->ImageSVG(
            $file = $front,
            $x = 10,
            $y = 15,
            $w = '85',
            $h = '55'
        );

        // Add the back svg
        $pdf->ImageSVG(
            $file = $back,
            $x = 95,
            $y = 15,
            $w = '85',
            $h = '55'
        );


        //Close and output PDF document
        return $pdf->Output('generated.pdf', 'S');
    }
}
