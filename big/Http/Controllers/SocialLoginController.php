<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;

class SocialLoginController extends Controller
{
    # FACEBOOK LOGIN 
    public function loginwithfacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginwithfacebookhistory()
    {
        

        
        $user = Socialite::driver('facebook')->stateless()->user();

        $check = DB::table('express')->where('social_link', $user->id)->count() ;

        if ($check > 0) {
            $values = DB::table('express')->where('social_link', $user->id)->first() ;
            Session::put('email', $values->email);
            Session::put('buyer_id', $values->id);
            Session::put('buyer_type', $values->type);
            Session::put('loggedin',"true");
            
            return Redirect::to('');
        }else{
            $data                       = array() ;
            $data['first_name']         = $user->name ;
            $data['email']              = $user->email ;
            $data['image']              = $user->avatar_original ;
            $data['social_link']        = $user->id ;
            $data['type']               = 3 ;
            $data['newsletter_status']  = 1 ;
            DB::table('express')->insert($data) ;
            
            $query = DB::table('express')->where('social_link', $user->id)->first() ;
            
            Session::put('email', $query->email);
            Session::put('buyer_id', $query->id);
            Session::put('buyer_type', $query->type);

            return Redirect::to('');
        }

    }

    public function loginwithgmail()
    {
        return Socialite::driver('google') ->setScopes(['openid', 'email'])->redirect();
    // 	return Socialite::driver('google')->stateless()->redirect();
    }

    public function loginwithgmailhistory()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $check = DB::table('express')->where('social_link', $user->id)->count() ;
        

        if ($check > 0) {
            $values = DB::table('express')->where('social_link', $user->id)->first() ;
            Session::put('email', $values->email);
            Session::put('buyer_id', $values->id);
            Session::put('buyer_type', $values->type);

            return Redirect::to('');
        }else{
            $data                   = array() ;
            $data['first_name']     = $user->name ;
            $data['email']          = $user->email ;
            $data['image']          = $user->avatar_original ;
            $data['social_link']    = $user->id ;
            $data['type']           = 3 ;
            $data['newsletter_status']  = 1 ;
            DB::table('express')->insert($data) ;

            $query = DB::table('express')->where('social_link', $user->id)->first() ;
            Session::put('email', $query->email);
            Session::put('buyer_id', $query->id);
            Session::put('buyer_type', $query->type);
            
            return Redirect::to('');
        }
    }

    public function loginwithlinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function loginwithlinkedinhistory()
    {
        $user = Socialite::driver('linkedin')->user();
        $check = DB::table('express')->where('social_link', $user->id)->count() ;
        if ($check > 0) {
            $values = DB::table('express')->where('social_link', $user->id)->first() ;
            Session::put('email', $values->email);
            Session::put('buyer_id', $values->id);
            Session::put('buyer_type', $values->type);

            return Redirect::to('');
        }else{
            $data                   = array() ;
            $data['first_name']     = $user->name ;
            $data['email']          = $user->email ;
            $data['image']          = $user->avatar ;
            $data['social_link']    = $user->id ;
            $data['type']           = 3 ;
            $data['newsletter_status']  = 1 ;
            DB::table('express')->insert($data) ;

            $query = DB::table('express')->where('social_link', $user->id)->first() ;
            Session::put('email', $query->email);
            Session::put('buyer_id', $query->id);
            Session::put('buyer_type', $query->type);
            
            return Redirect::to('');
        }
    }


}
