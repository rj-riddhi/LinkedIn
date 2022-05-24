
// const { json, response } = require('express');
const express = require('express');
const app = express();
const http = require('http').createServer(app) ;
const axios = require('axios');
const mysql = require("mysql");
const path = require('path');
var bodyParser = require("body-parser");
// app.use(bodyParser.urlencoded());
app.use(bodyParser.json());
// const upload = require('express-fileupload');

const multer = require('multer');
// const { promise } = require('bcrypt/promises');
// const { resolve } = require('path');
// const { reject } = require('lodash');
// const { url } = require('inspector');
// const bcrypt = require('bcrypt');

app.use(require('cors')());
const PORT = process.env.PORT || 8000 ;

http.listen(PORT,()=>{
    console.log(`Listning on ${PORT}`);
});

app.use(express.static(path.join(__dirname, 'public')));


// DB Connection

var pool   = mysql.createPool({
  connectionLimit : 10, // default = 10
  host            : 'localhost',
  user            : 'root',
  database: "linkedin",
  password : '',
  charset : 'utf8mb4'
});

// Image Upload

const fileStorageEngine_image = multer.diskStorage({
  destination:(req,file,cb)=>{
    cb(null,"../images/ChatImage");
  },
  filename:(req,file,cb)=>{
    cb(null,(file.originalname).replace(" ","_"));
  }
});

const upload_image = multer({storage: fileStorageEngine_image});

app.post('/uploadImages',upload_image.single('file'),async(req,res)=>{
  var filename = req.file.filename;
  var senderId = req.body.senderId;
  var receiverId = req.body.receiverId;
  var time = req.body.time;
  var data = {
    'message':filename,
    'senderId':senderId,
    'receiverId':receiverId,
    'time':time
  }
  await insertMsgtoDatabase(data);
  res.send(data);
 
});

// Video upload start
const fileStorageEngine_video = multer.diskStorage({
  destination:(req,file,cb)=>{
    cb(null,"../Videos");
  },
  filename:(req,file,cb)=>{
    cb(null,file.originalname)
  }
});

const upload_video = multer({storage: fileStorageEngine_video});

app.post('/uploadVideoFile',upload_video.single('file'),async(req,res)=>{
  var filename = req.file.filename;
  var senderId = req.body.senderId;
  var receiverId = req.body.receiverId;
  var time = req.body.time;
  var data = {
    'message':filename,
    'senderId':senderId,
    'receiverId':receiverId,
    'time':time
  }
  await insertMsgtoDatabase(data);
  res.send(data);
 
 
});



// Document upload start
const fileStorageEngine_doc = multer.diskStorage({
  destination:(req,file,cb)=>{
    cb(null,"../Documents");
  },
  filename:(req,file,cb)=>{
    cb(null,file.originalname)
  }
});

const upload_doc = multer({storage: fileStorageEngine_doc});

app.post('/uploadDocument',upload_doc.single('file'),async(req,res)=>{
  // var filename = req.file.destination+'/'+req.file.filename;
  var filename = req.file.filename;
  var senderId = req.body.senderId;
  var receiverId = req.body.receiverId;
  var time = req.body.time;
  var data = {
    'message':filename,
    'senderId':senderId,
    'receiverId':receiverId,
    'time':time
  }
  await insertMsgtoDatabase(data);
  res.send(data);
 
 
});


app.get('/welcome/:name', function(req, res) {
  var name = req.params.name;
 
  // Static Middleware
// app.use(express.static(path.join(__dirname,'../resources/views')));
  // 
// View Engine Setup
// app.set('views', path.join(__dirname, '../../../resources/views'))
// app.set('view engine', 'php')
// console.log(__dirname);
  res.url(__dirname+"/welcome");
//  res.render(__dirname+'/welcome');
// res.render("http://localhost:8000/welcome/"+name);
  // res.view('welcome',['name'=>name]);
})

app.post('/getMessageStatus',async(req,res)=>{
  
var status = await insertMsgtoDatabase(req.body);
res.send(`${status}`);
});
 
// Video upload end

// Socket
const io = require('socket.io')(http, {
    cors: { origin: "*",}
});
io.on('connection' , (socket)=>{
    console.log("Connceted");

    socket.on('messagereceive',async (msg)=>{
        
     socket.broadcast.emit('messagesend',msg);
        await insertMsgtoDatabase(msg);
       
        // socket.broadcast.emit('messagesend',msg);
       
      });
});




async function insertMsgtoDatabase(msg)
{
  return new Promise((resolve,reject) => {
    pool.getConnection(function (err, connection) {
      if (err) throw err;
         var userstatus = `SELECT * FROM userslogin2 WHERE id=${msg.receiverId}`;
         
         connection.query(userstatus,function(err,result){
           connection.release();
           if (err) throw err;
           var msgstatus ;
           var notifications;
           if(result[0].Status == '0' || result[0].Status == null )
           {
              msgstatus = 0;
              }
           else{
                  msgstatus = 1; 
                }
              var totalNotifications = `SELECT * FROM messages WHERE Sender='${msg.senderId}' && Receiver='${msg.receiverId}' && Message_Read=0`;
            connection.query(totalNotifications,function(err,result){
            if (err) throw err;
           
             if(msgstatus == 0)
             {
               if(result.length == 0)
               {
               notifications = result.length+1;
               }
               else{
                notifications = result.length;
                }
             }
             else
             {
               notifications = 0;
             }
             var sql = `INSERT INTO messages (Sender,Receiver,Messages,Message_Read,Notifications,created_at) VALUES("${msg.senderId}","${msg.receiverId}","${msg.message}","${msgstatus}","${notifications}","${msg.time}")`;
       connection.query(sql,function(err,result){
       if (err) throw err;
       else
       {
        deleteDuplicateEntries(); 
        updateNotification(notifications,msg);
        console.log("Data inserted...!!!");
      resolve(msgstatus);
      }
      
        });
      });
           });
         
          });
     });
  
}

app.post('/changeStatus',(req,res)=>{
  pool.getConnection(function (err, connection) {
    connection.release();
    if (err)
      throw err;
    var sql = `UPDATE userslogin2
                SET Status = "${req.body.status}"
                WHERE name = "${req.body.name}"`;
    connection.query(sql, function (err, result) {
      if (err)
        throw err;
        res.send(`${result.changedRows}`);
    });
  });
 
})
function deleteDuplicateEntries()
{
  
  pool.getConnection(function (err, connection) {
    connection.release();
    if (err)
      throw err;
  var deletequery = `DELETE t1 FROM messages t1
  INNER JOIN messages t2 
  WHERE 
      t1.id < t2.id AND 
      t1.Messages = t2.Messages AND
      t1.Sender = t2.Sender AND
      t1.Receiver = t2.Receiver AND
      t1.Message_Read = t2.Message_Read AND
      t1.created_at = t2.created_at`;
      connection.query(deletequery,function(err,result){
        if (err) throw err;
        
      });
    });
}

function updateNotification(notifications,msg)
{
  pool.getConnection(function (err, connection) {
    connection.release();
    if (err)
      throw err;
  var updateQuery = `UPDATE messages
          SET Notifications = "${notifications}"
              WHERE Sender = "${msg.senderId}" 
            && Receiver = "${msg.receiverId}"`;
              connection.query(updateQuery,function(err,result){
                if (err) throw err;
                
              });
  });
}




