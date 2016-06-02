<?php namespace Academe\SagePay\Psr7\PaymentMethod;

/**
 * Card object to be passed to SagePay for payment of a transaction.
 * Reasonable validation is done at creation.
 * A card in the copntext of this API is a temporary ID generated by SagePay
 * in response to card details being POSTed direct to the API.
 * The transaction does not take the full card details, as would be the case
 * for SagePay Direct.
 * The card identifier lasts for 400 seconds from creation.
 */

use Academe\SagePay\Psr7\Response\CardIdentifier;
use Academe\SagePay\Psr7\Response\SessionKey;

class Card implements PaymentMethodInterface
{
    protected $sessionKey;
    protected $cardIdentifier;

    /**
     * Card constructor.
     * @param SessionKey $sessionKey
     * @param CardIdentifier $cardIdentifier
     */
    public function __construct(SessionKey $sessionKey, CardIdentifier $cardIdentifier)
    {
        $this->cardIdentifier = $cardIdentifier;
        $this->sessionKey = $sessionKey;
    }

    /**
     * Return the body partial for message construction.
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'card' => array(
                'merchantSessionKey' => $this->sessionKey->getMerchantSessionKey(),
                'cardIdentifier' => $this->cardIdentifier->getCardIdentifier(),
            ),
        );
    }
}
