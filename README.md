# Billing Component

UCS Billing component provides an abstraction layer for representing advanced ordering and invoicing
capabilities in your web application. It allows to model financial feeds and any kind of orders
creation.

# Installing the component

The component can be installed via composer by executing the following command:

    composer require ucs/billing

# Basic usage

## Implement your own OrderManager

Even if the billing component comes with a pre-built order manager is has been made abstract because
of the difference of implementations. The order manager provides an abstraction layer for dealing with
specific data managers like Doctrine and Propel. If you intend to use the component directly you have
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
            // Implement the order deletion here
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

## Use the component

The component is based on a concept "Order" which can contain "OrderItem"(s) and "Pricer"(s) and
associated to specific "BilingInformation" and a given state "OrderState". An Order represents the
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

    // add the item to the order
    $order->addItem($item);

    // Create the order manager, you have to create your own implementation
    $orderManager = new \Demo\Billing\OrderManager();

    // Computes the total order data including tax rates and promotions
    $orderManager->calculateOrderTotal($order);

## The role of pricers

A "Pricer" is a concept that can be both associated to an Order and to an OrderItem. The pricer handles
additional price modifiers included in the bill:

- VAT
- Total VAT
- Shipping Values
- Promotions/Reduction codes
- ...

It is a generic model that can represent all possible values that can change the total price of an Order
or an OrderItem.

Adding a pricer to an order or an order item is quite simple:

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

    // Finally register into the item
    $item->addPricer($itemVat);

    // Add the item to the order
    $order->addItem($item);

    $orderManager = new \UCS\Component\Billing\Order\OrderManager();

    // Computes the total order data including tax rates and promotions
    $orderManager->calculateOrderTotal($order);

# Running the test suite

You can run the unit tests with the following command:

    $ cd path/to/UCS/Component/Billing/
    $ composer install
    $ phpunit

Additional customization to running the phpunit test suite can be made by copying the phpunit.xml.dist
file and adding your own options.
