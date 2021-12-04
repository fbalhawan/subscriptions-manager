<?php

namespace Model;

class Merchant extends \DB\SQL\Mapper
{
    private
        $id,
        $name,
        $email,
        $password;

    public function __construct($id = null, $name = "", $email = "", $password = "")
    {
        parent::__construct(\Base::instance()->get('DB'), 'Merchants');
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = md5($password);
    }

    public function createRecord()
    {
        $db_mapper = new parent(\Base::instance()->get('DB'), 'Merchants');
        $db_mapper->id = $this->id;
        $db_mapper->name = $this->name;
        $db_mapper->email = $this->email;
        $db_mapper->password = $this->password;

        $merchant = $db_mapper->save();
        $this->id = $merchant->id;
    }

    public function getRecord()
    {
        return [
            "id"        => $this->id,
            "name"      => $this->name,
            "email"     => $this->email,
            "password"  => $this->password
        ];
    }

    public static function getAll()
    {
        $db = \Base::instance()->get('DB');
        $merchants = $db->exec('SELECT * FROM Merchants');
        return $merchants;
    }

    /**
     * authenticate
     *
     * @param  string $email
     * @param  string $password
     * @return bool
     */
    public static function authenticate($email, $password)
    {
        $db_mapper = new parent(\Base::instance()->get('DB'), 'Merchants');
        $auth = new \Auth($db_mapper, array('id' => 'email', 'pw' => 'password'));
        $login_success = $auth->login($email, $password);
        return $login_success;
    }
}
