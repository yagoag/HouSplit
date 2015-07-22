<?php
namespace HouSplit;

class Member {
    private $connection;
    private $username;
    private $name;
    private $balance;
    private $admin;
    private $information_timeout = 600;
    private $information_time;

    /**
     * Update member's information from the information of the database.
     *
     * @throws \ErrorException when the member is not active
     */
    private function update_from_database() {
        $member_info = $this->connection->query('SELECT name, balance, active, admin FROM members '.
                                                'WHERE username = $this->username');
        $member_info = $member_info->fetch_array();
        $this->name = $member_info['name'];
        $this->balance = $member_info['balance'];
        $this->admin = $member_info['admin'];
        $this->information_time = time();
        if (!$member_info['active'])
            throw new \ErrorException('Member is not active.');
    }

    /**
     * Verify if the Member's information has timed out and, if so, retrieves fresh information
     * from the database.
     *
     * @throws \ErrorException when the member is not active
     */
    private function validate_information() {
        if (time() > $this->information_time + $this->information_timeout)
            $this->update_from_database();
    }

    /**
     * Add new member to the database.
     *
     * @param $username
     * @param $name
     * @param $admin
     */
    private function add_to_database($username, $name, $admin) {
        $query = $this->connection->prepare('INSERT INTO members VALUES (?, ?, ?) '.
                                            'AS (username, name, admin)');
        $query->bind_param('ssi', $username, $name, $admin);
        $query->execute();
    }

    /**
     * @param $connection
     * @param $username
     * @param null $name
     * @param null $admin
     * @param bool|false $new_member
     *   If true, the member will be added to the database
     *
     * @throws \ErrorException when the member is not active
     */
    public function __construct($connection, $username, $name = null, $admin = null,
                                $new_member = false) {
        $this->connection = $connection;
        $this->username = $username;
        if ($new_member)
            $this->add_to_database($username, $name, $admin);
        $this->update_from_database();
    }

    /**
     * Set the timeout for the member's information gotten from database
     *
     * @param $timeout
     */
    public function set_information_timeout($timeout) {
        $this->information_timeout = $timeout;
    }

    /**
     * Verify whether current member is active.
     *
     * @param bool|false $force_update
     * @return bool
     */
    public function is_active($force_update = false) {
        try {
            if ($force_update)
                $this->update_from_database();
            else
                $this->validate_information();
        } catch (\ErrorException $e) {
            return false;
        }

        return true;
    }

    /**
     * Verify whether the current member is an admin.
     *
     * @param bool|false $force_update
     * @return boolean
     * @throws \ErrorException when the member is not active
     */
    public function is_admin($force_update = false) {
        if ($force_update)
            $this->update_from_database();
        else
            $this->validate_information();

        return $this->admin;
    }

    /**
     * Get a table with the balance of all the members
     *
     * @param \mysqli $connection
     *  Connection to be used to get the data. If not set, will create one based on config.php
     *
     * @return string
     *  Content of the balance table
     */
    public static function balance_table($connection) {
        $members = $connection->query('SELECT name, balance FROM members WHERE 1=1');

        $table = '<table class="table">';
        while ($member = $members->fetch_array()) {
            $table .= '<tr>';
            $table .= '<td>'.$member['name'].'</td>';
            $table .= '<td>'.$member['balance'].'</td>';
            $table .= '</tr>';
        }
        $table .= '</table>';

        return $table;
    }

    public static function update_active_status($connection, $member, $status) {

    }
}
?>