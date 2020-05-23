<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\User;
use DB;
use Hash;
use Config;
use JWTAuth; 
class AuthController extends Controller
{
    protected $_userRepo = '';  
    public function __construct(){ 
		
	} 
    public function signup(Request $request){   
    	try{  
	    	$data = $request->all();   
			$rules = [ 
			  'name'=>'required',  
			  'email' => 'required|unique:users,email',  
		      'mobile_number' => 'required|numeric'  
			];  
			$validator = Validator::make($data, $rules);
			if ($validator->fails()) {  
			  return response()->json([ 
				'message' => $validator->messages(),
				'status' => 400,
			  ],400);			
			}
			else{ 
				$user =  $this->userRepo()->signup($data); 
				if($user){ 
					return response()->json([ 
						'success' => 200, 
						'message' => trans('messages.user_create'), 
						'data'=> $user,
					],200); 
				} 
			} 
		}catch(\Illuminate\Database\QueryException $ex){ 
			return response()->json([  
				'message' => trans('messages.something_wrong'), 
				'status' => 500  
			],500);
		} 		
    } 
    public function login(Request $request)
    {
    	$data = json_decode($request->getContent(), true);
		$rules = [
		  'email' => 'required', 
		  'password' => 'required' 
		];
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) { 
		  // Validation failed
		  return response()->json([
			'message' => $validator->messages(),
			'status' => 400,
		  ],400);		  	
		}
		else{
			$user = User::where('email', $data['email'])->first();
			if($user){
				if (Hash::check($data['password'], $user->password)) {
					$token = JWTAuth::attempt($data);  
					return response()->json([ 
						'success' => 200,
						'message' => trans('messages.login'), 
						'token' => $token,
						'data'=> $user,
					],200);	
				}else{
					return response()->json([
						'success' => 401,
						'message' => trans('messages.wrong_password'),
					], 401);				
				}				
			} 
			else{
				return response()->json([
					'success' => 401,
					'message' => trans('messages.email_not_registered'),
				], 401);				
			}
		}		
	}
	#repository
    /***************************************************/
	public function userRepo() {  
        if (!($this->_userRepo instanceof \App\Http\Repository\UserRepo)) {
            $this->_userRepo = new \App\Http\Repository\UserRepo();
        }
        return $this->_userRepo;  
    }
    
}