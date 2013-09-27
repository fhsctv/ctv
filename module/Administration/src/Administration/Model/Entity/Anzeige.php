<?php

namespace Administration\Model\Entity;

use Administration\Model\IEntity;

//http://framework.zend.com/manual/2.0/en/user-guide/forms-and-actions.html


class Anzeige implements IEntity {

    const TBL_COL_ID           = 'id';
    const TBL_COL_BEGIN_DATE   = 'schaltungsanfang';
    const TBL_COL_END_DATE     = 'schaltungsende';
    const TBL_COL_PROPABILITY  = 'wahrscheinlichkeit';
    const TBL_COL_SEARCH_ID    = 'such_id';
    const TBL_COL_CUSTOMER_ID  = 'kunden_id';
    const TBL_COL_DISPLAY_ID   = 'positions_id';
    const TBL_COL_INSIDE_CART  = 'imwarenkorb';
    const TBL_COL_BOOKED_WEEKS = 'gebuchte_wochen';
    const TBL_COL_URL          = 'url';      //TABLE URL
    const TBL_COL_CUSTOMER     = 'par_name'; //TABLE TBL_PARTNER

    private $id;
    private $schaltungsanfang;
    private $schaltungsende;
    private $wahrscheinlichkeit;
    private $such_id;
    private $kunden_id;
    private $positions_id;
    private $imwarenkorb;
    private $gebuchte_wochen;

    //from join with Db- Table 'URL'
    public $url;

    //from join with Db- Table 'TBL_PARTNER'
    public $par_name;

//    protected $inputFilter;


    public function getSchaltungsanfang() {
        return $this->schaltungsanfang;
    }

    public function setSchaltungsanfang($schaltungsanfang) {
        $this->schaltungsanfang = $schaltungsanfang;
        return $this;
    }

    public function getSchaltungsende() {
        return $this->schaltungsende;
    }

    public function setSchaltungsende($schaltungsende) {
        $this->schaltungsende = $schaltungsende;
        return $this;
    }

    public function getWahrscheinlichkeit() {
        return $this->wahrscheinlichkeit;
    }

    public function setWahrscheinlichkeit($wahrscheinlichkeit) {
        $this->wahrscheinlichkeit = $wahrscheinlichkeit;
        return $this;
    }

    public function getSuchId() {
        return $this->such_id;
    }

    public function setSuchId($such_id) {
        $this->such_id = $such_id;
        return $this;
    }

    public function getKundenId() {
        return $this->kunden_id;
    }

    public function setKundenId($kunden_id) {
        $this->kunden_id = $kunden_id;
        return $this;
    }

    public function getPositionsId() {
        return $this->positions_id;
    }

    public function setPositionsId($positions_id) {
        $this->positions_id = $positions_id;
        return $this;
    }

    public function getImwarenkorb() {
        return $this->imwarenkorb;
    }

    public function setImwarenkorb($imwarenkorb) {
        $this->imwarenkorb = $imwarenkorb;
        return $this;
    }

    public function getGebuchteWochen() {
        return $this->gebuchte_wochen;
    }

