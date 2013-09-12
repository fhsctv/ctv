<?php


namespace Futhuer\Legacy;  //für Migration hinzugefügt


//include_once('../config/DBConnect.php'); //nicht benötigt wegen Namespace

class AktuelleAnzeigen implements \Zend\ServiceManager\FactoryInterface {

    //#REFACTORING
    /**
     * 1h = 60 min = 60 x 60 sec = 3600 sec
     */
    const ONE_HOUR_IN_SECONDS = 3600;

    /**
     *
     */
    const INTERVAL = 20;

    /**
     *
     * @var int
     */
    const TYPE_ANZEIGE    = 0;
    const TYPE_INFOSCRIPT = 2;

    private $table_aktAnzeige;
    private $table_infoscripte;
    private $table_anzeigen;

    var $Positions_ID = 0;
    var $Zeitzone = 0;
    var $Anzeigen = array();
    var $Intervall = 20;
    var $aktAnzeigen = array();
    var $Infoscripte = array();
    var $AKT_ANZEIGE = "AKTUELLE_ANZEIGEN_NEW";

    /*
     * Get - Methode Positions_ID
     */

    public function getPositions_ID() {
        return $this->Positions_ID;
    }

    /**
     * Set - Methode Positions_ID
     */

    public function setPositions_ID($Positions_ID) {
        $this->Positions_ID = $Positions_ID;
    }

    /**
     * Get - Methode Zeitzone
     */

//    public function getZeitzone() {
//        return $this->Zeitzone;
//    }
    private function getZeitzone() {
        return $this->Zeitzone;
    }

    /**
     * Set - Methode Zeitzone
     */

    public function setZeitzone($Zeitzone) {
        $this->Zeitzone = $Zeitzone;
    }

    //this is the actual working constructor
    public function __construct($Positions_ID) {
        $this->Positions_ID = $Positions_ID;
    }

    /**
     * @deprecated not working as constructor in newer php versions
     */
    public function AktuelleAnzeigen($Positions_ID) {
        $this->Positions_ID = $Positions_ID;
    }

    /**
     * @deprecated
     * löscht alle Einträge
     * mit der entsprechenden Positions_ID
     * in der Tabelle AktuelleAnzeigen
     */
    /*
    public function delete() {
        $dbc = new DBConnect();
        $dbc->connect();

        $sql = "DELETE FROM " . $this->AKT_ANZEIGE . " WHERE Positions_ID=" . $this->Positions_ID;
        //echo $sql;

        $dbc->execute($sql);

        $dbc->close();
    }
    */

    /**
     * löscht alle Einträge
     * mit der entsprechenden Positions_ID
     * in der Tabelle AktuelleAnzeigen
     */
    public function delete() {

        return $this->tableAktAnzeige->deleteByDisplay($this->getPositions_ID());
    }

    /*
     * ermittelt die ID der aktuellen Zeitzone
     */
    /*
      public function aktuelleZeitzoneErmitteln()
      {
      $dbc = new DBConnect();
      $dbc->connect();

      $sql="Select Zeitzonen.ID AS ID From Zeitzonen INNER JOIN Position ON Zeitzonen.Standort_ID=Position.Standort_ID INNER JOIN Standort ON Position.Standort_ID=Standort.ID AND Position.ID=".$this->Positions_ID." AND VON=".date('G');
      //echo $sql;

      //Array für Ergebnisse
      $erg = array();

      //Ausführen der Abfrage
      $dbc->select($sql, $erg);

      $this->Zeitzone = $erg["ID"][0];

      $dbc->close();
      }
     */

