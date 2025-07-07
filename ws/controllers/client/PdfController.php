<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../vendor/fpdf186/fpdf.php';  // Inclure FPDF

class PdfController
{
    public static function exportPretPdf()
    {
        $id = Flight::request()->data->id;
        if (!$id) {
            Flight::redirect('/pret');
            return;
        }

        $pret = Pret::getById($id);
        if (!$pret) {
            Flight::halt(404, 'Prêt non trouvé.');
        }

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode("Détails du prêt #{$pret['id']}"), 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);

        function addLine($pdf, $label, $value) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(50, 10, utf8_decode($label) . ": ", 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->MultiCell(0, 10, utf8_decode($value));
        }

        addLine($pdf, 'Utilisateur', $pret['id_user']);
        addLine($pdf, 'Montant', $pret['valeur'] . " €");
        addLine($pdf, 'Date début', $pret['dateDebut']);
        addLine($pdf, 'Durée', $pret['duree'] . " mois");
        addLine($pdf, 'Délai', $pret['delai']);
        addLine($pdf, 'Type de prêt', $pret['id_typePret']);
        addLine($pdf, 'Commentaire', $pret['commentaire']);
        addLine($pdf, 'Statut', $pret['id_statut']);

        $pdf->Output("I", "pret_{$pret['id']}.pdf");
        exit;
    }
}
