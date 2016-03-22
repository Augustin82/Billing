# UCS Billing Component

The UCS Billing Component provides an abstraction layer for representing advanced ordering and invoicing
capabilities in your web application. It allows modeling financial feeds and any kind of order creation.

## Installation

The component is available via composer with the following command:

    composer require ucs/billing

# Basic usage

## Implementing your own OrderManager

Even if the Billing Component comes with a pre-built OrderManager is has been made abstract because
of the difference of implementations. The OrderManager provides an abstraction layer for dealing with
specific data managers like Doctrine and Propel. If you intend to use the component directly, you will need
to create your own implementation:

    <?php

    namespace \Demo\Billing;

    use UCS\Component\Billing\Order\OrderManager as BasOrderManager;

    /**
     * Implementation of the OrderManager
     */
    class OrderManager extends BaseOrderManager
    {
        /**
         * {@inheritdoc}
         */
        public function deleteOrder(OrderInterface $order)
        {
            // Implement order deletion here
        }

        /**
         * {@inheritdoc}
         */
        public function findOrderBy(array $criteria)
        {
            // Implement the order retrival
        }

        /**
         * {@inheritdoc}
         */
        public function findOrders()
        {
            // Find all orders here
        }
    }

## Using the component

The component is based on the concept of "Order" which can contain "OrderItem"(s) and "Pricer"(s),
associated to specific "BilingInformation" and a given "OrderState". An Order represents the
whole data that can be billed and presented into an invoice. Orders are then manipulated by the
"OrderManager".

    <?php

    $order = new \UCS\Component\Billing\Order\Order();

    // add order items
    $item = new \UCS\Component\Billing\Order\OrderItem();
    $item->setUnitPrice(10.00)
        ->setQuantity(1)
        ->setReference('my_ref') // must be unique
        ->setTotalPrice(10);

    // add the items to the order
    $order->addItem($item);

    // create your own implementation of the OrderManager
    $orderManager = new \Demo\Billing\OrderManager();

    // computes the total order, including tax rates and promotions
    $orderManager->calculateOrderTotal($order);

## The role of pricers

A "Pricer" is a concept that can be associated to both an Order and an OrderItem. The Pricer handles
additional price modifiers included in the bill:

- VAT
- Total VAT
- Shipping Values
- Promotions/Reduction codes
- ...

It is a generic model that can represent all possible values that can change the total price of an Order
or an OrderItem.

Adding a Pricer to an Order or an OrderItem is quite simple:

    <?php

    $order = new \UCS\Component\Billing\Order\Order();

    // add order items
    $item = new \UCS\Component\Billing\Order\OrderItem();
    $item->setUnitPrice(10.00)
        ->setQuantity(1)
        ->setReference('my_ref'); // must be unique;

    $itemVat = new \UCS\Component\Billing\Pricer\Pricer();
    $itemVat->setSubject($item)
        ->setLabel('VAT on product')
        ->setDescription('VAT on product description')
        ->setAmount(20.0*$item->getTotalPrice()) // Credit
        ->setNeutral(false);

    // register the price to the item
    $item->addPricer($itemVat);

    // add the item to the order
    $order->addItem($item);

    $orderManager = new \UCS\Component\Billing\Order\OrderManager();

    // computes the total order, including tax rates and promotions
    $orderManager->calculateOrderTotal($order);

# Tests

## Running the test suite

You can run the unit tests with the following command:

    $ cd path/to/UCS/Component/Billing/
    $ composer install
    $ phpunit

Additional customization to running the phpunit test suite can be made by copying the phpunit.xml.dist
file and adding your own options.
