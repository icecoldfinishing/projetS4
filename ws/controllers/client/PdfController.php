<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/other/User.php';
require_once __DIR__ . '/../../models/etablissement/typePret.php';
require_once __DIR__ . '/../../vendor/fpdf186/fpdf.php';


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
        
        // Récupération du nom du type de prêt
        $nomTypePret = TypePret::getNomById($pret['id_typePret']) ?? 'Type inconnu';
        
        // Gestion affichage statut avec couleurs
        $statutInfo = self::getStatutInfo($pret['id_statut']);
        
        // Création du PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // En-tête avec logo/bannière
        self::addHeader($pdf);
        
        // Titre principal
        self::addTitle($pdf, $pret['id']);
        
        // Informations du prêt dans un tableau élégant
        self::addPretDetails($pdf, $pret, $nomTypePret, $statutInfo);
        
        // Pied de page
        self::addFooter($pdf);
        
        // Génération du PDF
        $pdf->Output("I", "pret_bancaire_{$pret['id']}_" . date('Y-m-d') . ".pdf");
        exit;
    }
    
    private static function addHeader($pdf)
    {
        // Bannière colorée en haut
        $pdf->SetFillColor(46, 125, 50); // Vert professionnel
        $pdf->Rect(0, 0, 210, 25, 'F');
        
        // Logo/Nom de l'établissement
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetXY(15, 8);
        $pdf->Cell(0, 10, utf8_decode('BANQUE OF AFRICA'), 0, 1, 'L');
        
        // Sous-titre
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(15, 16);
        $pdf->Cell(0, 5, utf8_decode('Établissement financier de confiance'), 0, 1, 'L');
        
        // Date de génération
        $pdf->SetXY(150, 8);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode('Généré le: ' . date('d/m/Y à H:i')), 0, 1, 'L');
        
        // Reset couleur texte
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(20);
    }
    
    private static function addTitle($pdf, $pretId)
    {
        // Titre principal avec bordure
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(0, 15, utf8_decode("DÉTAIL DU PRÊT N° {$pretId}"), 0, 1, 'C');
        
        // Ligne de séparation
        $pdf->SetDrawColor(46, 125, 50);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(15);
    }
    
    private static function addPretDetails($pdf, $pret, $nomTypePret, $statutInfo)
    {
        
        $nomUtilisateur = User::getNom($pret['id_user']);
        $assurance = Pret::getAssuranceTexte($pret['assurance']);
        $valeur = TypePret::getAssuranceById($pret['assurance']);
        // Titre section
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 10, utf8_decode('INFORMATIONS GÉNÉRALES'), 0, 1, 'L');
        $pdf->Ln(5);
        
        // Formatage des données d'assurance
        $assuranceTexte = !empty($pret['assurance']) ? $pret['assurance'] : 'Non souscrite';
        $valeurAssuranceTexte = !empty($pret['valeurAssurance']) ? 
            number_format($pret['valeurAssurance'], 2, ',', ' ') . ' Ariary' : 'N/A';
        
        // Tableau des informations
        $details = [
            ['Référence du prêt', $pret['id']],
            ['Utilisateur', $nomUtilisateur],
            ['Montant demandé', number_format($pret['valeur'], 2, ',', ' ') . ' Ariary'],
            ['Date de début', self::formatDate($pret['dateDebut'])],
            ['Durée du prêt', $pret['duree'] . ' mois'],
            ['Délai de remboursement', $pret['delai']],
            ['Type de prêt', $nomTypePret],
            ['Assurance', $assurance],
            ['Statut', $statutInfo['texte']]
        ];
        
        $pdf->SetFont('Arial', '', 11);
        $y = $pdf->GetY();
        
        foreach ($details as $index => $detail) {
            // Alternance des couleurs de fond
            if ($index % 2 == 0) {
                $pdf->SetFillColor(248, 249, 250);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            
            // Ligne du tableau
            $pdf->SetX(20);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(60, 10, utf8_decode($detail[0]), 1, 0, 'L', true);
            
            $pdf->SetFont('Arial', '', 11);
            // Couleur spéciale pour le statut
            if ($detail[0] === 'Statut') {
                $pdf->SetTextColor($statutInfo['couleur'][0], $statutInfo['couleur'][1], $statutInfo['couleur'][2]);
            }
            // Couleur spéciale pour l'assurance
            if ($detail[0] === 'Assurance' && $detail[1] !== 'Non souscrite') {
                $pdf->SetTextColor(0, 128, 0); // Vert pour assurance active
            }
            $pdf->Cell(110, 10, utf8_decode($detail[1]), 1, 1, 'L', true);
            $pdf->SetTextColor(0, 0, 0);
        }
        
        // Section commentaires si présent
        if (!empty($pret['commentaire'])) {
            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(52, 73, 94);
            $pdf->Cell(0, 10, utf8_decode('COMMENTAIRES'), 0, 1, 'L');
            $pdf->Ln(3);
            
            // Calcul de la hauteur disponible pour éviter le débordement
            $currentY = $pdf->GetY();
            $maxY = 250; // Limite avant le footer
            $availableHeight = $maxY - $currentY;
            
            // Boîte pour les commentaires (hauteur adaptée)
            $commentHeight = min(25, $availableHeight - 10);
            $pdf->SetFillColor(248, 249, 250);
            $pdf->SetDrawColor(200, 200, 200);
            $pdf->Rect(20, $pdf->GetY(), 170, $commentHeight, 'DF');
            
            $pdf->SetXY(25, $pdf->GetY() + 3);
            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(160, 4, utf8_decode($pret['commentaire']));
        }
        
        // Section récapitulatif financier
        self::addFinancialSummary($pdf, $pret);
    }
    
    private static function addFinancialSummary($pdf, $pret)
    {
        // Positionnement pour le récapitulatif
        $pdf->Ln(12);
        
        // Titre section
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(52, 73, 94);
        $pdf->Cell(0, 20, utf8_decode('RÉCAPITULATIF FINANCIER'), 0, 1, 'L');
        $pdf->Ln(5);
        
        $valeur = TypePret::getAssuranceById($pret['assurance']);
        // Calculs
        $montantPret = floatval($pret['valeur']);
        $valeurAssurance = floatval($valeur ?? 0);
        $montantTotal = $montantPret+ ($montantPret * $valeurAssurance)/100;
        
        // Boîte récapitulatif
        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Rect(20, $pdf->GetY()-8, 170, 35, 'DF');
        
        $pdf->SetXY(25, $pdf->GetY() + 3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Cell(80, 5, utf8_decode('Montant du prêt:'), 0, 0, 'L');
        $pdf->Cell(80, 5, number_format($montantPret, 2, ',', ' ') . ' Ariary', 0, 1, 'R');
        
        $pdf->SetX(25);
        $pdf->Cell(80, 5, utf8_decode('Valeur assurance:'), 0, 0, 'L');
        $pdf->Cell(80, 5, number_format($valeurAssurance, 2, ',', ' ') . ' %', 0, 1, 'R');
        
        // Ligne de séparation
        $pdf->SetDrawColor(100, 100, 100);
        $pdf->Line(25, $pdf->GetY() + 2, 185, $pdf->GetY() + 2);
        
        $pdf->SetXY(25, $pdf->GetY() + 5);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(46, 125, 50);
        $pdf->Cell(80, 8, utf8_decode('TOTAL:'), 0, 0, 'L');
        $pdf->Cell(80, 8, number_format($montantTotal, 2, ',', ' ') . ' Ariary', 0, 1, 'R');
    }
    
    private static function addFooter($pdf)
    {
        // Positionnement en bas de page (descendu de 100px)
        $pdf->SetY(-40);
        
        // Ligne de séparation
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->Line(20, $pdf->GetY()+8, 190, $pdf->GetY()+8);
        $pdf->Ln(5);
        
        // Informations de contact
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->SetTextColor(128, 128, 128);
        $pdf->Cell(0, 12, utf8_decode('Banque of Africa - 123 Rue de la Finance, Antaninarenina'), 0, 1, 'C');
        
        // Numéro de page
    }
    
    private static function getStatutInfo($idStatut)
    {
        switch ($idStatut) {
            case 1:
                return [
                    'texte' => 'En attente',
                    'couleur' => [255, 152, 0] // Orange
                ];
            case 2:
                return [
                    'texte' => 'Accepté',
                    'couleur' => [76, 175, 80] // Vert
                ];
            case 3:
                return [
                    'texte' => 'Refusé',
                    'couleur' => [244, 67, 54] // Rouge
                ];
            default:
                return [
                    'texte' => 'Statut inconnu',
                    'couleur' => [128, 128, 128] // Gris
                ];
        }
    }
    
    private static function formatDate($date)
    {
        if (empty($date)) return 'Non spécifiée';
        
        try {
            $dateObj = new DateTime($date);
            return $dateObj->format('d/m/Y');
        } catch (Exception $e) {
            return $date;
        }
    }
}