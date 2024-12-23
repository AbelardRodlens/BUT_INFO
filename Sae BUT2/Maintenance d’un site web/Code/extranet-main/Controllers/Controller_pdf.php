<?php
    // Inclure la classe FPDF
    require_once __DIR__ . '/../Utils/librairies/vendor/autoload.php';

    use setasign\Fpdi\Fpdi;
    use setasign\Fpdi\PdfReader;

class Controller_pdf extends Controller
{
    /**
     * @inheritDoc
     */
    public function action_default()
    {
    
        $this->action_generatePdf();
       
    }

    public function action_generatePdf(){
    
        $bd = Model::getModel();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if($_GET['id']){

            //Affectation
            $infos_bdl=$bd->getInfoBdl($_GET['id']);
            $prestataire=$bd->getBdlPrestataire($_GET['id']);
            $infos_client=$bd->getBdlClientInfos($_GET['id']);


            //infos bdl
            $id_bdl=$_GET['id'];
            $date=$infos_bdl['mois']." ".$infos_bdl['annee'];
            $commentaire=$infos_bdl['commentaire'];

            if(isset($commentaire)){$commentaire=mb_convert_encoding($commentaire,'ISO-8859-1','UTF-8');};  //convertie l'encodage de la chaine si elle n'est pas vide.
            
            //infos prestataire
            $nom_prestataire=$prestataire['nom'];
            $prenom_prestataire=$prestataire['prenom'];
            $email_prestataire=$prestataire['email'];
            $signature_prestataire=$infos_bdl['signatureprestataire'];

            //interlocuteur
            $id_interlocuteur='';
            $nom_interlocuteur='';
            $signature_interlocuteur=$infos_bdl['signatureinterlocuteur'];


            // infos client
            $id_client=$infos_client['id_client'];
            $nom_client=$infos_client['nom_client'];
            $telephone_client=$infos_client['telephone_client'];
            $dest_adresse=$infos_client['numero'].','.''.$infos_client['libelle'].''.$infos_client['nomvoie'];
            $cp=$infos_client['cp'];
            // Chemin du fichier PDF 
            $chemin_pdf = __DIR__ .'/../Content/pdf/Bdl_template.pdf';

            // Créer une nouvelle instance de FPDI
            $new_pdf = new \setasign\Fpdi\Fpdi();
            $new_pdf->AddPage();

            // Charger le fichier PDF source
            $new_pdf->setSourceFile($chemin_pdf);

            // Importer la première page du PDF existant
            $page_pdf = $new_pdf->importPage(1);  // Récupère la référence de la page
            $new_pdf->useTemplate($page_pdf, 0, 0, 210);  // Utilise le modèle de la page importée

            // Ajouter du texte par-dessus le contenu existant
            $new_pdf->AddFont('Roboto', 'R', 'Roboto-Regular.php');
            $new_pdf->SetFont('Roboto', 'R', 11);

            // Info bdl gauche
            $new_pdf->SetXY(71, 92);
            $new_pdf->Cell(0, 10, $id_bdl, 0, 1, 'L');

            $new_pdf->SetXY(71, 98);
            $new_pdf->Cell(0, 10, $date, 0, 1, 'L');

            $new_pdf->SetXY(71, 110);
            $new_pdf->Cell(0, 10, $id_client, 0, 1, 'L');

            $new_pdf->SetXY(71, 116);
            $new_pdf->Cell(0, 10, $id_interlocuteur, 0, 1, 'L');

            $new_pdf->SetXY(71, 122);
            $new_pdf->Cell(0, 10, $nom_prestataire.' '.$prenom_prestataire, 0, 1, 'L');

            // Destinataire
            $new_pdf->AddFont('SourceSerifPro-SemiBoldIt', '', 'source-serif-pro-semi-bold-italic.php');
            $new_pdf->SetFont('SourceSerifPro-SemiBoldIt', '', 10);
            $new_pdf->SetTextColor(70, 70, 70);
            
            $new_pdf->SetXY(153.3, 89);
            $new_pdf->Cell(0, 10, $nom_client, 0, 1, 'L');

            $new_pdf->SetXY(153.3, 93.5);
            $new_pdf->Cell(0, 10,  $cp, 0, 1, 'L');

            $new_pdf->SetXY(153.3, 98);
            $new_pdf->Cell(0, 10, 'France', 0, 1, 'L');

            $new_pdf->SetXY(153.3, 102.5);
            $new_pdf->Cell(0, 10, $telephone_client, 0, 1, 'L');

            // Commentaire
            
            $new_pdf->AddFont('Roboto', 'R', 'Roboto-Regular.php');
            $new_pdf->SetFont('Roboto', 'R', 11);
            $new_pdf->SetTextColor(0, 0, 0);

            $new_pdf->SetXY(18.1, 190);
            $new_pdf->MultiCell(0, 6,$commentaire, 0, 'L');


            //Signature

            $new_pdf->SetXY(14, 235);
            $new_pdf->Cell(0, 10, $signature_interlocuteur, 0, 1, 'L');

            $new_pdf->SetXY(150, 235);
            $new_pdf->Cell(0, 10, $signature_prestataire, 0, 1, 'L');

            // Coordonnées
            $new_pdf->SetFont('Roboto', 'R', 9);

            $new_pdf->SetXY(95.5, 264.8);
            $new_pdf->Cell(0, 9, $nom_prestataire.' '.$prenom_prestataire, 0, 1, 'L');

            $new_pdf->SetXY(95.5, 274.5);
            $new_pdf->Cell(1, 1, $email_prestataire, 0, 1, 'L');


            // Sauvegarder le PDF modifié et le télécharger
            $new_pdf->Output('I', 'modified.pdf');

        } else { echo 'error';}



    }

}