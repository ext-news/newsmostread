<?php

class Tx_Newsmostread_Domain_Model_News extends \GeorgRinger\News\Domain\Model\News {

    /** @var integer */
    protected $txNewsmostreadCount;

    /** @var integer */
    protected $txNewsmostreadEnabled;

    /**
     * @param int $txNewsmostreadCount
     */
    public function setTxNewsmostreadCount($txNewsmostreadCount)
    {
        $this->txNewsmostreadCount = $txNewsmostreadCount;
    }

    /**
     * @return int
     */
    public function getTxNewsmostreadCount()
    {
        return $this->txNewsmostreadCount;
    }

    /**
     * @param int $txNewsmostreadEnabled
     */
    public function setTxNewsmostreadEnabled($txNewsmostreadEnabled)
    {
        $this->txNewsmostreadEnabled = $txNewsmostreadEnabled;
    }

    /**
     * @return int
     */
    public function getTxNewsmostreadEnabled()
    {
        return $this->txNewsmostreadEnabled;
    }

    /**
     * @return int
     */
    public function getMostReadCounter()
    {
        return $this->getTxNewsmostreadCount();
    }

}

?>