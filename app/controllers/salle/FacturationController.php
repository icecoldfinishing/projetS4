<?php
namespace app\controllers\salle;

use app\fpdf\FPDF;
use app\models\salle\FactureModel;
use app\models\salle\SuiviSalleModel;
use app\models\salle\MaterielItemModel;
use app\models\salle\MaterielTypeModel;
use DateTime;
use Flight;
use PDO;


class FacturationController {
    public function getDb() {
        return Flight::db();
    }

    public function __construct() {

    }

    public function create($id_suivi) {
        $factureModel = new FactureModel($this->getDb());
        $suiviModel = new SuiviSalleModel($this->getDb());
        $itemModel = new MaterielItemModel($this->getDb());
        $typeModel = new MaterielTypeModel($this->getDb());

        $suivi = $suiviModel->find($id_suivi);
        $item = $itemModel->find($suivi['id_item']);
        $type = $typeModel->find($item['id_type']);

        if ($suivi['id_club']) {
            $stmt = $this->getDb()->prepare("SELECT nom_responsable FROM club_groupe WHERE id = :id");
            $stmt->execute([':id' => $suivi['id_club']]);
            $destinataire = $stmt->fetchColumn();
        } else {
            $stmt = $this->getDb()->prepare("SELECT nom, prenom FROM superviseur WHERE id_superviseur = :id");
            $stmt->execute([':id' => $suivi['id_superviseur']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $destinataire = $row['nom'] . ' ' . $row['prenom'];
        }

        $dateAffectation = new DateTime($suivi['date']);
        $now = new DateTime();
        $interval = $dateAffectation->diff($now);

        if ($interval->y < 1) {
            $montant = $type['prix'] * 0.5;
        } else {
            $montant = $type['prix'];
        }


        Flight::render('gestion/salle/facturation/create', [
            'suivi' => $suivi,
            'item' => $item,
            'type' => $type,
            'destinataire' => $destinataire,
            'montant' => $montant
        ]);
    }

    public function store() {
        $data = Flight::request()->data->getData();

        $factureModel = new FactureModel($this->getDb());
        $factureModel->create([
            'id_suivi_salle' => $data['id_suivi_salle'],
            'montant' => $data['montant'],
            'destinataire' => $data['destinataire']
        ]);

        Flight::redirect('/suivi-salle');
    }
    public function generatePdf($id_suivi) {

        $factureModel = new FactureModel($this->getDb());
        $suiviModel = new SuiviSalleModel($this->getDb());
        $itemModel = new MaterielItemModel($this->getDb());
        $typeModel = new MaterielTypeModel($this->getDb());

        $suivi = $suiviModel->find($id_suivi);
        $item = $itemModel->find($suivi['id_item']);
        $type = $typeModel->find($item['id_type']);
        $facture = $factureModel->findBySuivi($id_suivi);

        if (!$facture) {
            Flight::halt(404, "Facture introuvable.");
        }

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);

        $pdf->Cell(0,10,'Facture de matériel endommagé',0,1,'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,'Date :',0,0);
        $pdf->Cell(0,10,date('d/m/Y', strtotime($facture['date'])),0,1);

        $pdf->Cell(50,10,'Destinataire :',0,0);
        $pdf->Cell(0,10,$facture['destinataire'],0,1);

        $pdf->Ln(10);
        $pdf->Cell(50,10,'Matériel :',0,0);
        $pdf->Cell(0,10,$item['num_serie'] . ' - ' . $type['label'],0,1);

        $pdf->Cell(50,10,'Description :',0,0);
        $pdf->MultiCell(0,10,$suivi['description']);

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(50,10,'Montant à payer :',0,0);
        $pdf->Cell(0,10,number_format($facture['montant'], 2, ',', ' ') . ' Ar',0,1);

        $pdf->Output('I', 'facture_'.$facture['id_facture'].'.pdf');
    }
    public function liste() {
        $factureModel = new FactureModel($this->getDb());
        $factures = $factureModel->getAll();
        Flight::render('gestion/salle/facturation/liste', ['factures' => $factures]);
    }
    public function valider($id_facture) {
        $factureModel = new FactureModel($this->getDb());
        $factureModel->validerPaiement($id_facture);
        Flight::redirect('/facturation/liste');
    }

}
