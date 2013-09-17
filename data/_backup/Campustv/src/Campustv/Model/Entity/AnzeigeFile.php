<?php

namespace Campustv\Model\Entity;


class AnzeigeFile {

    const JOB_TITLE       = 'Jobtitel';
    const ENTERPRISE_LOGO = 'url';

    const REQUIREMENTS_HEADER = 'Ihr Profil: ';
    const DESCRIPTION_HEADER  = 'Wir bieten: ';

    protected $_jobTitle;
    protected $_enterpriseLogo;
    protected $_enterpriseName;
    protected $_enterpriseContact = array();
    protected $_requirements      = array();
    protected $_description       = array();

    public function getJobTitle(){
        return $this->_jobTitle;
    }

    public function getEnterpriseLogo(){
        return $this->_enterpriseLogo;
    }

    public function getEnterpriseName(){
        return $this->_enterpriseName;
    }

    public function getEnterpriseContact(){
        return $this->_enterpriseContact;
    }

    public function getRequirements(){
        return $this->_requirements;
    }

    public function getDescription(){
        return $this->_description;
    }

    public function setJobTitle($jobtitle){

        if(!is_string($jobtitle)){
            throw new \RuntimeException('Jobtitle must be a string');
        }

        $this->_jobTitle = $jobtitle;

        return $this;
    }

    public function setEnterpriseLogo($enterpriseLogo){

        if(!is_string($enterpriseLogo)){
            throw new \RuntimeException('Enterpriselogo must be a string containing an url to an image');
        }

        $this->_enterpriseLogo = $enterpriseLogo;

        return $this;

    }

    public function setEnterpriseName($enterpriseName){

        if(!is_string($enterpriseName)){
            throw new \RuntimeException('Enterprise name must be a string');
        }

        $this->_enterpriseName = $enterpriseName;

        return $this;
    }

    public function setEnterpriseContact(array $enterpriseContact){

        $this->_enterpriseContact = $enterpriseContact;

        return $this;
    }

    public function setRequirements(array $requirements){

        $this->_requirements = $requirements;

        return $this;
    }

    public function setDescription(array $description){

        $this->_description = $description;

        return $this;
    }

    public function getRequirementsHeader(){
        return self::REQUIREMENTS_HEADER;
    }

    public function getDescriptionHeader(){
        return self::DESCRIPTION_HEADER;
    }

}


?>
