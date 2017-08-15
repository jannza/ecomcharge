<?php
namespace Omnipay\Ecomcharge\Message;

use Omnipay\Common\Message\AbstractResponse;

class StatusCallback extends AbstractResponse
{
    
    const STATUS_SUCCESSFUL = 'successful';

    /**
     * Construct a StatusCallback with the respective POST data.
     *
     * @param array $post post data
     */
    public function __construct(array $post)
    {
        $this->data = $post;
    }

    public function isSuccessful()
    {
        return  ($this->getStatus() == self::STATUS_SUCCESSFUL);
    }

    public function getStatus()
    {
        return mb_strtolower($this->data['transaction']['status']);
    }
    
    public function getMessage()
    {
        return $this->data['transaction']['message'];
    }

    public function getIssuerName()
    {
        return $this->data['transaction']['credit_card']['issuer_name'];
    }

    public function getIssuerCountry()
    {
        return $this->data['transaction']['credit_card']['issuer_country'];
    }

    public function getCardMask()
    {
        return $this->data['transaction']['credit_card']['first_1'].'...'.$this->data['transaction']['credit_card']['last_4'];
    }

    public function getCardHolder()
    {
        return $this->data['transaction']['credit_card']['holder'];
    }

}
