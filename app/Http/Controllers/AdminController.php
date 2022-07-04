<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usermodel;
use App\Models\Connection;
use App\Models\Message;
use App\Models\Admin_notification;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;

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

    public function export() 
    {
        // return \Maatwebsite\Excel\Excel::download(new UsersExport,'invoices.xlsx' );
          return Excel::download(new UsersExport, 'invoices.HTML');
        // return Excel::CSV->download(new UsersExport, 'invoices.csv');
        // return (new UsersExport)->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
    
    }

    public function plotChart()
    {

    $record = Usermodel::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("MONTHNAME(created_at) as day"))
    ->groupBy('day_name','day')
    ->orderBy('day')
    ->get();
 
     $data = [];

     foreach($record as $row) {
        $data['label'][] = $row->day;
        $data['tooltip'][] = $row->day_name;
        $data['data'][] = (int) $row->count;
      }

    $data['chart_data'] = json_encode($data);
    return view('charts', $data);
    }

    public function chatLogs(){
        $totalUsers = $this->getUsers();
        $onlineUsers = Usermodel::where("Status","1")
                                ->where("role",'0')
                                ->get();
        $totalRequests = $this->getTotalRequests();
        $connected = $this->getTotalConnections();
        $pending = Connection::where("Status","Pending")
                              ->get();
        $totalChats = $this->getTotalChats();

     $data = [];

         $data['label'] = ['TotalUsers','OnlineUsers','TotalRequests','Connected','Pending','Chattings'];
         $data['data'] = [count($totalUsers),count($onlineUsers),count($totalRequests),count($connected),count($pending),count($totalChats)];
    
    
        $data['bar_data'] = json_encode($data);
        return $data;
    
    }

    public static function activities()
    {
        $result = Admin_notification::all();
        return json_encode(array('array'=>$result));
    }
}
