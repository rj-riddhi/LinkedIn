<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermodel;
use App\Models\Connection;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use App\Http\helpers;
use App\Http\Controllers\MailController;
		

class UserController extends Controller
{
	public function LoginUser(Request $req)
	{
		$input = file_get_contents('php://input');
		$decode = json_decode($input,true);
		$data = [
		  'profile' => $decode['profile'],
		  'usersFirstName' => $decode['firstname'],
		  'usersLastName' => $decode['lastname'],
		  'usersEmail' => $decode['email'],
		  'phone'=>$decode['phone'],
		  'usersPwd' => $decode['pass'],
		  'pwdRepeat' => $decode['confirmpass'],
		  'tech'=>$decode['arr']
		];
		
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
	  $user->password = $data['usersPwd'];
	  $user->technologies = $data['tech'];
	  $user->profile_photo_path = $data['profile'];
	  $result2 = $user->save();
	 if($result2 == true)
	  {
		  $id = Usermodel::where('email',$data['usersEmail'])->get();
		  session()->put("UserName",$user->name);
		  
		  $sessiondata = array("name"=>$user->name,"id"=>$id[0]->id);
		//  Sending mail 
		  $mailresult = MailController::index($user->email);
		if($mailresult)
		{
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

        //Init data
        $data=[
            'Email' => $sessiondata['Email'],
            'usersPwd' =>  $sessiondata['password'],
        ];

       //Check for user/email
		$result = Usermodel::where('email',$data['Email'])->get();
		// echo $result;exit;
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
				return redirect('/welcome/'.session("UsersName"));
            }else {
				$html =  "Password Incorrect";
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
						
		   session()->flush();
    	return redirect("/userlogin");
   
}



    public static function getUsers($id)
    {
		
    	$data =  Usermodel::where('id','!=',$id)->get();
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


	
}
