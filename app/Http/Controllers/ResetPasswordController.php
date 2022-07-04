<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\PwdReset;
use Session;

class ResetPasswordController extends Controller
{
    public function index(Request $req)
    {

        // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $Email = trim($req['Email']);

        if(empty($Email)){
            Session::flash('message', "Please Enter Email");
            return back();    
        }

        if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
            Session::flash('message', "Invalid email");
            return back();
        }
        //Will be used to query the user from the database
        $selector = bin2hex(random_bytes(8));
        // //Will be used for confirmation once the database entry has been matched
        $token = random_bytes(32);
        // //URL will vary depending on where the website is being hosted from
        $url = 'http://localhost:8000/create-new-password/'.$selector.'/'.bin2hex($token);
        // //Expiration date will last for half an hour
        $expires = date("U") + 600;
        // if(!$this->deleteEmail($Email)){
        //     die("There was an error email  deleteing");
        // }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        if(!$this->insertToken($Email, $selector, $hashedToken, $expires)){
            die("There was an error");
        }

        Mail::to($Email)->send(new ResetPasswordMail($url));
        Session::flash('message', "Check Your mail");
        return back();
        

       
      

    }

    
		public function deleteEmail($email){
			$result = pwdReset::find($email)->first();
            // if($row>0)
			if($result)
			{
                // delete logic 
				dd($result);
			}
			else
			{
				return true;
			}
		}
		public function insertToken($email,$selector,$hashedToken,$expires){
            $result_1 = new PwdReset();
            $result_1->pwdResetEmail = $email;
            $result_1->pwdResetSelector = $selector;
            $result_1->pwdResetToken = $hashedToken;
            $result_1->pwdResetexpires = $expires;
            $result_1->save();
        
           if($result_1){
				return true;
			}
			else
			{
				return false;
			}
		}

        public function ResetPasswords(Request $req)
        {
            dd($req);
        //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // $data = [
        //     'selector' => ($_POST['selector']),
        //     'validator' => ($_POST['validator']),
        //     'pwd' => ($_POST['pwd']),
        //     'pwd-repeat' => ($_POST['pwd-repeat'])
        // ];
        // $url = '../views/create-new-password.php?selector='.$data['selector'].'&validator='.$data['validator'];

        // if(empty($_POST['pwd'] || $_POST['pwd-repeat'])){
        //     flash("newReset", "Please fill out all fields");
        //     redirect($url);
        // }else if($data['pwd'] != $data['pwd-repeat']){
        //     flash("newReset", "Passwords do not match");
        //     redirect($url);
        // }else if(strlen($data['pwd']) < 6){
        //     flash("newReset", "Invalid password");
        //     redirect($url);
        // }

        // $currentDate = date("U");
        // if(!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)){
        //     flash("newReset", "Sorry. The link is no longer valid");
        //     redirect($url);
        // }

        // $tokenBin = hex2bin($data['validator']);
        // $array = $row['array'];
        // // echo ($array['pwdResetToken']);exit;
        // $tokenCheck = password_verify($tokenBin, $array['pwdResetToken']);
        // if(!$tokenCheck){
        //     flash("newReset", "You need to re-Submit your reset request");
        //     redirect($url);
        // }

        // $tokenEmail = $array['pwdResetEmail'];
        // if(!$this->userModel->findUserByEmailOrUsername($tokenEmail, $tokenEmail)){
        //     flash("newReset", "There was an error in finding user");
        //     redirect($url);
        // }

        // $newPwdHash = password_hash($data['pwd'], PASSWORD_DEFAULT);
        // if(!$this->userModel->resetPassword($newPwdHash, $tokenEmail)){
        //     flash("newReset", "There was an error in reset pass");
        //     redirect($url);
        // }

        // if(!$this->resetModel->deleteEmail($tokenEmail)){
        //     flash("newReset", "There was an error in delete user");
        //     redirect($url);
        // }

        // flash("login", "Password Updated", 'alert alert-success');
        // redirect("../views/Homepage.php?login=true");
        }
}