    /**
     * @deprecated
     * ermittelt ID und Wahrscheinlichkeit der Anzeigen,
     * die aktuell angezeigt werden müssen
     */
    public function deprecatedAktuelleAnzeigenErmitteln() {
        $heute = date("Y-m-d");

        $dbc = new DBConnect();
        $dbc->connect();

        $sql = "SELECT ID, WAHRSCHEINLICHKEIT AS P FROM ANZEIGE_NEW WHERE Positions_ID=" . $this->Positions_ID .
               " AND Schaltungsanfang<=to_date('" . $heute . "','YYYY-MM-DD')" .
               " AND Schaltungsende>=to_date('" . $heute . "','YYYY-MM-DD')".
               " AND imWarenkorb=0";
        //echo $sql;
        //Array für Ergebnisse
        $erg = array();

        //Ausführen der Abfrage
        $dbc->select($sql, $erg);

        for ($i = 0; $i < count($erg["ID"]); $i++) {
            $this->Anzeigen[$i]["ID"] = $erg["ID"][$i];
            $this->Anzeigen[$i]["P"] = $erg["P"][$i];
        }

        $dbc->close();
    }

    /**
     * ermittelt ID und Wahrscheinlichkeit der Anzeigen,
     * die aktuell angezeigt werden müssen
     */
    public function AktuelleAnzeigenErmitteln(){

        $anzeigen = $this->table_anzeigen->fetchAllActive($this->Positions_ID);

        foreach ($anzeigen as $anzeige){
            array_push($this->Anzeigen, array("ID" => $anzeige->getId(), "P" => $anzeige->getWahrscheinlichkeit()));
        }

    }



    /**
     * @deprecated
     * schreibt die aktuellen Anzeigen in das Feld
     * aktAnzeigen, wo sie später sortiert werden
     */
    public function deprecatedAktuelleAnzeigenInFeld() {
        $maxAnzWied = 3600 / $this->Intervall;

        $el = 0;

        for ($i = 0; $i < count($this->Anzeigen); $i++) {
            $AnzWiedAnz = $maxAnzWied / 100 * $this->Anzeigen[$i]["P"];

            for ($b = 0; $b < $AnzWiedAnz; $b++) {
                $this->aktAnzeigen[$el]['Anzeige_ID'] = $this->Anzeigen[$i]['ID'];
                $this->aktAnzeigen[$el]['News_ID'] = "";
                $this->aktAnzeigen[$el]['Typ'] = 0;

                $el++;
            }
        }
    }

    /**
     * schreibt die aktuellen Anzeigen in das Feld
     * aktAnzeigen, wo sie später sortiert werden
     */
    public function aktuelleAnzeigenInFeld() {

        $replicate = function($anzeige){

            foreach ( range(0, $this->getWdh($anzeige)-1) as $i) {

                array_push($this->aktAnzeigen, array (
                        'Anzeige_ID' => $anzeige['ID'],
                        'News_ID'    => '',
                        'Typ'        => self::TYPE_ANZEIGE
                    )
                );

            }
        };

        array_walk($this->Anzeigen, $replicate);

    }


    /**
     * @deprecated
     * ermittelt die ID der Infoscripte,
     * die aktuell angezeigt werden müssen
     */
    public function deprecatedAktuelleInfoscripteErmitteln() {
        $heute = date("Y-m-d");

        $dbc = new DBConnect();
        $dbc->connect();

        $sql = "SELECT ID FROM Nachrichten_Portale WHERE Startdatum <= to_date('" . $heute . "','YYYY-MM-DD') AND Ablaufdatum >= to_date('" . $heute . "','YYYY-MM-DD')";
        //echo $sql;
        //Array für Ergebnisse
        $erg = array();

        $dbc->select($sql, $erg);

        for ($i = 0; $i < count($erg["ID"]); $i++)
            $this->Infoscripte[$i]["ID"] = $erg["ID"][$i];

        $dbc->close();
    }

    /**
     * ermittelt die ID der Infoscripte,
     * die aktuell angezeigt werden müssen
     */
    public function aktuelleInfoscripteErmitteln() {

        $infoscripte = $this->table_infoscripte->fetchAllActive();

        foreach ($infoscripte as $infoscript){
            array_push($this->Infoscripte, array("ID" => $infoscript->getId()));
        }

    }

