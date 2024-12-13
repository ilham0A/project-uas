<?php
class Auth_model
{
    private $table = 'mahasiswa';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUser($username, $password)
    {
        $this->db->query("SELECT * FROM login WHERE user = :username AND pass = :password");
        $this->db->bind('username', $username);
        $this->db->bind('password', $password);
        return $this->db->resultSet();
    }
}
