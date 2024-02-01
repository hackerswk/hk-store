<?php
/**
 * Payer info class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\HkStore;

use \PDO as PDO;

class Payer
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
     * Get infomation of payer.
     *
     * @param int $payerId
     * @return array
     */
    public function getPayer($payerId = null)
    {
        $sql = <<<EOF
            SELECT * FROM user_extra_payer
            WHERE id = :id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        return [];
    }

    /**
     * Get infomation list of payer.
     *
     * @param int $userId
     * @return array
     */
    public function getPayers($userId = null)
    {
        $sql = <<<EOF
            SELECT * FROM user_extra_payer
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
     * Add payer.
     *
     * @param int $userId
     * @param string $name
     * @param string $billing_address
     * @param int $mobile
     * @param int $phone_office
     * @param int $phone_home
     * @param int $default
     * @return bool
     */
    public function addPayer($userId, $name, $billing_address, $mobile, $phone_office, $phone_home, $default)
    {
        $sql = <<<EOF
            INSERT INTO user_extra_payer
            SET user_id = :user_id,
            name = :name,
            billing_address = :billing_address,
            mobile = :mobile,
            phone_office = :phone_office,
            phone_home = :phone_home,
            default = :default
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':user_id' => $userId,
            ':name' => $name,
            ':billing_address' => $billing_address,
            ':mobile' => $mobile,
            ':phone_office' => $phone_office,
            ':phone_home' => $phone_home,
            ':default' => $default,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Setup payer by default.
     *
     * @param int $payerId
     * @return bool
     */
    public function setDefaultPayer($payerId)
    {
        $sql = <<<EOF
            UPDATE user_extra_payer
            SET set_default = 1
            WHERE id = :id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Initial default of payer.
     *
     * @param int $uesrId
     * @return bool
     */
    public function initPayers($uesrId)
    {
        $sql = <<<EOF
            UPDATE user_extra_payer
            SET set_default = 0
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
     * Remove payer.
     *
     * @param int $payerId
     * @return bool
     */
    public function removePayer($payerId)
    {
        $sql = <<<EOF
            DELETE FROM user_extra_payer
            WHERE id = :id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Get invoice.
     *
     * @param int $payerId
     * @return array
     */
    public function getInvoice($payerId = null)
    {
        $sql = <<<EOF
            SELECT * FROM user_extra_payer_invoice
            WHERE payer_id = :payer_id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':payer_id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        return [];
    }

    /**
     * Add invoice.
     *
     * @param int $payerId
     * @param int $type
     * @param string $title
     * @param string $uniformNo
     * @param string $carrierBarcode
     * @return bool
     */
    public function addInvoice($payerId, $type, $title, $uniformNo, $carrierBarcode)
    {
        $sql = <<<EOF
            INSERT INTO user_extra_payer_invoice
            SET payer_id = :payer_id,
            type = :type,
            title = :title,
            uniform_no = :uniform_no,
            carrier_barcode = :carrier_barcode,
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':payer_id' => $payerId,
            ':type' => $type,
            ':title' => $title,
            ':uniform_no' => $uniformNo,
            ':carrier_barcode' => $carrierBarcode,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Update invoice.
     *
     * @param int $payerId
     * @param int $type
     * @param string $title
     * @param string $uniformNo
     * @param string $carrierBarcode
     * @return bool
     */
    public function updateInvoice($payerId, $type, $title, $uniformNo, $carrierBarcode)
    {
        $sql = <<<EOF
            UPDATE user_extra_payer_invoice
            SET type = :type,
            title = :title,
            uniform_no = :uniform_no,
            carrier_barcode = :carrier_barcode,
            WHERE payer_id = :payer_id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':payer_id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Remove invoice of payer.
     *
     * @param int $payerId
     * @return bool
     */
    public function removeInvoice($payerId)
    {
        $sql = <<<EOF
            DELETE FROM user_extra_payer_invoice
            WHERE payer_id = :payer_id
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':payer_id' => $payerId,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