    /**
     * schreibt die aktuellen Infoscripte in das Feld
     * aktAnzeigen, wo sie später sortiert werden
     */

    public function deprecatedAktuelleInfoscripteInFeld() {
        $maxAnzWied = 3600 / $this->Intervall;

        $is = 0;

        for ($i = count($this->aktAnzeigen); $i < $maxAnzWied; $i++) {
            $this->aktAnzeigen[$i]['Anzeige_ID'] = "";
            $this->aktAnzeigen[$i]['News_ID'] = $this->Infoscripte[$is]['ID'];
            $this->aktAnzeigen[$i]['Typ'] = 2;

            if ($is < (count($this->Infoscripte) - 1))
                $is++;
            else
                $is = 0;
        }
    }

    public function aktuelleInfoscripteInFeld() {

        /**
         * Returns Infoscript from array $this->Infoscripte at index $i.
         * If $i is bigger than the count of Infoscripts then index is set
         * again to the beginning.
         */
        $getInfoscript = function($i){
            return $this->Infoscripte[$i % count($this->Infoscripte)];
        };

        $emptySlots = function(){
            return range(count($this->aktAnzeigen), $this->getMaxWdh()-1);
        };


        /*
         * This fills the empty slide slots with infoscripts
         * If there are not enough infoscripts to fill all the slots then
         * the infoscripts are repeated from the beginning.
         */
        $is = 0;

        foreach($emptySlots() as $slot){
            $this->aktAnzeigen[$slot] = array(
                    'Anzeige_ID' => '',
                    'News_ID'    => $getInfoscript($is++)['ID'],
                    'Typ'        => self::TYPE_INFOSCRIPT
                );
        }

    }

    /**
     * sortiert das Feld aktAnzeigen
     */

    public function AnzeigenSortieren() {
        $maxAnzWied = 3600 / $this->Intervall;

        $gleichverteilt = 0;
        $z = 0;
        $durchlaeufe = 0;

        //Berechnung der Gleichverteilung
        while ($gleichverteilt == 0) {
            $z++;

            if ($z < (count($this->aktAnzeigen) - 1)) {
                $this->check($z, $this->aktAnzeigen, $maxAnzWied);
            }
            else
                $z = 0;

            $durchlaeufe++;

            // wie oft das oben durchlaufen wird, um ein gute Gleichverteilung zu erhalten
            if ($durchlaeufe == (50 * $maxAnzWied))
                $gleichverteilt = 1;
        }
    }

    /**
     * Überprüft ob Vorgänger oder Nachfolger vom selben Typ und Inhalt sind
     * wenn ja, wird 1 zurück gegeben, ansonsten 0
     */

    private function match($z, $zufall, $typ, $typv, $typn, &$AktAnzeigen) {

        $gleich = 1;
        $IDText = "";

        //wenn vom Typ Anzeige
        if ($typ == 0)
            $IDText = "Anzeige_ID";
        else if ($typ == 1)
            $IDText = "SchwBrAnzeige_ID";
        else if ($typ == 2)
            $IDText = "News_ID";

        $gleichvor = 0;
        $gleichnach = 0;

        //wenn gleich dem Vorgänger
        if ($typ == $typv) {
            if ($AktAnzeigen[$z][$IDText] == $AktAnzeigen[($zufall - 1)][$IDText])
                $gleichvor = 1;
        }

        //wenn gleich dem Nachfolger
        if ($typ == $typn) {
            if ($AktAnzeigen[$z][$IDText] == $AktAnzeigen[($zufall + 1)][$IDText])
                $gleichnach = 1;
        }

        if ($gleichvor || $gleichnach)
            $gleich = 1;
        else
            $gleich = 0;



        return $gleich;
    }

    /**
     * sortiert einen Datensatz und würfelt solange bis er an der richtigen Stelle ist
     */

