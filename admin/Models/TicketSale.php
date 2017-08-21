<?php

Class TicketSale {

    private $timestamp;
    private $quantity;
    private $ticketPrice;
    private $price;

    public function __construct($timestamp, $quantity, $ticketPrice, $price) {
        $this->timestamp   = $timestamp;
        $this->quantity    = $quantity;
        $this->ticketPrice = $ticketPrice;
        $this->price       = $price;
    }

    /**
     * Get the value of Timestamp
     *
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set the value of Timestamp
     *
     * @param mixed timestamp
     *
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get the value of Quantity
     *
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of Quantity
     *
     * @param mixed quantity
     *
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of Ticket Price
     *
     * @return mixed
     */
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }

    /**
     * Set the value of Ticket Price
     *
     * @param mixed ticketPrice
     *
     * @return self
     */
    public function setTicketPrice($ticketPrice)
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    /**
     * Get the value of Price
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of Price
     *
     * @param mixed price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

}
