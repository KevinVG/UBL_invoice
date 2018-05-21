<?php
/**
 * Created by PhpStorm.
 * User: baselbers
 * Date: 26-10-2017
 * Time: 21:45
 */

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PartyLegalEntity implements XmlSerializable {

	/**
	 * @var string
	 */
	private $registrationName;

	/**
	 * @var int
	 */
	private $companyId;

	public function getRegistrationName() {
		return $this->registrationName;
	}

	public function setRegistrationName($registrationName) {
		$this->registrationName = $registrationName;
		return $this;
	}

	public function getCompanyId() {
		return $this->companyId;
	}

	public function setCompanyId($companyId) {
		$this->companyId = $companyId;
		return $this;
	}

	public function getCompanyIdSchemeId() {
		return $this->companyIdSchemeId;
	}

	public function setCompanyIdSchemeId($companyIdSchemeId) {
		$this->companyIdSchemeId = $companyIdSchemeId;
		return $this;
	}

	function xmlSerialize(Writer $writer) {
		$writer->write([
			Schema::CBC.'RegistrationName' => $this->registrationName,
			[
				'name' => Schema::CBC.'CompanyID',
				'value' => $this->companyId,
				'attributes' => [
					'schemeID' => $this->companyIdSchemeId
				]
			]
		]);
	}
}