<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey (nicolas.macherey@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace UCS\Component\Billing\Order\Exception;

/**
 * OrderCoreException is the base class for all Billing Order Component 
 * exceptions
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class OrderCoreException extends \RuntimeException implements \Serializable
{
    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->code,
            $this->message,
            $this->file,
            $this->line,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($str)
    {
        list(
            $this->code,
            $this->message,
            $this->file,
            $this->line
        ) = unserialize($str);
    }

    /**
     * Message key to be used by the translation component.
     *
     * @return string
     */
    public function getMessageKey()
    {
        return 'An order core exception occurred.';
    }

    /**
     * Message data to be used by the translation component.
     *
     * @return array
     */
    public function getMessageData()
    {
        return array();
    }
}
