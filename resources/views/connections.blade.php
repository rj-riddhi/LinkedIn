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
   <style>
        .dataTables_filter {
   width: 50%;
   float: left;
   text-align: left;
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
.nav-link:hover{
  font-weight: bold;
  text-shadow:0.09px 0.09px #444;
}
#csrf{
    display:none;
}

.badgeCol{
     position:relative;
}
.badge{
    color:white;
    background-color:#FF4B4B;
    font-weight:bold;
    border-radius:50%;
    position:absolute;
    left:15rem;
    top:0.2rem;

}
        </style>
    </head>
    <body>

    <span id="csrf">
    @csrf
    </span>
        
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
        <a class="nav-link" href="/welcome/{{$name}}" >Dashboard </a>
        <?php $loggedinuser = $name ?> 
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color:#1d7a8c">Connections</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/logout">Logout</a>
      </li>
      
    </ul>
  </div>
</nav>
</header>
    

            <div class="container mt-5 shadow">
    <div class="row">
        <div class="col" >
        <table id="usertable" class="table table-striped table-hover" >
    <thead>
    
        <tr>
            <th>User Name</th>
            <th>Email</th>
            <th>Action</th>
            </tr>
</thead>
    <tbody >
    
        <?php 
       $id =  \App\Http\Controllers\UserController::getUserId($name );
        $data = \App\Http\Controllers\UserController::getConnectionrequests($name) 
            ?>
            
        @foreach($data as $arr)
       <tr>
       
               <td >
                  @if($arr->From != $name)
                 {{$arr->From}}
                 <?php $name =  $arr->From;
                       $id2 = \App\Http\Controllers\UserController::getUserId($name)
                ?>
                 <?php $email = \App\Http\Controllers\UserController::getEmail($arr->From)?>
                 @else
                 {{$arr->To}}
                 <?php $name =  $arr->To;
                       $id2 = \App\Http\Controllers\UserController::getUserId($name)
                 ?>
                 
                <?php $email = \App\Http\Controllers\UserController::getEmail($arr->To)?>
                 @endif
                 
                </td>
              <td>
              {{$email[0]->email}}
               </td>
               <td class="badgeCol"><button class="btn cancelbtn" onclick="cancelRequest({{$id}},'{{$name}}')">Broke</button>
               <button class="btn connectionbtn" onclick="chating('{{$loggedinuser}}','{{$name}}')">Start Conversation</button>
               <span id={{$id2}} class="badge"></span>
               
            </td>
               
               </tr>
            @endforeach
    </tbody>
    
        

</table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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

        
   var notifications = `<?php echo  \App\Http\Controllers\UserController::getNotifications($loggedinuser,$name)?>`;
  
    var receiverId = `<?php echo \App\Http\Controllers\UserController::getUserId($name )?>`;
    if(notifications > 0)
    {
    document.getElementById(receiverId).innerHTML = notifications;
    }
    });

    
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
    
    function chating(name,name2)
    {
        var csrfval = document.getElementById("csrf");
      csrf=csrfval.childNodes[1].value;
      
        var senderId = <?php echo  \App\Http\Controllers\UserController::getUserId($loggedinuser)?>;
        var receiverId = <?php echo \App\Http\Controllers\UserController::getUserId($name )?>;
        var update = <?php echo  \App\Http\Controllers\UserController::clearNotifications($loggedinuser,$name)?>;
        window.location.href = `/index/{{$loggedinuser}}/{{$name}}/${senderId}/${receiverId}/${csrf}`;
        
    }


</script>
</body>
</html>
