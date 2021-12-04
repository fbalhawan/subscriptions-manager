<?php

namespace Controller;

use Output\Response;
use Model\Merchant;
use \Firebase\JWT\JWT;

class MerchantController extends \Prefab
{
    
    /**
     * get
     *
     * @param  mixed $f3
     * @return void
     */
    public function get($f3)
    {
        $merchants = \Model\Merchant::getAll();
        $response = new Response(Response::$SUCCESS["code"],Response::$SUCCESS["title"],["merchants"=>$merchants]);
        echo $response->getJsonResponse();
        return;
    }
    
    /**
     * createDummyMerchant
     *
     * @param  mixed $f3
     * @return void
     */
    public function createDummyMerchant($f3)
    {
        $faker = \Faker\Factory::create();
        $email = $faker->email();
        $name = $faker->name();
        $password = $faker->password(6, 12);
        $merchant = new Merchant(null, $name, $email, $password);
        $merchant->createRecord();

        $response = new Response(
            Response::$SUCCESS["code"],
            Response::$SUCCESS["title"],
            array(
                "merchant" => $merchant->getRecord(),
                "plain_password" => $password,
                "message"  => "There aren't any password retrieval function yet, make sure to save this password somewhere."
            )
        );
        echo $response->getJsonResponse();
    }
    
    /**
     * login as a merchant
     *
     * @param  mixed $f3
     * @return JWT
     */
    public function login($f3, $params)
    {
        $response = new Response();
        $body = $f3->get("POST");
        $email = $body["email"];
        $password = md5($body["password"]);

        $login_success = Merchant::authenticate($email, $password);
        if ($login_success) {
            $db = \Base::instance()->get('DB');
            $merchant = $db->exec('SELECT * FROM Merchants WHERE email = "'.$email.'"');
            $nextMonth = time() + (30 * 24 * 60 * 60);
            $payLoad = array(
                "iss" => "localhost",
                "exp" => $nextMonth,
                "sub" => "SimpleAuth",
                "aud" => "Admin",
                "nbf" => time(),
                "iat" => time(),
                "email" => $email,
                "id" => $merchant[0]["id"]
                // "jti",
                // "subscriptionId",
                // "msisdn",
                // "action"
            );
            $token = JWT::encode($payLoad, $f3->get('JWT.secret'), 'HS256');

            $response->setResponse(Response::$SUCCESS["code"], Response::$SUCCESS["title"], array('token' => $token));
        } else {
            $response->setResponse(Response::$UNAUTHORIZED["code"], Response::$UNAUTHORIZED["title"], array('message' => "Authentication failed"));
        }

        echo $response->getJsonResponse();
    }
}
