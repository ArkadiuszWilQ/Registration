<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\View\Helper\HtmlHelper;
use Cake\View\View;


class pdfTestShell extends Shell
{

    public function main(string $name = 'Ktosiu')
    {
        $CakePdf = new \CakePdf\Pdf\CakePdf(['engine' => 'CakePdf.Mpdf']);
        $CakePdf->template('draft', '');
        $CakePdf->viewVars(array('name' => $name));
//        $pdf = $CakePdf->output();
        $pdf = $CakePdf->write(APP . 'Template' . DS . 'Pdf' . DS . 'test.pdf');
    }
}