    private function check($z, &$AktAnzeigen, $maxAnzWied) {
        $zufall = $z;

        $gleich = 1;

        //solange vorheriges oder nachfolgendes Element mit gleichem Inhalt
        while ($gleich == 1) {
            ///////////////////
            //Typen ermitteln//
            ///////////////////

            $typ = $AktAnzeigen[$z]["Typ"]; //echo "typ: ".$typ;

            $typv = $AktAnzeigen[$zufall - 1]["Typ"]; //echo " typv: ".$typv;

            $typn = $AktAnzeigen[$zufall + 1]["Typ"]; //echo " typn: ".$typn."\n";
            /////////////
            //Sortieren//
            /////////////

            if (($typ == $typv) || ($typ == $typn)) {
                //echo "typv: ".$typv." ,typ: ".$typ." ,typn: ".$typn."\n";
                //Überprüft ob Vorgänger oder Nachfolger vom selben Typ und Inhalt sind
                //wenn ja, wird 1 zurück gegeben, ansonsten 0

                $gleich = $this->match($z, $zufall, $typ, $typv, $typn, $AktAnzeigen);

                if ($gleich == 1) {
                    //srand wird der Startwert festgelegt und dieser bekommt den Wert der Mikrotime (microtime()) mal eine Million (hat ebenfalls den Grund, dass dadurch die Zufallswerte verbessert werden
                    srand(microtime() * 1000000);
                    //es wird Zufallszahl ermittelt zwischen 0 und 359
                    $zufall = rand(1, $maxAnzWied - 2);
                }
                else {
                    //Vertauschen der Elemente
                    $t = $AktAnzeigen[$z];
                    $AktAnzeigen[$z] = $AktAnzeigen[$zufall];
                    $AktAnzeigen[$zufall] = $t;
                }
            }
            else {
                $gleich = 0;

                //Vertauschen der Elemente
                $t = $AktAnzeigen[$z];
                $AktAnzeigen[$z] = $AktAnzeigen[$zufall];
                $AktAnzeigen[$zufall] = $t;
            }
        }
    }

    /**
     * fügt das Feld aktAnzeigen
     * in die Tabelle aktuelle_Anzeigen ein
     */

    public function insert() {
        $dbc = new DBConnect();
        $dbc->connect();

        for ($i = 0; $i < count($this->aktAnzeigen); $i++) {
            $sql = "";

            if ($this->aktAnzeigen[$i]["Anzeige_ID"] != "")
                $sql = "INSERT INTO " . $this->AKT_ANZEIGE . "(Positions_ID, Anzahl_Wiederholungen, Anzeige_ID) values (" . $_POST['Positions_ID'] . "," . ($i + 1) . "," . $this->aktAnzeigen[$i]["Anzeige_ID"] . ")";
            else if ($this->aktAnzeigen[$i]["News_ID"] != "")
                $sql = "INSERT INTO " . $this->AKT_ANZEIGE . "(Positions_ID, Anzahl_Wiederholungen, News_ID) values (" . $_POST['Positions_ID'] . "," . ($i + 1) . "," . $this->aktAnzeigen[$i]["News_ID"] . ")";

            //echo $sql;

            $dbc->execute($sql);
        }

        $dbc->close();
    }

    /**
     * E-Mail für Testzwecke
     */

