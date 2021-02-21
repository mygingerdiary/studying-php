<?php

include_once 'Connection.php';

class User
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function close()
    {
        $this->db = null;
    }

    public function login($user_login, $user_password)
    {
        try {
            $sql = "SELECT * FROM dane_logowania WHERE login=:user_login"; //login=?

            $query = $this->db->prepare($sql);

            $query->bindParam(":user_login", $user_login); // bindParam(1, $user_login)

            $query->execute();

            $returned_row = $query->fetch(PDO::FETCH_ASSOC);


            if ($query->rowCount() == 1)
                if (password_verify($user_password, $returned_row['haslo']))
                {

                    $_SESSION['user_session'] = $returned_row['id'];

                    return true;
                }
                else
                {
                    return false;
                }
        } catch (PDOException $e)
        {
            echo 'Wystąpił błąd: ' . $e->getMessage();
        }
    }

    public function is_logged_in() {
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function log_out()
    {
        session_destroy();

        unset($_SESSION['user_session']);

        $this->close();

        return true;
    }
}