    public function setGebuchteWochen($gebuchte_wochen) {
        $this->gebuchte_wochen = $gebuchte_wochen;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getParName() {
        return $this->par_name;
    }

    public function setParName($par_name) {
        $this->par_name = $par_name;
        return $this;
    }

    public function setId($id) {

        if(is_null($id) || empty($id)){
            return $this;
        }

        $this->id = $id;

        assert(!(is_null($this->id) || empty($this->id)));

        return $this;

    }



    // <editor-fold defaultstate="collapsed" desc="comment">


//    public function exchangeArray(array $data) {
//
//
//        $this->id                 = (isset($data[self::TBL_COL_ID]))           ? $data[self::TBL_COL_ID]           : null;
//        $this->schaltungsanfang   = (isset($data[self::TBL_COL_BEGIN_DATE]))   ? $data[self::TBL_COL_BEGIN_DATE]   : null;
//        $this->gebuchte_wochen    = (isset($data[self::TBL_COL_BOOKED_WEEKS])) ? $data[self::TBL_COL_BOOKED_WEEKS] : null;
//
////        $this->schaltungsende     = (isset($this->schaltungsanfang)) ? date('d.m.Y',strtotime($this->schaltungsanfang . '+' . $this->gebuchte_wochen . ' Week')) : null;
//
//        $this->schaltungsende     = (isset($this->schaltungsanfang)) ? (new FuthuerDate($this->schaltungsanfang))->modify(FuthuerDate::OP_ADD, $this->gebuchte_wochen, FuthuerDate::WEEK) : null;
//
//
//        $this->wahrscheinlichkeit = (isset($data[self::TBL_COL_PROPABILITY]))  ? $data[self::TBL_COL_PROPABILITY]  : null;
//        $this->such_id            = (isset($data[self::TBL_COL_SEARCH_ID]))    ? $data[self::TBL_COL_SEARCH_ID]    : null;
//        $this->kunden_id          = (isset($data[self::TBL_COL_CUSTOMER_ID]))  ? $data[self::TBL_COL_CUSTOMER_ID]  : null;
//        $this->positions_id       = (isset($data[self::TBL_COL_DISPLAY_ID]))   ? $data[self::TBL_COL_DISPLAY_ID]   : null;
//        $this->imwarenkorb        = (isset($data[self::TBL_COL_INSIDE_CART]))  ? $data[self::TBL_COL_INSIDE_CART]  : null;
//
//
//        $this->url                = (isset($data[self::TBL_COL_URL]))          ? $data[self::TBL_COL_URL]          : null;
//        $this->par_name           = (isset($data[self::TBL_COL_CUSTOMER]))     ? $data[self::TBL_COL_CUSTOMER]     : null;
//
//        return $this;
//    }
//
//    public function getArrayCopy(){
//        return $this->toArray();
//    }// </editor-fold>

    public function toDbArray(){

        $result = array();

        (!isset($this->id))                 ? : $result[self::TBL_COL_ID]           = $this->id ;
        (!isset($this->schaltungsanfang))   ? : $result[self::TBL_COL_BEGIN_DATE]   = $this->schaltungsanfang ;
        (!isset($this->schaltungsende))     ? : $result[self::TBL_COL_END_DATE]     = $this->schaltungsende ;
        (!isset($this->wahrscheinlichkeit)) ? : $result[self::TBL_COL_PROPABILITY]  = $this->wahrscheinlichkeit ;
        (!isset($this->such_id))            ? : $result[self::TBL_COL_SEARCH_ID]    = $this->such_id ;
        (!isset($this->kunden_id))          ? : $result[self::TBL_COL_CUSTOMER_ID]  = $this->kunden_id ;
        (!isset($this->positions_id))       ? : $result[self::TBL_COL_DISPLAY_ID]   = $this->positions_id ;
        (!isset($this->imwarenkorb))        ? : $result[self::TBL_COL_INSIDE_CART]  = $this->imwarenkorb ;
        (!isset($this->gebuchte_wochen))    ? : $result[self::TBL_COL_BOOKED_WEEKS] = $this->gebuchte_wochen ;

        return $result;


    }

    public function toArray(){
        return array(
          self::TBL_COL_ID           => $this->id ,
          self::TBL_COL_BEGIN_DATE   => $this->schaltungsanfang,
          self::TBL_COL_END_DATE     => $this->schaltungsende,
          self::TBL_COL_PROPABILITY  => $this->wahrscheinlichkeit,
          self::TBL_COL_SEARCH_ID    => $this->such_id,
          self::TBL_COL_CUSTOMER_ID  => $this->kunden_id,
          self::TBL_COL_DISPLAY_ID   => $this->positions_id,
          self::TBL_COL_INSIDE_CART  => $this->imwarenkorb,
          self::TBL_COL_BOOKED_WEEKS => $this->gebuchte_wochen,
          self::TBL_COL_URL          => $this->url,
          self::TBL_COL_CUSTOMER     => $this->par_name,
        );
    }

    public function getId() {
        return $this->id;
    }

    // <editor-fold defaultstate="collapsed" desc="Filter">

//    public function getInputFilter() {
//        if($this->inputFilter)
//            return $this->inputFilter;
//
//
//        $this->inputFilter = new InputFilter();
//        $factory           = new InputFactory();
//
//        // <editor-fold defaultstate="collapsed" desc="Inputs">
//
//        // <editor-fold defaultstate="collapsed" desc="Id">
//        $idInput = $factory->createInput(array(
//            'name' => self::TBL_COL_ID,
//            'required' => true,
//            'filters' => array(
//                array('name' => 'Int'),
//            ),
//        ));
//        // </editor-fold>
//        // <editor-fold defaultstate="collapsed" desc="PositionsId">
//        $positionsIdInput = $factory->createInput(array(
//            'name' => self::TBL_COL_DISPLAY_ID,
//            'required' => true,
//            'filters' => array(
//                array('name' => 'Int'),
//            ),
//        ));
//        // </editor-fold>
//        // <editor-fold defaultstate="collapsed" desc="Wahrscheinlichkeit">
//        $wahrscheinlichkeitInput = $factory->createInput(array(
//            'name' => self::TBL_COL_PROPABILITY,
//            'required' => true,
//            'filters' => array(
//                array('name' => 'Int'),
//            ),
//        ));
//        // </editor-fold>
//        // <editor-fold defaultstate="collapsed" desc="Schaltungsanfang">
//        $schaltungsAnfangInput = $factory->createInput(array(
//            'name' => self::TBL_COL_BEGIN_DATE,
//            'required' => true,
//            'filters' => array(
//                array('name' => 'StripTags'), //remove unwanted html
//                array('name' => 'StringTrim'), //remove unwanted white spaces
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'StringLength',
//                    'options' => array(
//                        'encoding' => 'UTF-8',
//                        'min' => 8,
//                        'max' => 10,
//                    ),
//                ),
//                array(
//                    'name' => 'Date',
//                    'options' => array(
//                        'format' => 'd.m.Y',
//                    ),
//                ),
//            ),
//        ));
//        // </editor-fold>
//        // <editor-fold defaultstate="collapsed" desc="Url">
//        $urlInput = $factory->createInput(array(
//            'name' => self::TBL_COL_URL,
//            'required' => true,
//            'filters' => array(
//                array('name' => 'StripTags'),
//                array('name' => 'StringTrim'),
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'StringLength',
//                    'options' => array(
//                        'encoding' => 'UTF-8',
//                        'min' => 1,
//                        'max' => 100,
//                    ),
//                ),
//            ),
//        ));
//        // </editor-fold>
//        // </editor-fold>
//
//        $this->inputFilter->add($idInput);
//        $this->inputFilter->add($wahrscheinlichkeitInput);
//        $this->inputFilter->add($positionsIdInput);
//        $this->inputFilter->add($schaltungsAnfangInput);
//        $this->inputFilter->add($urlInput);
//
//        return $this->inputFilter;
//
//    }
//
//    public function setInputFilter(InputFilterInterface $inputFilter) {
//
//        throw new \Exception("Not used");
//    }
// </editor-fold>

    public function getIdKey() {
        return self::TBL_COL_ID;
    }
}

?>
