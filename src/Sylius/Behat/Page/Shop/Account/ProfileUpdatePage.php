<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Behat\Page\Shop\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\Page\SymfonyPage;

/**
 * @author Grzegorz Sadowski <grzegorz.sadowksi@lakion.com>
 */
class ProfileUpdatePage extends SymfonyPage implements ProfileUpdatePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'sylius_shop_account_profile_update';
    }

    /**
     * {@inheritdoc}
     */
    public function specifyFirstName($firstName)
    {
        $this->getDocument()->fillField('First name', $firstName);
    }

    /**
     * {@inheritdoc}
     */
    public function specifyLastName($lastName)
    {
        $this->getDocument()->fillField('Last name', $lastName);
    }

    /**
     * {@inheritdoc}
     */
    public function specifyEmail($email)
    {
        $this->getDocument()->fillField('Email', $email);
    }

    /**
     * {@inheritdoc}
     */
    public function saveChanges()
    {
        $this->getDocument()->pressButton('Save changes');
    }

    /**
     * {@inheritdoc}
     */
    public function checkValidationMessageFor($element, $message)
    {
        $foundedElement = $this->getFieldElement($element);
        if (null === $foundedElement) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.pointing');
        }

        return $message === $foundedElement->find('css', '.form-error')->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'first name' => '#sylius_customer_profile_firstName',
            'last name' => '#sylius_customer_profile_lastName',
            'email' => '#sylius_customer_profile_email',
        ]);
    }

    /**
     * @param string $element
     *
     * @return \Behat\Mink\Element\NodeElement|null
     *
     * @throws ElementNotFoundException
     */
    private function getFieldElement($element)
    {
        $element = $this->getElement($element);
        while (null !== $element && !($element->hasClass('field'))) {
            $element = $element->getParent();
        }

        return $element;
    }
}
