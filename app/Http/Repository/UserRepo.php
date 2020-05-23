<?php
namespace App\Http\Repository;
set_time_limit(0);
use App\User;
use Image;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
use Config;
use App\Events\SendEmail;
use Hash;
use DB;
class UserRepo extends RepositoryAbstract
{
    protected $_usermodel = null;
    public function signup($data){ 
      $data['password']  = Hash::make($data['password']); 
      $userData = $this->getUserModel()->create($data); 
        /*----------send email for user registeration--------*/
            event(new SendEmail($userData->id));  
        /*-----------------------------------------*/ 
      return $userData; 
    } 
   
    /*------------*******User Model******------------*/
    public function getUserModel()    
    {
        if (!($this->_usermodel instanceof User)) {
            $this->_usermodel = new User();
        }
        return $this->_usermodel;
    }    
} 