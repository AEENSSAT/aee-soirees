<?php

Class Config {

    private $id;
    private $textValue;
    private $booleanValue;

    public function __construct($id, $textValue, $booleanValue){
        $this->id           = $id;
        $this->textValue    = $textValue;
        $this->booleanValue = $booleanValue;
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
     * Get the value of Text Value
     *
     * @return mixed
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * Set the value of Text Value
     *
     * @param mixed textValue
     *
     * @return self
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;

        return $this;
    }

    /**
     * Get the value of Boolean Value
     *
     * @return mixed
     */
    public function getBooleanValue()
    {
        return $this->booleanValue;
    }

    /**
     * Set the value of Boolean Value
     *
     * @param mixed booleanValue
     *
     * @return self
     */
    public function setBooleanValue($booleanValue)
    {
        $this->booleanValue = $booleanValue;

        return $this;
    }

}