    public function TestMail() {
        $dbc = new DBConnect();
        $dbc->connect();

        //Abfragestring
        $sql = "SELECT " . $this->AKT_ANZEIGE . ".ID AS ID, " . $this->AKT_ANZEIGE . ".Anzahl_Wiederholungen AS Anzahl_Wiederholungen, " . $this->AKT_ANZEIGE . ".Anzeige_ID AS Anzeige_ID, " . $this->AKT_ANZEIGE . ".News_ID AS News_ID, Position.Bezeichnung AS PBezeichnung, Standort.Bezeichnung AS SBezeichnung, Organisation.Bezeichnung AS OBezeichnung FROM " . $this->AKT_ANZEIGE . " INNER JOIN Position ON " . $this->AKT_ANZEIGE . ".POSITIONS_ID = " . $this->Positions_ID . " AND " . $this->AKT_ANZEIGE . ".Positions_ID = Position.ID INNER JOIN Standort ON Position.Standort_ID = Standort.ID INNER JOIN Organisation ON Standort.Organisations_ID = Organisation.ID ORDER BY " . $this->AKT_ANZEIGE . ".Anzahl_Wiederholungen ASC";
        //echo $sql;
        //Array für Ergebnisse
        $erg = array();

        //Ausführen der Abfrage
        $dbc->select($sql, $erg);

        //HTML - Seite generieren
        $Text = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
        $Text .= "<html>";
        $Text .= "<head>";
        $Text .= "<title>Update Aktuelle_Anzeigen</title>";
        $Text .= "<style type='text/css'>";
        $Text .= "table{ border-collapse:collapse; border: 2px solid #000000;}";
        $Text .= "th{ padding: 5px; text-align:center; border: 2px solid #000000;}";
        $Text .= "td{ text-align:center; border: 2px solid #000000;}";
        $Text .= "</style>";
        $Text .= "</head>";
        $Text .= "<body>";
        $Text .= "<table><thead><th>ID</th><th>Positions_ID</th><th>Anzahl_Wiederholungen</th><th>Anzeige_ID</th><th>News_ID</th></thead><tbody>";

        for ($i = 0; $i < count($erg["ID"]); $i++) {
            $Text .= "<tr>\n";
            $Text .= "<td>" . $erg["ID"][$i] . "</td>\n";
            $Text .= "<td>" . $erg["OBEZEICHNUNG"][$i] . "->" . $erg["SBEZEICHNUNG"][$i] . "->" . $erg["PBEZEICHNUNG"][$i] . "</td>\n";
            $Text .= "<td>" . $erg["ANZAHL_WIEDERHOLUNGEN"][$i] . "</td>\n";
            $Text .= "<td>" . $erg["ANZEIGE_ID"][$i] . "</td>\n";
            $Text .= "<td>" . $erg["NEWS_ID"][$i] . "</td>\n";
            $Text .= "</tr>\n";
        }

        $Text .= "</tbody>";
        $Text .= "</table>";
        $Text .= "</body>";
        $Text .= "</html>";

        //automatische Mail
        $Betreff = "Update Aktuelle_Anzeigen " . date("j.n.Y G:i:s");

        $headers = "MIME-Version: 1.0rn";
        $headers .= "Content-type: text/html; charset=UTF-8";

        mail('uwe_eckhardt@freenet.de', $Betreff, $Text, $headers);

        //Verbindung abbauen
        $dbc->close();
    }

    /**
     * ermittelt die Anzeige welche als nächstes
     * angezeigt werden muss
     */

    public function aktuelleAnzeigeErmitteln($AnzahlWiederholungen) {
        $Typ = $this->aktuelleAnzeigeTypErmitteln($AnzahlWiederholungen);

        $dbc = new DBConnect();
        $dbc->connect();

        //Array für Ergebnisse
        $erg = array();

        $rueckgabe = 0;

        //Anzeige
        if ($Typ == 1) {
            $sql = "SELECT URL.URL AS URL, URL.ID AS ID FROM " . $this->AKT_ANZEIGE . " INNER JOIN ANZEIGE_NEW ON " . $this->AKT_ANZEIGE . ".Anzahl_Wiederholungen = " . $_POST["Anzahl_Wiederholungen"] . " AND " . $this->AKT_ANZEIGE . ".Positions_ID = " . $_POST["Positions_ID"] . " AND " . $this->AKT_ANZEIGE . ".Anzeige_ID = Anzeige_NEW.ID INNER JOIN URL ON Anzeige_NEW.Such_ID = URL.ID";
            //echo $sql;

            $dbc->select($sql, $erg);

            $rueckgabe = "Anzeige~";
            $rueckgabe .= $erg["URL"][0];
            $rueckgabe .= "," . $erg["ID"][0];
        }
        //News
        else if ($Typ == 2) {
            $sql = "SELECT Nachrichten_Portale.URL AS URL FROM " . $this->AKT_ANZEIGE . " INNER JOIN Nachrichten_Portale ON " . $this->AKT_ANZEIGE . ".Anzahl_Wiederholungen = " . $_POST["Anzahl_Wiederholungen"] . " AND " . $this->AKT_ANZEIGE . ".Positions_ID = " . $_POST['Positions_ID'] . " AND " . $this->AKT_ANZEIGE . ".News_ID = Nachrichten_Portale.ID";
            //echo $sql;

            $dbc->select($sql, $erg);

            $rueckgabe = "News~";
            $rueckgabe .= $erg["URL"][0];
        }

        $dbc->close();

        return $rueckgabe;
    }

