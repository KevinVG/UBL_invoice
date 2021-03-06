<?php
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 25-10-2016
 * Time: 15:48
 */

namespace CleverIt\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class LegalMonetaryTotal implements XmlSerializable {
    private $lineExtensionAmount;
    private $taxExclusiveAmount;
    private $taxInclusiveAmount;
    private $allowanceTotalAmount = 0;
    private $prepaidAmount;
    private $payableRoundingAmount;
    private $payableAmount;

    /**
     * @return mixed
     */
    public function getLineExtensionAmount() {
        return $this->lineExtensionAmount;
    }

    /**
     * @param mixed $lineExtensionAmount
     * @return LegalMonetaryTotal
     */
    public function setLineExtensionAmount($lineExtensionAmount) {
        $this->lineExtensionAmount = $lineExtensionAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxExclusiveAmount() {
        return $this->taxExclusiveAmount;
    }

    /**
     * @param mixed $taxExclusiveAmount
     * @return LegalMonetaryTotal
     */
    public function setTaxExclusiveAmount($taxExclusiveAmount) {
        $this->taxExclusiveAmount = $taxExclusiveAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxInclusiveAmount() {
        return $this->taxInclusiveAmount;
    }

    /**
     * @param mixed $taxExclusiveAmount
     * @return LegalMonetaryTotal
     */
    public function setTaxInclusiveAmount($taxInclusiveAmount) {
        $this->taxInclusiveAmount = $taxInclusiveAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAllowanceTotalAmount() {
        return $this->allowanceTotalAmount;
    }

    /**
     * @param mixed $allowanceTotalAmount
     * @return LegalMonetaryTotal
     */
    public function setAllowanceTotalAmount($allowanceTotalAmount) {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
        return $this;
    }

    /**
     * @param mixed $prepaidAmount
     * @return LegalMonetaryTotal
     */
    public function setPrepaidAmount($prepaidAmount) {
        $this->prepaidAmount = $prepaidAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrepaidAmount() {
        return $this->prepaidAmount;
    }

    /**
     * @return mixed
     */
    public function getPayableAmount() {
        return $this->payableAmount;
    }

    /**
     * @param mixed $payableRoundingAmount
     * @return LegalMonetaryTotal
     */
    public function setPayableRoundingAmount($payableRoundingAmount) {
        $this->payableRoundingAmount = $payableRoundingAmount;
        return $this;
    }

    /**
     * @param mixed $payableAmount
     * @return LegalMonetaryTotal
     */
    public function setPayableAmount($payableAmount) {
        $this->payableAmount = $payableAmount;
        return $this;
    }


    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {
        // TODO: Implement xmlSerialize() method.
        $writer->write([
            [
                'name' => Schema::CBC . 'LineExtensionAmount',
                'value' => number_format($this->lineExtensionAmount,2,'.',''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]

            ],
            [
                'name' => Schema::CBC . 'TaxExclusiveAmount',
                'value' => number_format($this->taxExclusiveAmount,2,'.',''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]

            ]
        ]);
        if($this->taxInclusiveAmount !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'TaxInclusiveAmount',
                    'value' => number_format($this->taxInclusiveAmount,2,'.',''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID
                    ]
    
                ]
            ]);
        }
        if($this->allowanceTotalAmount !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'AllowanceTotalAmount',
                    'value' => number_format($this->allowanceTotalAmount,2,'.',''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID
                    ]
    
                ]
            ]);
        }
        if($this->prepaidAmount !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'PrepaidAmount',
                    'value' => number_format($this->prepaidAmount,2,'.',''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID
                    ]
    
                ]
            ]);
        }
        if($this->payableRoundingAmount !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'PayableRoundingAmount',
                    'value' => number_format($this->payableRoundingAmount,2,'.',''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID
                    ]
    
                ]
            ]);
        }  
        if($this->payableAmount !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'PayableAmount',
                    'value' => number_format($this->payableAmount,2,'.',''),
                    'attributes' => [
                        'currencyID' => Generator::$currencyID
                    ]
    
                ]
            ]);
        }  
    }
}