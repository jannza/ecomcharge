<?php

namespace Omnipay\Ecomcharge;

use Omnipay\Common\AbstractGateway;

/**
 * Ecomcharge Gateway
 *
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Ecomcharge';
    }
    
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
    

    /**
     * @param array $parameters
     * @return \Omnipay\Ecomcharge\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Ecomcharge\Message\PurchaseRequest', $parameters);
    }

}
