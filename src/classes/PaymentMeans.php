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

class PaymentMeans implements XmlSerializable {
    private $id;
    private $paymentDueDate;
    private $instructionId;
    private $instructionNote;
    private $paymentId;
    private $payeeFinancialAccount;
    
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function getPaymentDueDate(){
		return $this->paymentDueDate;
	}

	public function setPaymentDueDate($paymentDueDate){
		$this->paymentDueDate = $paymentDueDate;
		return $this;
	}

	public function getInstructionId(){
		return $this->instructionId;
	}

	public function setInstructionId($instructionId){
		$this->instructionId = $instructionId;
		return $this;
	}

	public function getInstructionNote(){
		return $this->instructionNote;
	}

	public function setInstructionNote($instructionNote){
		$this->instructionNote = $instructionNote;
		return $this;
	}

	public function getPaymentId(){
		return $this->paymentId;
	}

	public function setPaymentId($paymentId){
		$this->paymentId = $paymentId;
		return $this;
	} 

	public function getPayeeFinancialAccount(){
		return $this->payeeFinancialAccount;
	}

	public function setPayeeFinancialAccount($payeeFinancialAccount){
		$this->payeeFinancialAccount = $payeeFinancialAccount;
		return $this;
	} 

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    function xmlSerialize(Writer $writer) {
        if(!$this->id && !$this->paymentDueDate && !$this->instructionId && !$this->instructionNote && !$this->paymentId) {
            return;
        }
        // TODO: Implement xmlSerialize() method. 
        if($this->id !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'ID',
                    'value' => $this->id,  
                ]
            ]);
        }
        $writer->write([
            [
                'name' => Schema::CBC . 'PaymentMeansCode',
                'value' => 1,  
                'attributes' => ['listID' => 'UNCL4461']
            ]
        ]);
        if($this->paymentDueDate !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'PaymentDueDate',
                    'value' => $this->paymentDueDate->format('Y-m-d'),  
                ]
            ]);
        }
        if($this->instructionId !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'InstructionID',
                    'value' => $this->instructionId,  
                ]
            ]);
        }
        if($this->instructionNote !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'InstructionNote',
                    'value' => $this->instructionNote,  
                ]
            ]);
        }
        if($this->paymentId !== null) {
            $writer->write([
                [
                    'name' => Schema::CBC . 'PaymentID',
                    'value' => $this->paymentId,  
                ]
            ]);
        }
        if($this->payeeFinancialAccount !== null) {
            $writer->write([
                [
                    'name' => Schema::CAC . 'PayeeFinancialAccount',
                    'value' => $this->payeeFinancialAccount,  
                ]
            ]);
        }
    }
}