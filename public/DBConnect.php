<?php

/**
 * 
 * DBConnect
 * Klasse zur Anbindung an die Datenbank
 */
class DBConnect {
  
  //Produktivserver
  private $_Host               = "212.201.65.202";
  private $_Benutzername       = "jobapp3";
  private $_Passwort           = "jobapp3";
  private $_Datenbank          = "fut1";

  //Gibt Auskunft über Verbindung mit der DB
  private $_conn               = false;

  public function DBConnect(){}
  public function getHost(){}
  public function getBenutzername(){}
  public function getPasswort(){}
  public function getDatenbank(){}
  public function setHost(){}
  public function setBenutzername(){}
  public function setPasswort(){}
  public function setDatenbank(){}
  
  /**
   *
   * connect
   * baut Verbindung zur Datenbank auf
   * 
   * @return $_conn - DB-Verbindung, die zurückgegeben wird
   */
  public function connect() {
    
    $this->_conn = oci_connect($this->_Benutzername, $this->_Passwort, $this->_Host."/".$this->_Datenbank, 'WE8ISO8859P15');

    if (!$this->_conn) {
      echo "Verbindung fehlgeschlagen";
    }else {
      return $this->_conn;
    }
  }

  /**
   * 
   * close
   * beendet Verbindung zur Datenbank
   */
  public function close() {
    if($this->_conn)
    ocilogoff($this->_conn);
  }

  /**
   *
   * select
   * führt nicht-ändernde Datenbankabfragen aus
   * 
   * @param string $sql - übergebener SQL-String
   * @param array $erg - Ergebnis-Array
   * 
   * @return boolean - select-Abfrage erfolgreich oder nicht 
   */
  public function select($sql, array &$erg) {
    if($this->_conn) {
      if (!$result = ociparse($this->_conn,$sql)) {
        echo "Error in parse";
        return false;
      }else {
        oci_execute($result);
        oci_fetch_all($result, $erg);
        return true;
      }
    }
  }
        
  /**
   *
   * execute
   * führt ändernde Datenbankabfragen aus
   * 
   * @param type $sql
   * 
   * @return boolean/string - wenn execute erfolgreich, dann True, sonst ORA-Fehler  
   */
  public function execute($sql){
    if (!$result = ociparse($this->_conn, $sql)){
      return ora_error($curs);
    }else {
      oci_execute($result);
      ocicommit($this->_conn);
      return true;
    }
  }
}
?>