    /**
     * ermittelt den Typ der aktuellen Anzeige
     */

    private function aktuelleAnzeigeTypErmitteln($AnzahlWiederholungen) {
        $dbc = new DBConnect();
        $dbc->connect();

        //<------- wenn Anzeige ---------------->

        $sql = "SELECT count(*) AS ANZAHL FROM " . $this->AKT_ANZEIGE . " WHERE Anzahl_Wiederholungen = " . $AnzahlWiederholungen . " AND Positions_ID = " . $this->Positions_ID . " and Anzeige_ID IS NOT NULL";
        //echo $sql;
        //Array für Ergebnisse
        $erg = array();

        $dbc->select($sql, $erg);

        $Anzeige = 0;

        if (count($erg) > 0)
            $Anzeige = $erg["ANZAHL"][0];

        //<------------------------------------>
        //<------ wenn News ------------------->

        $sql = "SELECT count(*) AS ANZAHL FROM " . $this->AKT_ANZEIGE . " WHERE Anzahl_Wiederholungen = " . $AnzahlWiederholungen . " AND Positions_ID = " . $this->Positions_ID . " and News_ID IS NOT NULL";
        //echo $sql;

        $dbc->select($sql, $erg);

        $News = 0;

        if (count($erg) > 0)
            $News = $erg["ANZAHL"][0];

        //<----------------------------------->

        $dbc->close();

        $Typ = 0;

        if ($Anzeige != 0)
            $Typ = 1;
        else if ($News != 0)
            $Typ = 2;

        return $Typ;
    }


    /**
     * @author Juri Zirnsak <jurizirnsak@gmail.com>
     *
     * This allows the usage of the service manager to get needed ressources
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $this->table_aktAnzeige  = $sm->get('Futhuer\Legacy\Model\Table\AktAnzeige');
        $this->table_infoscripte = $sm->get('Futhuer\Legacy\Model\Table\Infoscript');
        $this->table_anzeigen    = $sm->get('Futhuer\Legacy\Model\Table\Anzeige');
    }



    /**
     * @author Juri Zirnsak <jurizirnsak@gmail.com>
     * Calculates the maximal count of slides per hour.
     * @return int
     */
    private function getMaxWdh(){

        // maximale Anzahl von Anzeigen/Infoscripten pro stunde = 3600 / 20 = 180
        return self::ONE_HOUR_IN_SECONDS / self::INTERVAL;
    }

    /**
     * @author Juri Zirnsak <jurizirnsak@gmail.com>
     *
     * Returns the hourly repetition of a slide under a given probability.
     * With a probability of 5% each Anzeige is repeated 9 times per hour.
     *
     * @param array $anzeige
     * @return int
     */
    private function getWdh($anzeige){

        return $this->getMaxWdh() * $this->getProbabilityInPercent($anzeige['P']);
    }

    /**
     * @author Juri Zirnsak <jurizirnsak@gmail.com>
     *
     * Returns the given probability as percent.
     *
     * @param int $probability
     * @return double
     */
    private function getProbabilityInPercent($probability){
        return $probability / 100;
    }

}

?>