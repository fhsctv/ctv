<?php

namespace Legacyctv\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Futhuer\Legacy\AktuelleAnzeigen;

class IndexController extends AbstractActionController {

    const SHOWTIME = 20;

    public function indexAction() {


//        $aktAnz = new AktuelleAnzeigen($_GET['Positions_ID']);
//        $aktAnz->createService($this->getServiceLocator());
//
//
//        $aktAnz->AktuelleAnzeigenErmitteln();
//        $aktAnz->aktuelleAnzeigenInFeld();
//        var_dump($aktAnz->aktAnzeigen);
    }

    public function showAction(){
        return \Futhuer\Layout::disableLayout(new ViewModel());
    }

    public function intervallAction() {

        return \Futhuer\Layout::disableLayout(new ViewModel(array('intervall' => self::SHOWTIME)));
    }


    /**
     * @deprecated
     */
    /*
    public function deprecatedZeitzonenErmittelnAction(){

        $host = "212.201.65.202";
        $benutzername = "jobapp3";
        $passwort = "jobapp3";
        $datenbank = "fut1";

        isset($_POST['Positions_ID']) ? :  ($_POST['Positions_ID'] = $_GET['Positions_ID']);                    //#Migration Testing with _GET[] - Parameters

        if (!$conn = ocilogon($benutzername, $passwort, $host . "/" . $datenbank)) {
            echo "Verbindung fehlgeschlagen";
        }
        else {
            $sql = "SELECT Zeitzonen.Von AS VON
                    FROM Zeitzonen
                    INNER JOIN Position ON Zeitzonen.Standort_ID=Position.Standort_ID
                    INNER JOIN Standort ON Position.Standort_ID=Standort.ID
                        AND Position.ID=" . $_POST['Positions_ID'] . "
                    ORDER BY Von ASC";

//            echo $sql;

            if (!$result = ociparse($conn, $sql)) {
                echo "Error in parse. Error was :", ora_error($curs);
            }
            else {
                ociexecute($result);

                while (ocifetch($result)) {
                    echo ociresult($result, "VON") . ";";
                }
            }

            ocilogoff($conn);
        }

    }
     */

    public function zeitzonenErmittelnAction() {

        isset($_POST['Positions_ID']) ? :  ($_POST['Positions_ID'] = $_GET['Positions_ID']);                    //#Migration Testing with _GET[] - Parameters

        $zeitzoneTable = $this->getServiceLocator()->get('Legacyctv\Model\Table\Zeitzone');
        $resultSet = $zeitzoneTable->fetchAllByDisplay($_POST['Positions_ID']);



        return \Futhuer\Layout::disableLayout(new ViewModel(array('zeitzonen' => $resultSet->toArray())));
    }

    public function aktuelleAnzeigenFuellenAction(){

        isset($_POST['Positions_ID']) ? :  ($_POST['Positions_ID'] = $_GET['Positions_ID']);                    //#Migration Testing with _GET[] - Parameters

        $aktuelleAnzeigen = new AktuelleAnzeigen($_POST['Positions_ID']);
        $aktuelleAnzeigen->createService($this->getServiceLocator());

        //Tabelle Aktuelle_Anzeigen bereinigen
//        $aktuelleAnzeigen->delete();
        $aktAnzTable = $this->getServiceLocator()->get('Legacyctv\Model\Table\AktAnzeige');
        $aktAnzTable->deleteByDisplay($_POST['Positions_ID']);


        //aktuelle Zeitzone ermitteln
        // $aktuelleAnzeigen->aktuelleZeitzoneErmitteln();

        //aktuelle Anzeigen ermitteln
        $aktuelleAnzeigen->aktuelleAnzeigenErmitteln();

        //aktuelle Anzeigen in Feld schreiben
        $aktuelleAnzeigen->aktuelleAnzeigenInFeld();

	//Nachrichten Portale ermitteln
	$aktuelleAnzeigen->aktuelleInfoscripteErmitteln();

	//News einfügen
	$aktuelleAnzeigen->aktuelleInfoscripteInFeld();

	//Anzeigen Sortieren
	$aktuelleAnzeigen->AnzeigenSortieren();

	//aktuelle Anzeigen in Datenbank schreiben
	$aktuelleAnzeigen->insert();

	//Mail für Testzwecke verschicken
	//$aktuelleAnzeigen->TestMail();

        return \Futhuer\Layout::disableLayout(new ViewModel());

    }

    public function aktuelleAnzeigenBereinigenAction(){

        isset($_POST['Positions_ID']) ? :  ($_POST['Positions_ID'] = $_GET['Positions_ID']);                    //#Migration Testing with _GET[] - Parameters

        $aktAnzTable = $this->getServiceLocator()->get('Legacyctv\Model\Table\AktAnzeige');
        $aktAnzTable->deleteByDisplay($_POST['Positions_ID']);


//        $aktuelleAnzeigen = new AktuelleAnzeigen($_POST['Positions_ID']);
        //Tabelle Aktuelle_Anzeigen bereinigen
//        $aktuelleAnzeigen->delete();

        return \Futhuer\Layout::disableLayout(new ViewModel());
    }

    public function aktuelleAnzeigeErmittelnAction(){

        if(!isset($_POST['Positions_ID']))           $_POST['Positions_ID'] = $_GET['Positions_ID'];                    //#Migration Testing with _GET[] - Parameters legacyctv/index/aktuelle-anzeige-ermitteln?Positions_ID=1&Anzahl_Wiederholungen=8
        if(!isset($_POST['Anzahl_Wiederholungen']))  $_POST['Anzahl_Wiederholungen'] = $_GET['Anzahl_Wiederholungen'];  //#Migration Testing with _GET[] - Parameters

        $aktuelleAnzeigen = new AktuelleAnzeigen($_POST['Positions_ID']);

        echo $aktuelleAnzeigen->aktuelleAnzeigeErmitteln($_POST["Anzahl_Wiederholungen"]);

        return \Futhuer\Layout::disableLayout(new ViewModel());
    }
}