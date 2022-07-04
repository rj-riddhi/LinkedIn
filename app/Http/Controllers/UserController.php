<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermodel;
use App\Models\Connection;
use App\Models\Message;
use App\Models\Admin_notification;
use Illuminate\Support\Facades\DB;
use App\Http\helpers;
use App\Http\Controllers\MailController;
use Laravel\Socialite\Facades\Socialite;
use Session;
use Stripe;
		

class UserController extends Controller
{
	public function LoginUser(Request $req)
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		
    	$req->validate([
    		// 'profile'=>'Required | mimes:jpg,bmp,png,jpeg',
    		'usersFirstName'=>'Required',
    		'usersLastName'=>'Required',
			'email'=>'Required | email | unique:userslogin2',
    		'phone'=>'Required | max:10 | min:10',
		    'password'=>'Required',
			'role'=>'Required',
			'pwdRepeat'=>'required_with:password|same:password|min:6',
			'technologies'=>'Required ',
		
	]);
		
		$data = [
		  'profile' => $req->profile,
		  'usersFirstName' => $req->firstname,
		  'usersLastName' => $req->lastname,
		  'usersEmail' => $req->email,
		  'phone'=>$req->phone,
		  'usersPwd' => $req->pass,
		  'usertype' => $req->usertype,
		  'pwdRepeat' => $req->confirmpass,
		  'tech'=>$req->arr,
		  'date'=>$req->date
		];
		
		
		if($data['usertype'] == 'Admin')
		{
			$usertype = '1';
		}
		else
		{
			$usertype = '0';
		}
		$result = Usermodel::where('email',$data['usersEmail'])->get();
		if($result == false)
		{
			return json_encode(array("insert"=>"fail","msg"=>"Username or Email already exist"));
		}
	
		$data['tech'] = json_encode($data['tech']);
		// Password hashing
		$data['usersPwd'] = password_hash($data['usersPwd'],PASSWORD_BCRYPT);
	  // Registration succesfull or not
	  $user = new Usermodel;
	  $user->name = $data['usersFirstName'].' '.$data['usersLastName'];
	  $user->email = $data['usersEmail'];
	  $user->phone = $data['phone'];
	  $user->password = $data['usersPwd'];
	  $user->role = $usertype;
	  $user->technologies = $data['tech'];
	  $user->profile_photo_path = $data['profile'];
	  $user->created_at = $data['date'];
	  $result2 = $user->save();
	 if($result2 == true)
	  {
		  $id = Usermodel::where('email',$data['usersEmail'])->get();
		  session()->put("UserName",$user->name);
		  session()->put("role",$usertype);
		  
		  $sessiondata = array("name"=>$user->name,"id"=>$id[0]->id);
		//  Sending mail 
		  $mailresult = MailController::index($user->email);
		if($mailresult)
		{
			$notification = new Admin_notification;
			$notification->notification = $user->name." Joined LinkedIn";
			$notification->time = $data['date'];
			$notification->save();
		 return json_encode(array("insert"=>"success","data"=>$sessiondata));

		}
	}
	
