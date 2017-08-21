<?php

Class Drink {
    private $id;
    private $name;
    private $currentPrice;
    private $previousPrice;
    private $history;
    private $isEnable;
    private $salesCount;
    private $estimatedRevenue;

    public function __construct($id, $name, $currentPrice, $previousPrice, $history, $isEnable, $salesCount, $estimatedRevenue){
        $this->id               = $id;
        $this->name             = $name;
        $this->currentPrice     = $currentPrice;
        $this->previousPrice    = $previousPrice;
        $this->history          = $history;
        $this->isEnable         = $isEnable;
        $this->salesCount       = $salesCount;
        $this->estimatedRevenue = $estimatedRevenue;
    }


    public function toJSON(){
        $arr                  = [];
        $arr["id"]            = $this->id;
        $arr["name"]          = $this->name;
        $arr["currentPrice"]  = $this->currentPrice;
        $arr["previousPrice"] = $this->previousPrice;
        $arr["history"]       = $this->history;
        $arr["isEnable"]      = $this->isEnable;

        return json_encode($arr);
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Current Price
     *
     * @return mixed
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * Set the value of Current Price
     *
     * @param mixed currentPrice
     *
     * @return self
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    /**
     * Get the value of Previous Price
     *
     * @return mixed
     */
    public function getPreviousPrice()
    {
        return $this->previousPrice;
    }

    /**
     * Set the value of Previous Price
     *
     * @param mixed previousPrice
     *
     * @return self
     */
    public function setPreviousPrice($previousPrice)
    {
        $this->previousPrice = $previousPrice;

        return $this;
    }

    /**
     * Get the value of History
     *
     * @return mixed
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set the value of History
     *
     * @param mixed history
     *
     * @return self
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get the value of Is Enable
     *
     * @return mixed
     */
    public function isEnable()
    {
        return $this->isEnable;
    }

    /**
     * Set the value of Is Enable
     *
     * @param mixed isEnable
     *
     * @return self
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get the value of Sales Count
     *
     * @return mixed
     */
    public function getSalesCount()
    {
        return $this->salesCount;
    }

    /**
     * Set the value of Sales Count
     *
     * @param mixed salesCount
     *
     * @return self
     */
    public function setSalesCount($salesCount)
    {
        $this->salesCount = $salesCount;

        return $this;
    }

    /**
     * Get the value of Estimated Revenue
     *
     * @return mixed
     */
    public function getEstimatedRevenue()
    {
        return $this->estimatedRevenue;
    }

    /**
     * Set the value of Estimated Revenue
     *
     * @param mixed estimatedRevenue
     *
     * @return self
     */
    public function setEstimatedRevenue($estimatedRevenue)
    {
        $this->estimatedRevenue = $estimatedRevenue;

        return $this;
    }

}
