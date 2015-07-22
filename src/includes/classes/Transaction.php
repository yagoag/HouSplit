<?php
namespace HouSplit;

class Transaction {
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
        return in_array($type, Payment::$types);
    }

    /**
     * @param $type
     * @param $description
     * @param $value
     * @param $payer
     * @param $participants
     */
    public function __construct($type, $description, $value, $payer, $participants) {
        if ($this->is_valid_type($type))
            $this->type = $type;
        $this->description = $description;
        $this->value = str_replace(',', '.', $value);
        $this->payer = $payer;
        if (!in_array($payer, $participants))
            $participants[] = $payer;
        $this->participants = $participants;
    }

    public function add_to_database() {
        $query = $this->connection->prepare('INSERT INTO transactions (name, payer, date, type, '.
                                            'value) VALUES (?, ?, now(), ?, ?)');
        $query->bind_param('sisd', $this->description, $this->payer, $this->type, $this->value);
        $query->execute();

        $transaction = $this->connection->query('SELECT MAX(id) AS transaction_id FROM transactions');
        $transaction = $transaction->fetch_assoc()['transaction_id'];

        if ($this->type == 'Bill')
            $portion_value = round($this->value / count($this->participants), 2);
        else
            $portion_value = $this->value;

        $new_portion = $this->connection->prepare('INSERT INTO portions (memberID, transactionID, '.
                                                  'value) VALUES (?, ?, ?)');
        $new_portion->bind_param('iid', $member, $transaction, $value);
        $update_balance = $this->connection->prepare('UPDATE members SET balance = balance + ? '.
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

        echo '<div class="title">' . $lang['success'] . '</div>';
        echo $lang['msg_bill_added'];
    }
}
?>