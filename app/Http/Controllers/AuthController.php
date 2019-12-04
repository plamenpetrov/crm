<?php

use App\Models\Login\Repositories\User\UserLoginRepositoryInterface as UserLoginRepositoryInterface;
use App\Models\Api\Repositories\Navigation\NavigationRepositoryInterface as NavigationRepositoryInterface;
use App\Models\Api\Repositories\Language\LanguageRepositoryInterface as LanguageRepositoryInterface;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Http\Request as Request;

/**
 * Description of AuthController 
 * 
 * The Authentication controller is responsible for user's authentication
 */
class AuthController extends ApiController {

    /**
     * User repository
     * @var type 
     */
    protected $userRepository;
    protected $navRepo;

    public function __construct(UserLoginRepositoryInterface $userRepo, NavigationRepositoryInterface $navRepo, LanguageRepositoryInterface $langRepo) {
        $this->userRepository = $userRepo;
        $this->navRepo = $navRepo;
        $this->langRepo = $langRepo;

        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function getLogin(Request $request) {
        
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $credentials = request(['email', 'password']);

        if (!$token = $this->userRepository->findUserByEmail($credentials)) {
            return $this->respondUnauthorized('Wrong credentials');
        }

        //load ACL for navigation
        \Acl::loadAcl();

        $headers = ['Authorization' => 'Bearer ' . $token];

        return $this->respond([
                    'status' => 'success',
                    'navigation' => $this->navRepo->getNavigations(),
                    'language' => \Config::get('clients.' . \Session::get('clientKey') . '.language'),
                    'languages' => $this->langRepo->getActiveLanguages(),
                    'translations' => \Translate::getTranslations(),
                    'acl' => []
                        ], 'Success login!', $headers
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @URL : /login
     * @Method : POST
     * 
     * The method is validating the user's credentials and the application language, he required.
     * Once validation is passed, the specific customer's database credentials are put in the Session, 
     * so every application request could "read" the session and routes to this specific DB. 
     * After this, some(not all !)  of the user's specific permissions are loaded and also stored in his Session
     * Finally, the application locale is set, according the user's input, and a success message is returned
     * @return type
     */
    public function postLogin() {
        //TO DO: prevent access if loged in
        if (\Auth::user())
            return $this->respond([
                        'status' => 'success',
                        'navigation' => $this->navRepo->getNavigations(),
                        'languages' => $this->langRepo->getActiveLanguages(),
                        'translations' => \Translate::getTranslations(),
                        'acl' => []
                            ], 'Success login!');

        $validator = Validator::make(Input::all(), array(
                    'email' => 'required|email',
                    'password' => 'required|string'
                        )
        );

        if ($validator->fails()) {
            return $this->respondUnauthorized($validator->errors()->first());
        } else {
            $authenticate = $this->userRepository->loginByCredentials(Input::all());

            if (!$authenticate)
                return $this->respondUnauthorized('Wrong credentials');

            \Acl::loadAcl();

            $this->langRepo->setLang(\Auth::user()->prefered_lang);

            \LangDir::setLanguageNamespace();

            return $this->respond([
                        'status' => 'success',
                        'navigation' => $this->navRepo->getNavigations(),
                        'languages' => $this->langRepo->getActiveLanguages(),
                        'translations' => \Translate::getTranslations(),
                        'acl' => []
                            ], 'Success login!');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request) {
        $payload = auth()->payload();

        $user = JWTAuth::toUser($request->token);
        return response()->json(['user' => $user, 'payload' => $payload]);
    }

}
