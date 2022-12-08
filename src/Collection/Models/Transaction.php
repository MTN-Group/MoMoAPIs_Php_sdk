<?php

namespace mmpsdk\Collection\Models;

use mmpsdk\Common\Models\BaseModel;
use mmpsdk\Common\Utils\CommonUtil;

class Transaction extends BaseModel
{

    /**
     * @var string
     */
    protected $financialTransactionId;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $externalId;

    /**
     * @var array
     */
    protected $payer;

    /**
     * @var string
     */
    protected $payerId;

    /**
     * @var string
     */
    protected $payerIdType;

    /**
     * @var string
     */
    protected $payerMessage;

    /**
     * @var string
     */
    protected $payeeNote;

    /**
     * @var string
     */
    protected $status;

    /**
     * @return string|null
     */
    public function getFinancialTransactionId()
    {
        return $this->financialTransactionId;
    }

    /**
     * @param string|null $financialTransactionId
     *
     * @return Transaction
     */
    public function setFinancialTransactionId($financialTransactionId)
    {
        $this->financialTransactionId = $financialTransactionId;

        return $this;
    } 

    /**
     * @return string|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string|null $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalId()
    {
        return $this->currency;
    }

    /**
     * @param string|null $externalId
     *
     * @return Transaction
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param array|null $payer
     *
     * @return Transaction
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartyIdType()
    {
        return $this->partyIdType;
    }

    /**
     * @param string|null $partyIdType
     *
     * @return Transaction
     */
    public function setPartyIdType($partyIdType)
    {
        $this->partyIdType = $partyIdType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartyId()
    {
        return $this->partyId;
    }

    /**
     * @param string|null $partyId
     *
     * @return Transaction
     */
    public function setPartyId($partyId)
    {
        $this->partyId = $partyId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayerMessage()
    {
        return $this->payerMessage;
    }

    /**
     * @param string|null $payerMessage
     *
     * @return Transaction
     */
    public function setPayerMessage($payerMessage)
    {
        $this->payerMessage = $payerMessage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayeeNote()
    {
        return $this->payeeNote;
    }

    /**
     * @param string|null $payeeNote
     *
     * @return Transaction
     */
    public function setPayeeNote($payeeNote)
    {
        $this->payeeNote = $payeeNote;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     *
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->filterEmpty([
            'financialTransactionId' => $this->financialTransactionId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'externalId' => $this->externalId,
            'payer' => $this->payer,
            'payerMessage' => $this->payerMessage,
            'payeeNote' => $this->payeeNote,
            'status' => $this->status,
        ]);
    }

    public function hydratorStrategies()
    {
        // $this->addHydratorStrategy(
        //     'payer',
        //     new \mmpsdk\Collection\Models\Payer()
        // );
    }
}
