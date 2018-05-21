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

class PayeeFinancialAccount implements XmlSerializable {
    private $id;
    private $financialInstitutionBranch;
    
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function getFinancialInstitutionBranch(){
		return $this->financialInstitutionBranch;
	}

	public function setFinancialInstitutionBranch($financialInstitutionBranch){
		$this->financialInstitutionBranch = $financialInstitutionBranch;
		return $this;
	}
	
    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {
        if(!$this->id && !$this->financialInstitutionBranch) {
            return;
        }
        // TODO: Implement xmlSerialize() method. 
        if($this->id !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'ID',
                    'value' => $this->id,  
                    'attributes' => ['schemeID' => 'IBAN']
                ]
            ]);
        } 
        if($this->financialInstitutionBranch !== null) {
            $writer->write([
                [
                    'name' => Schema::CAC . 'FinancialInstitutionBranch',
                    'value' => $this->financialInstitutionBranch
                ]
            ]);
        } 
    }
}