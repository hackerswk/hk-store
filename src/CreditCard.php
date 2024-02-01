<?php
/**
 * Credit Card info class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\HkStore;

use \PDO as PDO;

class CreditCard
{
    /**
     * database
     *
     * @var object
     */
    private $database;

    /**
     * initialize
     */
    public function __construct($db = null)
    {
        $this->database = $db;
    }

    /**
     * Get credit card of payer.
     *
     * @param int $userId
     * @return array
     */
    public function getCreditCards($userId = null)
    {
        $sql = <<<EOF
            SELECT id, type, card_last_four FROM user_extra_creditcard
            WHERE user_id = :user_id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':user_id' => $userId,
        ]);

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        return [];
    }

    /**
     * Add credit card of payer.
     *
     * @param int $userId
     * @param int $default
     * @param string $tradeId
     * @param int $type
     * @param string $cardKey
     * @param string $cardToken
     * @param string $card_first_six
     * @param string $card_last_four
     * @param string $expireDate
     * @return bool
     */
    public function addCreditCard($userId, $default, $tradeId, $type, $cardKey, $cardToken, $card_first_six, $card_last_four, $expireDate)
    {
        $sql = <<<EOF
            INSERT INTO user_extra_creditcard
            SET user_id = :user_id,
            default_card = :default_card,
            rec_trade_id = :rec_trade_id,
            type = :type,
            card_key = :card_key,
            card_token = :card_token,
            card_first_six = :card_first_six,
            card_last_four = :card_last_four,
            expire_date = :expire_date
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':uesr_id' => $uesr_id,
            ':default_card' => $default,
            ':rec_trade_id' => $tradeId,
            ':type' => $type,
            ':card_key' => $cardKey,
            ':card_token' => $cardToken,
            ':card_first_six' => $card_first_six,
            ':card_last_four' => $card_last_four,
            ':expire_date' => $expireDate,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Setup credit card by default.
     *
     * @param int $cardId
     * @return bool
     */
    public function setDefaultCreditCard($cardId)
    {
        $sql = <<<EOF
            UPDATE user_extra_creditcard
            SET default_card = 1
            WHERE id = :cardId
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':cardId' => $cardId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Initial default card of all credit card.
     *
     * @param int $uesrId
     * @return bool
     */
    public function initCreditCards($uesrId)
    {
        $sql = <<<EOF
            UPDATE user_extra_creditcard
            SET default_card = 0
            WHERE user_id = :user_id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':user_id' => $uesrId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Remove credit card.
     *
     * @param int $cardId
     * @return bool
     */
    public function removeCreditCard($cardId)
    {
        $sql = <<<EOF
            DELETE FROM user_extra_creditcard
            WHERE id = :id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':id' => $cardId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
