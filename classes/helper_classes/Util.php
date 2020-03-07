<?php
class Util
{
    private $di;
    private static $baseUrl;

    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        self::$baseUrl = $this->di->get('config')->get('base_url');
    }

    public static function dd($var = "") {
        die(var_dump($var));
    }

    public static function redirect($filepath) {
        // echo "($this->di->get('config')->get('base_url') . "views/pages/$filepath)";
        // header('Location: ' . ($this->di->get('config')->get('base_url') . "views/pages/$filepath"));
        header('Location: ' . (self::$baseUrl) . "views/pages/$filepath");
    }

    // CSRF = Cross Site Request Forgery
    public static function createCSRFToken() {
        Session::setSession('csrf_token', uniqid().rand());
        Session::setSession('token_expire', time()+3600);
    }

    public static function verifyCSRFToken($data) {

        // Util::dd( [
        //     $data, 
        //     isset($data['csrf_token']),
        //     $data['csrf_token'] == Session::getSession('csrf_token'),
        //     Session::getSession('token_expire') > time()
        //     ]);

        return (
            isset($data['csrf_token']) 
                && 
            Session::getSession('csrf_token') != null 
                && 
            $data['csrf_token'] == Session::getSession('csrf_token') 
                && 
            Session::getSession('token_expire') > time()
        );
    }
}
?>