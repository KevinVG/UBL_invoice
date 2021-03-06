<?php
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 13-10-2016
 * Time: 16:29
 */

namespace CleverIt\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Invoice implements XmlSerializable{
    private $UBLVersionID = '2.1';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $customizationId;

    /**
     * @var string
     */
    private $profileId;
    
    /**
     * @var bool
     */
    private $copyIndicator = false;

    /**
     * @var \DateTime
     */
    private $issueDate;
    
    /**
     * @var \DateTime
     */
    private $taxPointDate;
    
    
    /**
     * @var string
     */

    private $invoiceTypeCode;
    /**
     * @var AdditionalDocumentReferences[]
     */
    private $additionalDocumentReferences = [];
    /**
     * @var Party
     */
    private $accountingSupplierParty;
    /**
     * @var Party
     */
    private $accountingCustomerParty;
    /**
     * @var PaymentMeans
     */
    private $paymentMeans;
    /**
     * @var TaxTotal
     */
    private $taxTotal;
    /**
     * @var LegalMonetaryTotal
     */
    private $legalMonetaryTotal;
    /**
     * @var InvoiceLine[]
     */
    private $invoiceLines;
    /**
     * @var AllowanceCharge[]
     */
    private $allowanceCharges;


    function validate()
    {
        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if (!$this->issueDate instanceof \DateTime) {
            throw new \InvalidArgumentException('Invalid invoice issueDate');
        }

        if ($this->invoiceTypeCode === null) {
            throw new \InvalidArgumentException('Missing invoice invoiceTypeCode');
        }

        if ($this->accountingSupplierParty === null) {
            throw new \InvalidArgumentException('Missing invoice accountingSupplierParty');
        }

        if ($this->accountingCustomerParty === null) {
            throw new \InvalidArgumentException('Missing invoice accountingCustomerParty');
        }

        if ($this->invoiceLines === null) {
            throw new \InvalidArgumentException('Missing invoice lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new \InvalidArgumentException('Missing invoice LegalMonetaryTotal');
        } 
    }

    function xmlSerialize(Writer $writer)
    {
        $cbc = '{urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2}';
        $cac = '{urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2}';

        $this->validate();

        $writer->write([
            $cbc . 'UBLVersionID' => $this->UBLVersionID
        ]);
        
        if($this->customizationId !== null) {
            $writer->write([
                $cbc . 'CustomizationID' => $this->customizationId,
            ]);
        }
        
        if($this->profileId !== null) {
            $writer->write([
                $cbc . 'ProfileID' => $this->profileId,
            ]);
        }
        
        $writer->write([
            $cbc . 'ID' => $this->id, 
            $cbc . 'IssueDate' => $this->issueDate->format('Y-m-d'), 
        ]);
        
        $writer->write([
            'name' => $cbc . 'InvoiceTypeCode',
            'value' => 380,
            'attributes' => ['listID' => 'UNCL1001']
        ]);
        
        if($this->taxPointDate !== null) {
            $writer->write([
                $cbc . 'TaxPointDate' => $this->taxPointDate->format('Y-m-d'),
            ]);
        }
        
        $writer->write([
            [
                'name' => $cbc . 'DocumentCurrencyCode',
                'value' => Generator::$currencyID,
                'attributes' => ['listID' => 'ISO4217'],
            ]
        ]); 

        foreach ($this->additionalDocumentReferences as $additionalDocumentReference) {
            $writer->write([
                Schema::CAC . 'AdditionalDocumentReference' => $additionalDocumentReference
            ]);
        }
        
        $writer->write([
            $cac . 'AccountingSupplierParty' => [$cac . "Party" => $this->accountingSupplierParty],
            $cac . 'AccountingCustomerParty' => [$cac . "Party" => $this->accountingCustomerParty],
        ]);

        if ($this->allowanceCharges != null) {
            foreach ($this->allowanceCharges as $invoiceLine) {
                $writer->write([
                    Schema::CAC . 'AllowanceCharge' => $invoiceLine
                ]);
            }
        }

        if ($this->paymentMeans != null) { 
            $writer->write([
                Schema::CAC . 'PaymentMeans' => $this->paymentMeans
            ]); 
        }
 
        if ($this->taxTotal != null) { 
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]); 
        }

