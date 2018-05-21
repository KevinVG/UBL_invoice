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

class FinancialInstitution implements XmlSerializable {
    private $id; 
    
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) { 
        if($this->id !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'ID',
                    'value' => $this->id,  
                    'attributes' => ['schemeID' => 'BIC']
                ]
            ]);
        }  
    }
}