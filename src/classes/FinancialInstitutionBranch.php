<?php 
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 13-10-2016
 * Time: 17:19
 */
namespace CleverIt\UBL\Invoice;
  
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FinancialInstitutionBranch implements XmlSerializable {
    private $id;
    private $financialInstitution;
    
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function getFinancialInstitution(){
		return $this->financialInstitution;
	}

	public function setFinancialInstitution($financialInstitution){
		$this->financialInstitution = $financialInstitution;
		return $this;
	}
	
    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) { 
        if($this->financialInstitution !== null) {
            $writer->write([
                [
                    'name' => Schema::CAC . 'FinancialInstitution',
                    'value' => $this->financialInstitution
                ]
            ]);
        } 
    }
}