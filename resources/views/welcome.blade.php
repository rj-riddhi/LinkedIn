<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <style>
        .dataTables_filter {
   width: 50%;
   float: left;
   text-align: left;
}

.list-unstyled{
    background:rgba(29,122,140,0.73);
    color:white;
    cursor:pointer;
    max-width:30%;
}
.list-unstyled li{
    padding:12px;
}
.list-unstyled li:hover{
    background:rgba(29,122,140,1);
}
#usertable_paginate > ul > li.paginate_button.page-item.active > a{
    background-color:#1d7a8c;
    border-radius:50%;
}
#usertable_previous > a{
    border-radius:50%;
}
#usertable_next > a{
    border-radius:50%;
}
.connectionbtn{
    background-color:#1d7a8c;
    color:white;
    font-weight:bold;
}
.connectionbtn:hover{
    background-color:white;
    color:#1d7a8c;
    font-weight:bold;
    box-shadow: 0px 0px 9px #00000059;
}
.cancelbtn{
    background-color:#FF4B4B;
    color:white;
    font-weight:bold;
}
.cancelbtn:hover{
    background-color:white;
    color:#FF4B4B;
    font-weight:bold;
    box-shadow: 0px 0px 9px #00000059;
}



        </style>
    </head>
    <body>
        
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
    <header >
       <nav class="navbar navbar-expand-lg navbar-light bg-light" >
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#" style="color:#1d7a8c">Dashboard </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/connections/{{$name}}">Connections</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="/stripe">Payment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/logout">Logout</a>
      </li>
      
    </ul>
  </div>
</nav>
</header>
        <img src="https://tse4.mm.bing.net/th?id=OIP.FPjQ2OolWgNHEDLXkIf98AHaF2&pid=Api&P=0&w=195&h=154" />
        <br>
       <h1> Welcome {{ $name }} to your Dashboard! </h1>

       @if (Session::has('success'))
       
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col" >
            
        <table id="usertable" class="table table-striped table-hover" >
        <div id="suggetionList"></div>
    <thead>
    
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
            <th>Cancel</th>
            <th>Technologies</th>
        </tr>
    </thead>
    <tbody >
  <?php
  $id2 =  \App\Http\Controllers\UserController::getUserId($name );
    $data = \App\Http\Controllers\UserController::getUsers($id2) ;
    ?>

    @foreach($data as $arr)
    <?php $status = \App\Http\Controllers\UserController::getStatus($name,$arr->name) ?>
                    @if($status->count() != 0 )
                         @if(($arr->name != $name) && $status[0]->status != "Connected")
            <tr>
               <td>
                 
                    {{ $arr->name }} 
                    <?php $id =  \App\Http\Controllers\UserController::getUserId($arr->name );?>
                    </td>
               <td>
                    {{ $arr->email }} 
                </td>
               <td>
                   @if($status[0]->status == 'Pending' &&  $status[0]->From == $name)
                            <button class="btn connectionbtn">sent</button>
                   @elseif($status[0]->status == 'Pending' &&   $status[0]->To == $name)
                            <button id="{{$id2}}" onclick="acceptRequest({{$id2}},'{{$name}}')" class="btn connectionbtn">
                            Accept</button>
                            <button onclick="rejectRequest('{{$arr->id}}','{{$arr->id}}','{{$name}}')" class="btn connectionbtn">
                             Reject
                            </button>
                   @else
                    <button class="btn connectionbtn">
                    Make Connection
                    </button>
                   @endif

                    
                </td>
                <td>
                    @if($status[0]->status == 'Pending' &&  $status[0]->From == $name)
                    <button class="btn cancelbtn" onclick="cancelRequest({{$id}},'{{$name}}')">Cancel</button>
                    @endif
                </td>
                <?php 
                $tech =  json_decode($arr->technologies)?>
                <td>
                    
                @foreach($tech as $data)
                {{$data }}
                @endforeach
            </td>

            </tr>
            @endif
            @else
            @if(($arr->name != $name) )
            <tr >
               <td>
                 
                    {{ $arr->name }} 
                    <?php $id =  \App\Http\Controllers\UserController::getUserId($arr->name );?>
                    </td>
               <td>
                    {{ $arr->email }} 
                </td>
               <td>
                   <button id="{{$arr->name}}" onclick="connectionRequest('{{$arr->name}}','{{$name}}','{{$id}}')"  class="btn connectionbtn">
                   
                    Make connection
                    
                    </button>
                </td>
                <td></td>
                <?php 
                $tech =  json_decode($arr->technologies);
                ?>
                <td>
                @foreach($tech as $data)
                {{$data }}
                @endforeach
            </td>
            </tr>
            @endif
            @endif
            @endforeach
    </tbody>
