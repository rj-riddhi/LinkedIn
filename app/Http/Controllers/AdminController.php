<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermodel;
use App\Models\Connection;
use App\Models\Message;

class AdminController extends Controller
{
    public static function getUsers()
    {
       $result = Usermodel::where('role','0')
                            ->get();
       return $result; 
    }

    public static function getLastLoginDate()
    {
        $result = Usermodel::all()->last();
                    return $result; 
    }

    public static function getTotalConnections()
    {
        $result = Connection::where('status','Connected')->get();
        return $result;
    }

    public static function getTotalRequests()
    {
        $result = Connection::all();
        return $result;
    }

    public static function getTotalChats()
    {
        $result =  Message::select('Sender')->distinct()->get();
        return $result;
    }

    public static function getUserConnection($id)
    {
        dd($id);
    }

    public function getUserData(Request $req)
    {
       $connections = $this->getConnectionById($req->id);
       $incomingRequests = $this->getIncomingRequests($req->id);
       $outgoingRequests = $this->getOutgoingRequests($req->id);
       $chats = $this->getUserChatById($req->id);

       return json_encode(array('connections'=>$connections,'incomingRequests'=>$incomingRequests,'outgoingRequests'=>$outgoingRequests,'chats'=>$chats));
    }

    public function getConnectionById($id)
    {
        $name = Usermodel::where('id',$id)->get();
       $connection = Connection::where('From',$name[0]['name'])
                                ->where('status','Connected')
                                ->get();
        return $connection;
    }

    public function getIncomingRequests($id)
    {
        $name = Usermodel::where('id',$id)->get();
        $result = Connection::where('To',$name[0]['name'])
                            ->where('status','Pending')
                            ->get();
        return $result;
    }

    public function getOutgoingRequests($id)
    {
        $name = Usermodel::where('id',$id)->get();
        $result = Connection::where('From',$name[0]['name'])
                            ->where('status','Pending')
                            ->get();
        return $result;
    }

    public function getUserChatById($id)
    {
        $result = Message::select('Receiver')->distinct()->where('Sender',$id)->get();
        return $result;
    }
}
