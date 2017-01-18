<?php

class Authentication extends API {

    public function __construct($request) {
        parent::__construct($request);

        $this->routes = array(
            'GET' => array(
                $this->regex_endpoint() => 'renew',
                '/\/authentication\/logout\/?/' => 'logout'
            ),
            'POST' => array(
                $this->regex_endpoint() => 'login'
            ),
            "DELETE" => array(
                $this->regex_endpoint() => 'logout'
            )
        );
    }

    /**
     * Se um token valido for passado, ou o usuário possuir sessao valida
     * então a sessao é renovada e um novo token valid é criado.
     * */
    public function renew () {
        try {
            if (isset($_SESSION['username']) && isset($_SESSION['expiration']) && $_SESSION['expiration'] > time()) {
                $_SESSION['expiration'] = time() + Sky::instance()->config()['token_expiration'];

                $token = array(
                    'username' => $_SESSION['username'],
                    'expiration' => $_SESSION['expiration']
                );
                $token = JWT::encode($token, Sky::instance()->config()['secret_key']);

                return array('token' => $token);
            }

            if (isset($this->request['headers']['Authorization'])) {
                $token = $this->request['headers']['Authorization'];
                $token = JWT::decode($token, Sky::instance()->config()['secret_key']);

                if (isset($token->username) && isset($token->expiration) && $token->expiration > time()) {
                    $token = array(
                        'username' => $token->username,
                        'expiration' => time() + Sky::instance()->config()['token_expiration']
                    );
                    $token = JWT::encode($token, Sky::instance()->config()['secret_key']);

                    return array('token' => $token);
                }
            }
        } catch (Exception $e) {
        }

        return array('token' => 'invalid');
    }

    /**
     * Login sem criacao de sessao. Apenas gera um token valido se usuario for autenticado
     * */
    public function login () {
        Session::instance()->start();

        $token = '';
        $username = '';
        $password = '';

        if (isset($this->request['BODY_JSON']) && isset($this->request['BODY_JSON']['username'])) {
            $username = $this->request['BODY_JSON']['username'];
        }

        if (isset($this->request['BODY_JSON']) && isset($this->request['BODY_JSON']['password'])) {
            $password = $this->request['BODY_JSON']['password'];
        }

        if ($username == 'callebe' && $password == '123') {
            $token = array(
                'username' => 'callebe',
                'expiration' => time() + Sky::instance()->config()['token_expiration']
            );
            $token = JWT::encode($token, Sky::instance()->config()['secret_key']);

            return array('token' => $token);
        } 

        return array('token' => 'invalid');
    }

    public function logout () {
        Session::instance()->destroy();

        return "";
    }
}