</table>
        </div>
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<script>
$(document).ready(function() {
        $('#usertable').DataTable({
       "ordering": false,
        "bInfo":false,
        "sDom": '<"top"f>t<"bottom"p><"clear">'
            
        });
        $("#usertable_filter > label > input").keyup(function() {
            var query = $(this).val();
            if(query != '')
            {
       var data = {
            "name":query
        };
        console.log(data);
        var jsondata = JSON.stringify(data);
        fetch("/api/getSuggestions",{
            method:"POST",
            body : jsondata,
            header : {
                'Content-Type' :'application/json',
            }
         })
         .then((response)=>response.text())
         .then((data)=>{
             
            $('#suggetionList').fadeIn();
             $('#suggetionList').html(data);
            
             
         })
         .catch((error)=>{
         	console.log(error);
         });
            }
            else{
                $('#suggetionList').fadeOut();
             $('#suggetionList').html('');
             }
        });
        $(document).on('click','li',function(){
            $('#usertable_filter > label > input').val($(this).text());
            $('#suggetionList').fadeOut();
            
            // $("#usertable_filter > label > input").click();
            $("#usertable_filter > label > input").focus();
            // $("#usertable_filter > label > input").trigger("click");
       
        });
        // let arrow =  document.querySelector('#usertable_previous >a');
        // arrow.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M77.25 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C175.6 444.9 183.8 448 192 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l137.4-137.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-160 160c-12.5 12.5-12.5 32.75 0 45.25l160 160C367.6 444.9 375.8 448 384 448s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"/></svg>';
        // arrow.style.color = "#1d7a8c";
    });
    
function acceptRequest(id,name)
    {
        var data = {
            "id":id,
            "name":name
        };
        console.log(data);
        var jsondata = JSON.stringify(data);
        fetch("/api/acceptequest",{
            method:"POST",
            body : jsondata,
            header : {
                'Content-Type' :'application/json',
            }
         })
         .then((response)=>response.text())
         .then((data)=>{
           if(data >= 1)
             {
                 alert("Connected..");
                    var row = document.getElementById(id);
                    row.parentNode.removeChild(row);
                    window.location.reload(true);
             }
             else{
                 alert("Try again...");
             }
         })
         .catch((error)=>{
         	console.log(error);
         });
        }

        function rejectRequest(id,rowid,name)
    {
        var data = {
            "id":id,
            "name":name
        };
        console.log(data);
        var jsondata = JSON.stringify(data);
        fetch("/api/rejectrequest",{
            method:"POST",
            body : jsondata,
            header : {
                'Content-Type' :'application/json',
            }
         })
         .then((response)=>response.text())
         .then((data)=>{
             if(data >= 1)
             {
                 alert("Rejected...");
                window.location.reload(true);
             }
             else{
                 alert("Try agian..");
             }
         })
         .catch((error)=>{
         	console.log(error);
         });
    }

    function cancelRequest(rowid,name)
    {
        var data = {
            "id":rowid,
            "name":name
        };
        console.log(data);
        var jsondata = JSON.stringify(data);
        fetch("/api/cancelrequest",{
            method:"POST",
            body : jsondata,
            header : {
                'Content-Type' :'application/json',
            }
         })
         .then((response)=>response.text())
         .then((data)=>{
             if(data >= 1)
             {
                 alert("Cancelled...");
                window.location.reload(true);
             }
             else{
                 alert("Try agian..");
             }
         })
         .catch((error)=>{
         	console.log(error);
         });
    }

    function connectionRequest(name,targetname,userid)
    {
        var data = {
            "targetname":name,
            "name":targetname,
            "userid":userid
        };
        var jsondata = JSON.stringify(data);
        fetch("/api/connectionrequest",{
            method:"POST",
            body : jsondata,
            header : {
                'Content-Type' :'application/json',
            }
         })
         .then((response)=>response.text())
         .then((data)=>{
         	if(data >= 1)
             {
                document.getElementById(name).innerHTML = "Pending";
                window.location.reload(true);
             }
         })
         .catch((error)=>{
         	console.log(error);
         });
    }

   
</script>


        
    </body>
</html>
