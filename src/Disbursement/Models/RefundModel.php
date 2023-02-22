<?php

namespace momopsdk\Disbursement\Models;

use momopsdk\Common\Models\BaseModel;

/**
 * Class GetAccBalance
 * @package momopsdk\Disbursement\Models
 */
class RefundModel extends BaseModel
{

    /**
     * Amount
     */
    public $amount;

    public $currency;

    public $externalid;

    public $message;

    public $note;

    public $refId;

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setExternalId($externalid)
    {
        $this->externalid = $externalid;
        return $this;
    }

    public function getExternalId()
    {
        return $this->externalid;
    }

    public function setPayerMessage($msg)
    {
        $this->message = $msg;
        return $this;
    }

    public function getPayerMessage()
    {
        return $this->message;
    }

    public function setPayeeNote($note)
    {
        $this->note = $note;
        return $this;
    }

    public function getPayeeNote()
    {
        return $this->note;
    }

    public function setReferenceIdToRefund($refId)
    {
        $this->refId = $refId;
        return $this;
    }

    public function getReferenceIdToRefund()
    {
        return $this->refId;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'amount' =>
                $this->amount,
            'currency' =>
                $this->currency,
            'externalId' => $this->externalid,
            'payerMessage' => $this->message,
            'payeeNote' => $this->note,
            'referenceIdToRefund' => $this->refId
        ]);
    }

}