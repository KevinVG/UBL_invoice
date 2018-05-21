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

class AdditionalDocumentReference implements XmlSerializable {
    private $id;
    private $name;
    private $attachment; 

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AdditionalDocumentReference
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocumentType() {
        return $this->documentType;
    }

    /**
     * @param mixed $documentType
     * @return AdditionalDocumentReference
     */
    public function setDocumentType($documentType) {
        $this->documentType = $documentType;
        return $this;
    } 

    /**
     * @return Attachment
     */
    public function getAttachment() {
        return $this->attachment;
    }

    /**
     * @param mixed $attachment
     * @return Attachment
     */
    public function setAttachment($attachment) {
        $this->attachment = $attachment;
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
            Schema::CBC.'ID' => $this->id, 
        ]);
        
        if($this->documentType !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'DocumentType',
                    'value' => $this->documentType
                ]
            ]);
        } 
        
        if($this->attachment !== null) {
            $writer->write([
                [
                    'name' => Schema::CAC . 'Attachment',
                    'value' => $this->attachment
                ]
            ]);
        }  
    }
}