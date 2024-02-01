<?php
/**
 * Action history class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\HkStore;

use \PDO as PDO;

class ActionHistory
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
     * Get action history of account.
     *
     * @param int $userId
     * @return array
     */
    public function getActionHistory($userId = null)
    {
        $sql = <<<EOF
            SELECT * FROM user_action_history
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
     * Add action history.
     *
     * @param int $userId
     * @param string $action
     * @return bool
     */
    public function addActionHistory($userId, $action)
    {
        $sql = <<<EOF
            INSERT INTO user_action_history
            SET user_id = :uesr_id,
            action = :action
EOF;
        $query = $this->database->prepare($sql);
        $query->execute([
            ':uesr_id' => $uesrId,
            ':action' => $action,
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}