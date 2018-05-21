<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../vendor/autoload.php";
$xmlService = new Sabre\Xml\Service();

$xmlService->namespaceMap = [
    'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
    'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
    'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac'
];

$invoice = new \CleverIt\UBL\Invoice\Invoice();
$date = \DateTime::createFromFormat('d-m-Y', '12-12-1994');
$invoice->setCustomizationId('1.0');
$invoice->setProfileId('1.0');
$invoice->setId('CIT1234');
$invoice->setIssueDate($date);
$invoice->setTaxPointDate($date); 
$invoice->setInvoiceTypeCode(380); 

$invoice->setAdditionalDocumentReferences([
    (new \CleverIt\UBL\Invoice\AdditionalDocumentReference())
        ->setId('F180001')
        ->setDocumentType('CommercialInvoice')
        ->setAttachment((new \CleverIt\UBL\Invoice\Attachment)
            ->setEmbeddedDocumentBinaryObject('BASE64'))
]);

$accountingSupplierParty = new \CleverIt\UBL\Invoice\Party();
$accountingSupplierParty->setEndpointId('BE083745535');
$accountingSupplierParty->setEndpointIdSchemeId('BE:VAT');
$accountingSupplierParty->setPartyTaxScheme((new \CleverIt\UBL\Invoice\PartyTaxScheme())
    ->setCompanyId('BE0837455735') 
    ->setCompanyIdSchemeId('BE:VAT')
    ->setTaxScheme((new \CleverIt\UBL\Invoice\TaxScheme())->setId('VAT')));
$accountingSupplierParty->setName('CleverIt'); 
$supplierAddress = (new \CleverIt\UBL\Invoice\Address())
    ->setCityName("Eindhoven")
    ->setStreetName("Keizersgracht")
    ->setBuildingNumber("15")
    ->setPostalZone("5600 AC")
    ->setCountry((new \CleverIt\UBL\Invoice\Country())->setIdentificationCode("NL"));
$accountingSupplierParty->setPartyLegalEntity((new \CleverIt\UBL\Invoice\PartyLegalEntity())
    ->setCompanyId('BE0837455735') 
    ->setCompanyIdSchemeId('BE:VAT')
    ->setRegistrationName('CleverIt'));

$accountingSupplierParty->setPostalAddress($supplierAddress);
$accountingSupplierParty->setPhysicalLocation($supplierAddress);
$accountingSupplierParty->setContact((new \CleverIt\UBL\Invoice\Contact())->setElectronicMail("info@cleverit.nl")->setTelephone("31402939003"));

$invoice->setAccountingSupplierParty($accountingSupplierParty);
$invoice->setAccountingCustomerParty($accountingSupplierParty);

$invoice->setPaymentMeans((new \CleverIt\UBL\Invoice\PaymentMeans())
    ->setId('123')
    ->setPaymentDueDate(\DateTime::createFromFormat('d-m-Y', '12-12-1995'))
    ->setInstructionId('123/4567/45687')
    ->setInstructionNote('123456789')
    ->setPaymentId('123456789')
    ->setPayeeFinancialAccount((new \CleverIt\UBL\Invoice\PayeeFinancialAccount())
        ->setId('BE083745535')
        ->setFinancialInstitutionBranch((new \CleverIt\UBL\Invoice\FinancialInstitutionBranch())
            ->setFinancialInstitution((new \CleverIt\UBL\Invoice\FinancialInstitution())
                ->setId('HBKBEA22')))));

$taxtotal = (new \CleverIt\UBL\Invoice\TaxTotal())
    ->setTaxAmount(30)
    ->addTaxSubTotal((new \CleverIt\UBL\Invoice\TaxSubTotal())
        ->setTaxAmount(21)
        ->setTaxableAmount(100)
        ->setTaxCategory((new \CleverIt\UBL\Invoice\TaxCategory())
            ->setId("H")
            ->setName("NL, Hoog Tarief")
            ->setPercent(21.00)
            ->setTaxScheme((new \CleverIt\UBL\Invoice\TaxScheme())->setId('VAT'))));

$invoiceLine = (new \CleverIt\UBL\Invoice\InvoiceLine())
    ->setId(1)
    ->setInvoicedQuantity(1)
    ->setLineExtensionAmount(100)
    ->setTaxTotal($taxtotal)
    ->setItem((new \CleverIt\UBL\Invoice\Item())->setName("Test item")->setDescription("test item description")->setSellersItemIdentification("1ABCD"));

$invoice->setInvoiceLines([$invoiceLine]);
$invoice->setTaxTotal($taxtotal);
$invoice->setLegalMonetaryTotal((new \CleverIt\UBL\Invoice\LegalMonetaryTotal())
    ->setLineExtensionAmount(100)
    ->setTaxExclusiveAmount(100)
    ->setTaxInclusiveAmount(121)
    ->setPayableAmount(121)
    ->setAllowanceTotalAmount(0));

header('Content-Type: application/xml');
echo \CleverIt\UBL\Invoice\Generator::invoice($invoice, 'EUR');
