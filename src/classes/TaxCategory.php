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

class TaxCategory implements XmlSerializable {
    private $id;
    private $name;
    private $percent;
    private $taxExemptionReason;
    private $taxScheme;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TaxCategory
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return TaxCategory
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercent() {
        return $this->percent;
    }

    /**
     * @param mixed $percent
     * @return TaxCategory
     */
    public function setPercent($percent) {
        $this->percent = $percent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxExemptionReason() {
        return $this->taxExemptionReason;
    }

    /**
     * @param mixed $taxExemptionReason
     * @return TaxCategory
     */
    public function setTaxExemptionReason($taxExemptionReason) {
        $this->taxExemptionReason = $taxExemptionReason;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxScheme() {
        return $this->taxScheme;
    }

    /**
     * @param mixed $taxScheme
     * @return TaxCategory
     */
    public function setTaxScheme($taxScheme) {
        $this->taxScheme = $taxScheme;
        return $this;
    }



    public function validate() { 
        if ($this->percent === null) {
            throw new \InvalidArgumentException('Missing taxcategory percent');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {
        $this->validate();

        if($this->id !== null) {
            $writer->write([
                'name' => Schema::CBC.'ID',
                'value' => $this->id,
                'attributes' => ['schemeID' => 'UNCL5305']
             ]);
        }
        if($this->name !== null) {
            $writer->write([
                Schema::CBC.'Name' => $this->name,
             ]);
        }
        if($this->percent !== null) {
            $writer->write([
                Schema::CBC.'Percent' => $this->percent,
             ]);
        } 
        
        if($this->taxExemptionReason !== null) { 
            $writer->write([
                Schema::CBC.'TaxExemptionReason' => $this->taxExemptionReason,
             ]);
        }

        if($this->taxScheme != null){
            $writer->write([Schema::CAC.'TaxScheme' => $this->taxScheme]);
        }
    }
}