<?php
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 25-10-2016
 * Time: 15:40
 */

namespace CleverIt\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Attachment implements XmlSerializable {
    private $embeddedDocumentBinaryObject; 

    /**
     * @return mixed
     */	
     public function getEmbeddedDocumentBinaryObject(){
		return $this->embeddedDocumentBinaryObject;
	}

	public function setEmbeddedDocumentBinaryObject($embeddedDocumentBinaryObject){
		$this->embeddedDocumentBinaryObject = $embeddedDocumentBinaryObject;
		return $this;
	} 

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {  
        $writer->write([
            'name' => Schema::CBC.'EmbeddedDocumentBinaryObject',
            'value' => $this->embeddedDocumentBinaryObject,
            'attributes' => [ 'mimeCode' => 'application/pdf']
        ]); 
    }
}