	else{
	  return json_encode(array("insert"=>"fail","msg"=>"Account is not created"));
	}
	}

    public function UploadProfile(Request $req){
		$file = $req->file('profile');
		$extension = $file->getClientOriginalExtension();
		$filename = time().'.'.$extension;
		move_uploaded_file('images/Profiles/',$filename);
		
		$file->move("images/Profiles/",$filename);
         return $filename;
	}

	public function getProfile(Request $req)
	{
		$name = $req[0];
		$result = Usermodel::where('name',$name)->get();
		return $result[0]["profile_photo_path"];
		
	}

	public function getUserStatus(Request $req)
	{
		$name = $req[0];
		$result = Usermodel::where('name',$name)->get();
		return json_encode(array('Status'=>$result[0]["Status"],'updated_at'=>$result[0]["updated_at"]));
		
	}


	public function UserLogin(Request $req){
		$sessiondata =  $req->input();
		if($sessiondata['user_type'] == 'Admin')
		{
			$usertype = '1';
		}
		else
		{
			$usertype = '0';
		}
        //Init data
        $data=[
            'Email' => $sessiondata['Email'],
            'usersPwd' =>  $sessiondata['password'],
			'usertype' => $usertype
        ];
		

       //Check for user/email
		$result = Usermodel::where('email',$data['Email'])
		                   ->where('role',$data['usertype'])
						   ->get();
		if(count($result)>0){
            //User Found
			$loggedInUser = password_verify($data['usersPwd'], $result[0]['password']);
			if($loggedInUser == 1){
                //Create session
				Usermodel::where('email',$data['Email'])
				           ->update(['Status'=>'1']);
				$req->session()->put('UsersName', $result[0]['name']);
				$req->session()->put('Id', $result[0]['id']);
				$req->session()->put('email',  $data['Email']);
				$req->session()->put('role',$data['usertype']);

				date_default_timezone_set('Asia/Kolkata');
		        $date =  date('Y-m-d H:i:s');
				$notification = new Admin_notification;
			$notification->notification = session()->get('UsersName')." is Online";
			$notification->time = $date;
			$notification->save();
				return redirect('/');
				
				
            }else {
				$html =  "Password Incorrect ";
				return view("/userlogin",['error'=>$html,'Email'=>$data['Email']]);
            }
		}
		else{
			$html =  "No user found";
				return view("/userlogin",['error'=>$html,'Email'=>""]);
			}
    }

	

    public function logout(){
		date_default_timezone_set('Asia/Kolkata');
		$date =  date('Y-m-d H:i:s');
		Usermodel::where('email',session()->get('email'))
		   ->update(['Status'=>'0','updated_at'=>$date]);
			
		   
		   $notification = new Admin_notification;
			$notification->notification = session()->get('UsersName')." is Offline";
			$notification->time = $date;
			$notification->save();
		   session()->flush();


		   
		 return redirect("/userlogin");
   
}



    public static function getUsers($id)
    {
		
    	$data =  Usermodel::where('id','!=',$id)
		                   ->where('role','!=','1')
						   ->get();
					return ($data);
    }
	public static function getUserId($name)
	{
		$data =  Usermodel::where('name',$name)->get();
		return ($data[0]['id']);
	}
	public static function getNotifications($loggedInUser,$name)
	{
		
		$senderId = static::getUserId($loggedInUser);
		$receiverId = static::getUserId($name);
		$data =  Message::where([
			['Sender', '=', $receiverId],
			['Receiver', '=', $senderId],
			['Message_Read','=','0']
		])
		->get();
		if (count($data) > 0)
		{
			return $data[0]['Notifications'];
		}
		else
		{
			return 0;
		}
				
	}

	public static function clearNotifications($loggedInUser,$name)
	{
		$senderId = static::getUserId($name);
		$receiverId = static::getUserId($loggedInUser);
		$update = Message::where([
			['Sender', '=', $senderId],
			['Receiver', '=', $receiverId],
		])
		->update(array("Message_Read"=>"1","Notifications"=>"0"));
		return $update;
	}
	public static function getEmail($name)
	{
		$data = Usermodel::where('name',$name)->get();
		return $data;
	}
	public function makerequest()
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$connection = new Connection;
		 $connection->From = $decode["name"];
		 $connection->To = $decode["targetname"];
		 $id = Usermodel::where('name',$decode['targetname'])->get();
		 $connection->user_id = $id[0]['id'];
		 $connection->status = "Pending";
		 $result = $connection->save();
		return $result;
	}

	public static function getConnectionrequests($name)
	{
		$data = Connection::where(function ($query) use ($name) {
			$query->where('From', $name);
			$query->orWhere('To', $name);
		})->where('status','Connected')->get();
		return $data;
	}

	public function acceptRequest()
	{
		
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$name =$decode['name'];
		$id = $decode['id'];
		$data =  Connection::where ('To', $name)
							->where('user_id',$id)					
							->update([
								'status'=>"Connected"
							]);
		return $data;
		
	}

	public function rejectrequest()
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$id = $decode['id'];
		$name = $decode['name'];
		$data =  Connection::where ('To', $name)
							->where('user_id',$id)					
							->delete();
		return $data;
	}

	public function cancelrequest()
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$id = $decode['id'];
		$name = $decode['name'];
		$data =  Connection::where ('From', $name)
							->where('user_id',$id)					
							->delete();
		return $data;
	}

	public function chatting()
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$name = $decode['name'];

		
		date_default_timezone_set('Asia/Kolkata');
		$date =  date('Y-m-d H:i:s');
		$notification = new Admin_notification;
			$notification->notification = $name." start chatting";
			$notification->time = $date;
			$notification->save();
		
		return redirect('index.html')->with('name', $name);
	}

	public function getSuggestions(){
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$name = $decode['name'];
		$result = Usermodel::where('name','LIKE', "%{$name}%")
							->get();
		$output = '<ul class="list-unstyled">';
							
		if(count($result) > 0)
		{
			foreach($result as $row)
			{
				$output .= '<li>'.$row["name"].'</li>';
			}
		}
		else{
			$result2 = Usermodel::where('email','LIKE', "{$name}%@gmail.com")
							->get();
							if(count($result2) > 0)
								{
									foreach($result2 as $row)
									{
										$output .= '<li>'.$row["email"].'</li>';
									}
								}
								else{
										$output .= '<li> User Not Found </li>';
								}
		}
		$output .= '</ul>';
		return $output;
	}

	public static function getStatus($name,$otherUserName)
	{
		$data = Connection::where(function ($query) use ($name,$otherUserName) {
									$query->where('From', $name);
									$query->Where('To', $otherUserName);
								})
								->orWhere(function ($query) use ($name,$otherUserName) {
									$query->where('From', $otherUserName);
									$query->Where('To', $name);
								})
								->get();
		return ($data);
    	
	}


	public static function loadMessages(){
		
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$senderId = $decode['senderId'];
		$receiverId = $decode['receiverId'];
		$result = Message::all();
		if($result)
		{
			for($j=0 ; $j<count($result) ; $j++)
			{
				$Messages[$j] =  $result[$j];
				
			}
			return json_encode(array("messages"=>$Messages));
		}
		}


		// Use laarvel Socialits (Google)

		public function googleRedirect()
{
    return Socialite::driver('google')->redirect();
}

public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
			
            return redirect('/');
        }
		// check if they're an existing user
        $existing = Usermodel::where('email', $user->email)->first();
		
        if ($existing) {
			Usermodel::where('email',$existing['email'])
				           ->update(['Status'=>'1']);
				session()->put('UsersName', $existing['name']);
				session()->put('Id', $existing['id']);
				session()->put('email',  $existing['email']);
				session()->put('role',$existing['usertype']);

				date_default_timezone_set('Asia/Kolkata');
		        $date =  date('Y-m-d H:i:s');
				$notification = new Admin_notification;
			$notification->notification = session()->get('UsersName')." is Online";
			$notification->time = $date;
			$notification->save();
				return redirect('/');
        }
		else{
			$html =  "No user found";
				return view("/userlogin",['error'=>$html,'Email'=>""]);
			}
    }

	// Payment Gateway

	public function stripe()
    {
        return view('stripe');
    }
   

	public function stripePost(Request $request)
    {
\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

\Stripe\PaymentIntent::create([
  'amount' => 1099,
  'currency' => 'inr',
  'payment_method_types' => ['card'],
]);

        
        Session::flash('success', 'Payment successful!');
           
        return redirect("/");
    }
		

	
}
