<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class generatePDF extends Controller
{

    public function generate()
    {
        // Data to pass to the view
        $data = [
            'title' => 'Laravel PDF Demo',
            'name' => 'John Doe',
            'data' => [
                'Email' => 'john@example.com',
                'Phone' => '+1234567890'
            ]
        ];

        // Load the Blade view
        $pdf = Pdf::loadView('pdf.template', $data);

        // Customize PDF settings (optional)
        $pdf->setPaper('A4', 'portrait'); // Default is 'A4', 'portrait'
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, // Enable external images/CSS
        ]);

        // Stream, download, or save the PDF
        return $pdf->stream('custom-file-name.pdf'); // View in browser
        // return $pdf->download('custom-file-name.pdf'); // Force download
        // $pdf->save(storage_path('app/public/file-name.pdf')); // Save to storage
    }
}
