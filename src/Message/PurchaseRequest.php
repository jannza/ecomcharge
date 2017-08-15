<?php

namespace Omnipay\Ecomcharge\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Ecomcharge\Message\PurchaseResponse;


class PurchaseRequest extends AbstractRequest
{
	public $liveEndpoint = 'https://checkout.ecomcharge.com/ctp/api/checkouts';
			
	public function getEndpoint() { return $this->liveEndpoint; }	
	
	public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }
    
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }
	
    public function getSuccessUrl()
    {
        return $this->getParameter('success_url');
    }
    
    public function setSuccessUrl($value)
    {
        return $this->setParameter('success_url', $value);
    }
    
    public function getDeclineUrl()
    {
        return $this->getParameter('decline_url');
    }
    
    public function setDeclineUrl($value)
    {
        return $this->setParameter('decline_url', $value);
    }
    
    public function getFailUrl()
    {
        return $this->getParameter('fail_url');
    }
    
    public function setFailUrl($value)
    {
        return $this->setParameter('fail_url', $value);
    }
    
    public function getNotificationUrl()
    {
        return $this->getParameter('notification_url');
    }
    
    public function setnotificationUrl($value)
    {
        return $this->setParameter('notification_url', $value);
    }
    
    public function getlanguage()
    {
        return $this->getParameter('language');
    }
    
    public function setLanguage($value)
    {
        $supported = array('en', 'es', 'tr', 'de', 'it', 'ru', 'zh', 'fr', 'da', 'sv', 'no', 'fi', 'pl');
        if(!in_array($value, $supported)){
            $value = 'en';
        }
        return $this->setParameter('language', $value);
    }
    
    public function getEmail()
    {
        return $this->getParameter('email');
    }
    
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getFirstname()
    {
        return $this->getParameter('first_name');
    }
    
    public function setFirstname($value)
    {
        return $this->setParameter('first_name', $value);
    }
    
    public function getLastname()
    {
        return $this->getParameter('last_name');
    }
    
    public function setLastname($value)
    {
        return $this->setParameter('last_name', $value);
    }
    
    public function getAddress()
    {
        return $this->getParameter('address');
    }
    
    public function setAddress($value)
    {
        return $this->setParameter('address', $value);
    }
    
    public function getCity()
    {
        return $this->getParameter('city');
    }
    
    public function setCity($value)
    {
        return $this->setParameter('city', $value);
    }
    
    public function getPhone()
    {
        return $this->getParameter('phone');
    }
    
    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }
    
    public function getCountry()
    {
        return $this->getParameter('country');
    }
    
    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }
    
    public function getZip()
    {
        return $this->getParameter('zip');
    }
    
    public function setZip($value)
    {
        return $this->setParameter('zip', $value);
    }
    
    public function getAmount()
    {
        return $this->getParameter('amount');
    }
    
    public function setAmount($value)
    {
        return $this->setParameter('amount', ($value * 100));
    }
    
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }
    
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }
    
    public function getDescription()
    {
        return $this->getParameter('description');
    }
    
    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }
    
    public function getTrackingId()
    {
        return $this->getParameter('tracking_id');
    }
    
    public function setTrackingId($value)
    {
        return $this->setParameter('tracking_id', $value);
    }
    
    public function getData()
    {
        $data = array
        (
            "checkout" => [
                "transaction_type" => "payment",
                "settings" => [
                    "success_url" => $this->getSuccessUrl(),
                    "decline_url" => $this->getDeclineUrl(),
                    "fail_url" => $this->getFailUrl(),
                    "notification_url" => $this->getNotificationUrl(),
                    "language" => $this->getlanguage(),
                ],
                "customer" => [
                    "email" => $this->getEmail(),
                    "first_name" => mb_substr($this->getFirstname(), 0, 30),
                    "last_name" => mb_substr($this->getLastname(), 0, 30),
                    "address" => $this->getAddress(),
                    "city" => $this->getCity(),
                    "phone" => $this->getPhone(),
                    "country" => $this->getCountry(),
                    "zip" => $this->getZip(),
                ],
                "order" => [
                    "amount" => $this->getAmount(),
                    "currency" => $this->getCurrency(),
                    "description" => $this->getDescription(),
                    "tracking_id" => $this->getTrackingId(),
                ]
            ]
        
        );
        
        return $data;
    }
    
    public function sendData($data)
    {
		try {
			$httpResponse = $this->httpClient->post(
				$this->getEndpoint(), 
				['Content-type' => 'application/json'],
				[]
			)->setBody(json_encode($data))->setAuth($this->getUsername(), $this->getPassword())->send();
			$answer = json_decode($httpResponse->getBody(), true);
			$returnURL = $answer['checkout']['redirect_url'];
		} catch (Exception $e) {
			error_log(__FILE__.'@'.__LINE__.': '.$e->getMessage());
			$returnURL = $data['checkout']['settings']['fail_url'];
		}
        return new PurchaseResponse($this, $data, $returnURL);
    }

}
