<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
use App\Models\Stagione;
use App\Models\Giocatore;
use App\Models\Genitore;
use App\Models\SeasonPlayer;

class DocumentController extends Controller
{
    public function moduloIscrizione(Request $request)
    {
        $inputFile = public_path('templates/moduloIscrizione.pdf'); // Percorso del file PDF di partenza
        $outputFile = public_path('results/modulo_iscrizione.pdf');    // Percorso del file PDF compilato

        $gio=Giocatore::with('genitore')->find($request->id_giocatore);
        $sta=Stagione::find($request->id_stagione);

        $pdf = new Fpdi();

        // Aggiungi una pagina (primo modulo PDF)
        $pdf->setSourceFile($inputFile);
        $templateId = $pdf->importPage(1);
        $pdf->addPage();
        $pdf->useTemplate($templateId, 0, 0, 210, 297);

        $pdf->SetFont('Helvetica', 'B');
        $pdf->SetFontSize(15);
        $pdf->SetXY(65, 63); // Posizione XY
        $pdf->Write(0, strtoupper($sta->descrizione));
        // Imposta il font
        $pdf->SetFont('Helvetica', 'B');
        $pdf->SetFontSize(12);


        $pdf->SetXY(40, 83); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->cognome));
        $pdf->SetXY(125, 83); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->nome));
        $pdf->SetXY(40, 92); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->luogo_nascita));
        $pdf->SetXY(135, 92); // Posizione XY
        $pdf->Write(0, Carbon::parse($gio->genitore->data_nascita)->format('d/m/Y'));
        $pdf->SetXY(40, 101); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->comune));
        $pdf->SetXY(125, 101); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->provincia));
        $pdf->SetXY(165, 101); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->cap));
        $pdf->SetXY(45, 110); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->indirizzo));
        $pdf->SetXY(30, 119); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->telefono));
        $pdf->SetXY(105, 119); // Posizione XY
        $pdf->Write(0, strtolower($gio->genitore->email));
        $pdf->SetXY(55, 128); // Posizione XY
        $pdf->Write(0, strtoupper($gio->genitore->codice_fiscale));

        $pdf->SetXY(40, 154); // Posizione XY
        $pdf->Write(0, strtoupper($gio->cognome));
        $pdf->SetXY(125, 154); // Posizione XY
        $pdf->Write(0, strtoupper($gio->nome));
        $pdf->SetXY(40, 163); // Posizione XY
        $pdf->Write(0, strtoupper($gio->luogo_nascita));
        $pdf->SetXY(135, 163); // Posizione XY
        $pdf->Write(0, Carbon::parse($gio->data_nascita)->format('d/m/Y'));
        $pdf->SetXY(40, 172); // Posizione XY
        $pdf->Write(0, strtoupper($gio->comune));
        $pdf->SetXY(125, 172); // Posizione XY
        $pdf->Write(0, strtoupper($gio->provincia));
        $pdf->SetXY(165, 172); // Posizione XY
        $pdf->Write(0, strtoupper($gio->cap));
        $pdf->SetXY(45, 181); // Posizione XY
        $pdf->Write(0, strtoupper($gio->indirizzo));
        $pdf->SetXY(30, 190); // Posizione XY
        $pdf->Write(0, strtoupper($gio->telefono));
        $pdf->SetXY(105, 190); // Posizione XY
        $pdf->Write(0, strtolower($gio->email));
        $pdf->SetXY(55, 199); // Posizione XY
        $pdf->Write(0, strtoupper($gio->codice_fiscale));
        $pdf->SetXY(107, 217); // Posizione XY
        $pdf->Write(0, "X");

        $pdf->SetXY(20, 268); // Posizione XY
        $pdf->Write(0, "ANCONA, ".Carbon::now()->format('d/m/Y'));


        // Salva il nuovo PDF
        $pdf->Output('F', $outputFile);

        return response()->json(['url' => url('results/modulo_iscrizione.pdf'), 'name'=>'modulo_iscrizione.pdf']);
    }
}
