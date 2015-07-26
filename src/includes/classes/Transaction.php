<?php
namespace HouSplit;
require_once 'Message.php';
require_once 'Connection.php';

class Transaction {
    private $connection;
    private $type;
    private $description;
    private $value;
    private $payer;
    private $participants;
    private static $types = ['Bill', 'Loan', 'Payment'];

    /**
     * Verify whether a type is in the set of valid types.
     *
     * @param $type
     * @return bool
     */
    private function is_valid_type($type) {
        return in_array($type, Transaction::$types);
    }

    /**
     * Add new transaction into database and
     */
    private function add_to_database() {
        $query = $this->connection->prepare('INSERT INTO transactions (name, payer, date, type, ' .
            'value) VALUES (?, ?, now(), ?, ?)');
        $query->bind_param('sisd', $this->description, $this->payer, $this->type, $this->value);
        $query->execute();

        $transaction = $this->connection->query('SELECT MAX(id) AS transaction_id FROM transactions');
        $transaction = $transaction->fetch_assoc()['transaction_id'];

        if ($this->type == 'Bill')
            $portion_value = round($this->value / count($this->participants), 2);
        else
            $portion_value = $this->value;

        $new_portion = $this->connection->prepare('INSERT INTO portions (memberID, transactionID, ' .
            'value) VALUES (?, ?, ?)');
        $new_portion->bind_param('iid', $member, $transaction, $value);
        $update_balance = $this->connection->prepare('UPDATE members SET balance = balance + ? ' .
            'WHERE id = ?');
        $update_balance->bind_param('di', $value, $member);
        foreach ($this->participants as $member) {
            if ($member == $this->payer)
                $value = $portion_value * (count($this->participants) - 1);
            else
                $value = -$portion_value;
            $new_portion->execute();
            $update_balance->execute();
        }

        $this->id = $transaction;

        return new Message($lang['success'], $lang['msg_bill_added']);
    }

    private function get_from_database($id) {
        throw new \ErrorException('Transaction.get_from_database() is not implemented yet.');
    }

    /**
     * @param $type
     * @param $description
     * @param $value
     * @param $payer
     * @param $participants
     */
    public function __construct($connection = null, $id = null, $type = null, $description = null,
                                $value = null, $payer = null, $participants = null) {
        if ($id == null && $type = null)
            throw new \ErrorException("Either the ID or all other fields of Transaction's " .
                                      "construction should have a value.");

        if ($connection)
            $this->connection = $connection;
        else
            $this->connection = new Connection();

        if ($id == null) {
            if ($this->is_valid_type($type))
                $this->type = $type;
            $this->description = $description;
            $this->value = str_replace(',', '.', $value);
            $this->payer = $payer;
            if (!in_array($payer, $participants))
                $participants[] = $payer;
            $this->participants = $participants;
            $this->add_to_database();
        } else {
            $this->get_from_database($id);
        }
    }
}
?>