        $writer->write([
            $cac . 'LegalMonetaryTotal' => $this->legalMonetaryTotal
        ]);

        foreach ($this->invoiceLines as $invoiceLine) {
            $writer->write([
                Schema::CAC . 'InvoiceLine' => $invoiceLine
            ]);
        }

    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Invoice
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCustomizationId() {
        return $this->customizationId;
    }

    /**
     * @param string $customizationId
     * @return Invoice
     */
    public function setCustomizationId($customizationId) {
        $this->customizationId = $customizationId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getProfileId() {
        return $this->profileId;
    }

    /**
     * @param string $ProfileId
     * @return Invoice
     */
    public function setProfileId($profileId) {
        $this->profileId = $profileId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCopyIndicator() {
        return $this->copyIndicator;
    }

    /**
     * @param boolean $copyIndicator
     * @return Invoice
     */
    public function setCopyIndicator($copyIndicator) {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getIssueDate() {
        return $this->issueDate;
    }

    /**
     * @param \DateTime $issueDate
     * @return Invoice
     */
    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTaxPointDate() {
        return $this->taxPointDate;
    }

    /**
     * @param \DateTime $issueDate
     * @return Invoice
     */
    public function setTaxPointDate($taxPointDate) {
        $this->taxPointDate = $taxPointDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceTypeCode() {
        return $this->invoiceTypeCode;
    }

    /**
     * @param string $invoiceTypeCode
     * @return Invoice
     */
    public function setInvoiceTypeCode($invoiceTypeCode) {
        $this->invoiceTypeCode = $invoiceTypeCode;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingSupplierParty() {
        return $this->accountingSupplierParty;
    }

    /**
     * @param Party $accountingSupplierParty
     * @return Invoice
     */
    public function setAccountingSupplierParty($accountingSupplierParty) {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingCustomerParty() {
        return $this->accountingCustomerParty;
    }

    /**
     * @param Party $accountingCustomerParty
     * @return Invoice
     */
    public function setAccountingCustomerParty($accountingCustomerParty) {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    /**
     * @return Party
     */
    public function getPaymentMeans() {
        return $this->paymentMeans;
    }

    /**
     * @param Party $paymentMeans
     * @return Invoice
     */
    public function setPaymentMeans($paymentMeans) {
        $this->paymentMeans = $paymentMeans;
        return $this;
    }

    /**
     * @return TaxTotal
     */
    public function getTaxTotal() {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     * @return Invoice
     */
    public function setTaxTotal($taxTotal) {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return LegalMonetaryTotal
     */
    public function getLegalMonetaryTotal() {
        return $this->legalMonetaryTotal;
    }

    /**
     * @param LegalMonetaryTotal $legalMonetaryTotal
     * @return Invoice
     */
    public function setLegalMonetaryTotal($legalMonetaryTotal) {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getInvoiceLines() {
        return $this->invoiceLines;
    }

    /**
     * @param InvoiceLine[] $invoiceLines
     * @return Invoice
     */
    public function setInvoiceLines($invoiceLines) {
        $this->invoiceLines = $invoiceLines;
        return $this;
    }

    /**
     * @return AddtionalDocumentReferences[]
     */
    public function getAdditionalDocumentReferences() {
        return $this->additionalDocumentReferences;
    }

    /**
     * @param AddtionalDocumentReferences[] $additionalDocumentReferences
     * @return Invoice
     */
    public function setADditionalDocumentReferences($additionalDocumentReferences) {
        $this->additionalDocumentReferences = $additionalDocumentReferences;
        return $this;
    }

    /**
     * @return AllowanceCharge[]
     */
    public function getAllowanceCharges() {
        return $this->allowanceCharges;
    }

    /**
     * @param AllowanceCharge[] $allowanceCharges
     * @return Invoice
     */
    public function setAllowanceCharges($allowanceCharges) {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

}