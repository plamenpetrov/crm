<?php

namespace App\Models\Login\Repositories\User;

use \App\Models\Login\Repositories\BaseLoginRepository;
use App\Models\Login\Repositories\User\UserLoginRepositoryInterface as UserLoginRepositoryInterface;
use App\Models\Api\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;
use App\Services\Facades\DBConnectionFacade as DBConnection;

class UserLoginRepository extends BaseLoginRepository implements UserLoginRepositoryInterface {

    const active = 1;

    public $model;
    protected $username;
    protected $password;

    public function __construct(User $model) {
        $this->model = $model;
        parent::__construct();
    }

    public function getActiveState() {
        return self::active;
    }

    protected function setCredntials($credentials) {
        $this->username = $credentials['email'];
        $this->password = $credentials['password'];

        return true;
    }

    public function findUserByEmail($credentials) {
        $user = User::where('email', $credentials['email'])
                ->where('active', self::active)
                ->first();

        if (!$user)
            return false;

        $validCredentials = \Hash::check($credentials['password'], $user->getAuthPassword());

        if (!$validCredentials) {
            return false;
        }

        //$user->id - that is why user in login db must be with same id as client db
        $query = \DB::table('client_users_rel as cur')
                ->select('c.client_key')
                ->join('clients as c', 'c.id', '=', 'cur.client_id')
                ->where('cur.user_id', '=', $user->id)
                ->first();

        if (!isset($query->client_key))
            return false;

        $configConnection = \Config::get('clients.' . $query->client_key . '.database');
        
        \Config::set('database.connections.app.driver', $configConnection['driver']);
        \Config::set('database.connections.app.database', $configConnection['database']);
        \Config::set('database.connections.app.host', $configConnection['host']);
        \Config::set('database.connections.app.username', $configConnection['username']);
        \Config::set('database.connections.app.password', $configConnection['password']);
        \Config::set('database.connections.app.charset', $configConnection['charset']);
        \Config::set('database.connections.app.collation', $configConnection['collation']);
        \Config::set('database.default', 'app');

        //use session to send data to User::getJWTCustomClaims
        \Session::put('clientKey', $configConnection['database']);

        if (!$token = \auth()->attempt($credentials)) {
            return false;
        }

        \App::setLocale(\Config::get('clients.' . $query->client_key . '.language'));
        \LangDir::setLanguageNamespace($query->client_key);
//        \Lang::addNamespace('languages', app_path() . '/../resources/lang/' . $query->client_key);

        return $token;
    }

    /**
     * The user has been authenticated.
     * @return boolean
     */
    protected function authenticated() {
        $user = \Auth::user();

        $query = DB::table('client_users_rel as cur')
                ->select('c.client_key')
                ->join('clients as c', 'c.id', '=', 'cur.client_id')
                ->where('cur.user_id', '=', $user->id)
                ->first();

        if (!isset($query->client_key))
            return false;

        DBConnection::setSessionDBparams($query->client_key);
        DBConnection::setDBconnection();

        return $this->authUserInClientDB();
    }

    protected function authUserInClientDB() {
        if (Auth::attempt(['email' => $this->username, 'password' => $this->password, 'active' => self::active])) {
            return \Auth::user()->id;
        }

        \Session::flush();
        Auth::logout();

        return false;
    }

    public function loginByCredentials($userCredentials) {
        $this->setCredntials($userCredentials);

        if (Auth::attempt(['email' => $this->username, 'password' => $this->password, 'active' => self::active])) {
            return $this->authenticated();
        }

        return false;
    }

}
