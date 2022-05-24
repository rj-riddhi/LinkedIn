
const params =location.href;

var arr = params.split("/");

// Gloabal Variables
let name = arr[4];
name = name.replace("%20"," ");

var senderId  = arr[6];
let name2 = name.split(" ")[0];

let receivername = arr[5];
receivername = receivername.replace("%20"," ");

let receivername2 = receivername.split(" ")[0];
var receiverId = arr[7];
let csrf = arr[8];
var jsondata = JSON.stringify(receivername);





var userstatus;
var videoContents = new Array();
var documentContents = new Array();
var imageContents = new Array();

// For getting profile.
fetch("/api/getProfile",{
    method : 'POST',
        body : jsondata,
        headers : {
          'Content-Type' :'application/json',
        } 
      })
.then((response)=>response.text())
.then((data)=>{
    document.getElementById("dpImage").setAttribute("src",getBaseURL()+"/images/Profiles/"+data);
    document.getElementById("receiverName").innerHTML = receivername;
})
.catch((error)=>{
    console.log(error);
});
// For getting status
function getUserStatus()
{
fetch("/api/getUserStatus",{
    method : 'POST',
        body : jsondata,
        headers : {
          'Content-Type' :'application/json',
        } 
      })
.then((response)=>response.json())
.then((data)=>{
    if(data.Status == '1')
    {
        var status1 = document.getElementById('status1');
        status1.style.display = "block";
        document.getElementById('status2').style.display = "none";
    }
    else{
       
        var status2 = document.getElementById('status2');
        status2.style.display = "block";
        document.getElementById('status1').style.display = "none";
  
    }
    userstatus = data.Status;
    return data.Status;
    })
.catch((error)=>{
    console.log(error);
});
}
getUserStatus();



var dashboardlink = `<a class="nav-links" href="javascript:redirect('/welcome/`+name+`')">Dashboard</a>
                     <a class="nav-links" href="/connections/`+name+`">Connections</a>
                     <a class="nav-links" href="/logout" >Logout</a>`;
document.querySelector(".links").innerHTML += dashboardlink;


    function redirect(route)
{
    $.ajax({
        url:route,
        type: 'get',
        success: function (data) {
            console.log(data);
           
        }
        
    });
}

// const socket = io.connect('localhost:8000'); 

var baseURL               = getBaseURL(); // Call function to determine it
var socketIOLocation      = baseURL  // Build Socket.IO location
const socket                = io.connect(socketIOLocation);
function getBaseURL()
{
    baseURL = location.protocol + "//" + location.hostname + ":" + location.port;
    return baseURL;
}
let textarea = document.querySelector('#textarea');
let messageArea = document.querySelector('.message_area');

textarea.addEventListener('keyup',(e)=>{
    if(e.key == 'Enter')
    sendMessage(e.target.value);
    scrollToBottom();
   
    
});

function sendmsg(){
   
   sendMessage(textarea.value);
   scrollToBottom();

    var popupform = document.getElementById("popupForm");
    if(popupform.style.display == "block")
    {
        popupform.style.display = "none";
    }

    var imagetemplate = document.getElementById("image-template");
    if(imagetemplate.style.display == "block")
    {
        imagetemplate.style.display = "none";
    }

    var videoContainer = document.getElementById("video-step");
    if(videoContainer.style.display == "block")
    {
        videoContainer.style.display = "none";
    }
}

function sendMessage(msg)
{
    let currentDate = new Date();
let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
if(msg.includes(".mp4"))
{
  
    let videomsg = msg.split("Videos/")[1].split('.mp4')[0];
        videomsg += ".mp4";
        let data = {
            user:name2,
            senderId : senderId,
            message: videomsg,
            time : time,
            receiverId : receiverId,
            _token : csrf,
    
        }
        socket.emit('messagereceive',data);
        appendMessage(data,'outgoing');
        }

    else if(msg.includes(".pdf") || msg.includes(".docx") ||  msg.includes(".txt") || msg.includes(".xlsx") )
    {
        let docmsg = msg.split("Documents/")[1].split('" download')[0];
        let data = {
            user:name2,
            senderId : senderId,
            message: docmsg,
            time : time,
            receiverId : receiverId,
            _token : csrf,
    
        }
       socket.emit('messagereceive',data);
        appendMessage(data,'outgoing');
        }

        else if(msg.includes("images") )
        {
            let imgmsg = msg.split("images/ChatImage/")[1].split('" class')[0];
            let data = {
                user:name2,
                senderId : senderId,
                message: imgmsg,
                time : time,
                receiverId : receiverId,
                _token : csrf,
        
            }
           socket.emit('messagereceive',data);
            appendMessage(data,'outgoing');
            }
    
    else
    {
        
       
        let data = {
            user:name2,
            senderId : senderId,
            message: msg.trim(),
            time : time,
            receiverId : receiverId,
            _token : csrf,
    
        }
        appendMessage(data,'outgoing');
       socket.emit('messagereceive',data);
    
    }
    
    

}

async function appendMessage(data,type)
{
    
    let mainDiv = document.createElement('div');
    let className = type;
    mainDiv.classList.add(className,'message');
    

    var msg  = data.message;
    var status = userstatus;
    var msgstatus =await getMessageStatus(data);
    if(msg.includes("http") || msg.includes("https"))
    {
        if(!msg.includes("img") && !msg.includes("mp4"))
        {
        
           let markup = `
        
    <span><h4>${data.user}</h4></span?
    <p class="mb-0"><a target="_blank" href="${msg}" style="color:#1d7a8c" >${msg}</a></p>
    <br><span class="timeSpan">${data.time}`;
    tickmarkLogic(type,msgstatus,markup,mainDiv);
    }
    else{
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">${msg}</p>
        <br><span class="timeSpan">${data.time}`;
        tickmarkLogic(type,msgstatus,markup,mainDiv);
    }
       
    }
    else if(msg.includes("mp4") )
    {
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">
        <video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
        <source src="${videoContents[videoContents.length-1]}"  type="video/mp4" />
        </video>
        </p>
        <br><span class="timeSpan">${data.time}`;
        
        tickmarkLogic(type,msgstatus,markup,mainDiv);
    }

    else if(msg.includes("pdf") || msg.includes("docx") || msg.includes("txt") || msg.includes("xlsx"))
    {
        var object_url = icons_url[msg.split(".")[1]];
                   
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">
        <a href="${documentContents[documentContents.length-1]}" download="${msg}"> 
        <img src="${object_url}" class="img-small" >
        </a>
        <p>${msg}</p>
        <br><span class="timeSpan">${data.time}`;
        
        tickmarkLogic(type,msgstatus,markup,mainDiv);
       
    }
    else if(msg.includes(".jpeg") || msg.includes(".svg") || msg.includes(".jpg") || msg.includes(".png"))
    {
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">
        <img src='${imageContents[imageContents.length-1]}' class='image'></img>
        </p>
        <br><span class="timeSpan">${data.time}`;
        
        tickmarkLogic(type,msgstatus,markup,mainDiv);
        
    }  
    
   else{
       
            let markup = `
            <h4>${data.user}</h4>
            <p class="mb-0">${msg}</p>
            <br><span class="timeSpan">${data.time} 
            `;
            
             tickmarkLogic(type,msgstatus,markup,mainDiv);
            
    
        }
}

function addMrakup(markup,mainDiv)
{
    mainDiv.innerHTML = markup;
    messageArea.appendChild(mainDiv);
    textarea.value = '';

}

function tickmarkLogic(type,msgstatus,markup,mainDiv)
{
    if(type == 'outgoing')
    
           {
                if(msgstatus == '0' )
                {
                    markup += `<i class="fa fa-check " ></i>
                    </span> `;
                    addMrakup(markup,mainDiv);
                }
                else{
                            markup += `<i class="fa fa-check read-tick" ></i>
                            <i class="fa fa-check second-tick read-tick"  ></i>
                            </span> `;
                            addMrakup(markup,mainDiv);
                    }
           }
           else
           {
            
            addMrakup(markup,mainDiv);
            
           }
}

// Recieve msg
socket.on('messagesend',(msg)=>{
    
   appendMessage(msg,'incoming');
    scrollToBottom();
   });
function scrollToBottom(){
    messageArea.scrollTop = messageArea.scrollHeight;
}

// Emoji
function emojies(){
    var emojiarea = document.querySelector(".emojiarea");
        
    fetch("https://gist.githubusercontent.com/housamz/67087a81eaf78837a420fdef4accf263/raw/8c6a8bd28af5431f8ad394d433bd2ae201ec4bf9/emojis.json")
    .then((response)=>response.json())
    .then((data)=>{
        
            for(var j = 0 ; j<data.emojis.length ; j++)
            {
                var value = data.emojis[j]["data-emoji"];
                var emoji = `<a onclick='getEmoji("`+value+`")'>`+data.emojis[j]["data-emoji"]+"</a>";
                 emojiarea.innerHTML += emoji+"  ";
            }
            
            $(".emojiarea")[0].removeAttribute("style");
            $(".emojiarea")[0].classList.add("fadeIn");
            document.querySelector(".fa-smile-beam").style.display = "none";
            document.querySelector(".fa-times").removeAttribute("style");
            });
   
}

function getEmoji(emoji){
    textarea.value += emoji;
}



function removeEmojis(){
    $(".emojiarea")[0].style.display = "none";
    $(".emojiarea")[0].classList.add("fadeOut");
    document.querySelector(".fa-times").style.display = "none";
    document.querySelector(".fa-smile-beam").removeAttribute("style");
}


// Image preview

function chooseImage(){
    
    const defaultFile = document.getElementById("fileInput");
    defaultFile.click();
}

function sendImage(value)
{
    var file = value.files[0];
    if (!file.type.match("image.*")) {
        alert("Plase select image file");
    }
    else{
        let currentDate = new Date();
let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
        var formData = new FormData();
formData.append( 'file', file );
formData.append( 'senderId', senderId );
formData.append( 'receiverId', receiverId );
formData.append('time',time);
      
        $.ajax({
            url:  '/uploadImages',
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(data) {
                  if(data)
                  {
                        var fileReader = new FileReader();

                      fileReader.addEventListener("load", function(){
                          var preview_img = document.getElementById("preview_img");
                          var preview_text = document.getElementById("preview_text");
                          preview_img.style.display = "block";
                      preview_text.style.display = "none";
                  
                      preview_img.setAttribute("src", this.result);
                      document.getElementById("popupForm").style.display = "block";
                      imageContents.push(this.result);
                      data.message = (data.message).replace(" ","_");
                      var image  = `<img src="/images/ChatImage/${data.message}" class="image"></img>`;
                      textarea.value = image;
                      
                  },false)
                  if(file)
                  {
                     fileReader.readAsDataURL(file);
                    }
                }
                
                },
                error: function(data) {
                    alert("Sorry start server first..");
                },
                cache: false,
                contentType: false,
                processData: false,
            });
       
}
    
}

// File upload

function chooseDocument(){
    
    const defaultFile = document.getElementById("fileInput2");
    defaultFile.click();
}
      
let icons_url = {
  'xlsx' : 'https://img.icons8.com/color/48/000000/ms-excel.png',
  'pdf' : 'https://img.icons8.com/color/50/000000/pdf.png',
  'docx' : 'https://img.icons8.com/color/48/000000/word.png',
  'txt' : 'https://tse2.mm.bing.net/th?id=OIP.AnLDKCxGST8WS62C-dB9fwHaHa&pid=Api&P=0&w=201&h=201',
};

function get_extenstion( file ){
  return file.name.split( "." )[1];
}
async function sendDocument( value ){
    var files = value.files[0];
    let currentDate = new Date();
    let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
    var formData = new FormData();
  formData.append( 'file', files );
  formData.append( 'senderId', senderId );
  formData.append( 'receiverId', receiverId );
  formData.append('time',time);
  $.ajax({
      url:  '/uploadDocument',
      type: "POST",
      data: formData,
      dataType: "json",
      success: function(data) {
            if(data)
            {
           var extension = get_extenstion( files );
               var object_url = icons_url[extension];
              var fileReader = new FileReader();
              fileReader.addEventListener("load", function (){
                var fileContent = `
                <a href="/Documents/${data.message}" download="${data.message}"> 
                <img src="${object_url}" class="img-small" >
                </a>
                <p>${data.message}</p>
             `;
             documentContents.push(this.result);
             var image_template = document.getElementById('image-template');
             image_template.innerHTML = "";
               var div = document.createElement('DIV');
            
                    div.innerHTML = `
                    <button type="submit" class="fileSendbtn" onclick="sendmsg()">Send</button>
                    <br>
                    <img src="${object_url}" class="img-small" >
                                       <p>${data.message}</p>
                                       `;
                    image_template.style.display = "block";
                    image_template.appendChild( div );
                    textarea.value = fileContent;
              },false)
              if(files)
              {
                 fileReader.readAsDataURL(files);
                }
                
            }
          },
          error: function(data) {
            alert( 'Sorry,Start the server first' );
          },
      cache: false,
      contentType: false,
      processData: false,
          });
  
  
  }




// Message Search

function heighlightAnimation(container,origcolor,object)
{
    if(object == "attachment")
    {
    var t = setTimeout(function(){
        container.style.backgroundColor = origcolor;
     },(3*1000));
    }
    else{
        var t = setTimeout(function(){
            $('.highlight').removeClass('highlight');
         },(4*1000));
    }
}

function searchMsg(){
    document.getElementById("input-wrapper").style.display = "block";
    $("#keyword").focus();
}
// $('#keyword').on("keyup",function(e){
// })
function search(){
    var keyword = $("#keyword").val();
    searchHighligh(keyword);
}

function scrollElement()
{
    var scrollDiv = document.querySelectorAll(".highlight");
    if(scrollDiv.length > 0)
    {
        scrollDiv[0].setAttribute("id","firstSelectedMsg");
    document.getElementById('scrolling_div').scrollIntoView();
    document.getElementById('firstSelectedMsg').scrollIntoView();
    }
   
    document.getElementById("input-wrapper").style.display = "none";
    document.getElementById("input-wrapper").value="";
}

 function searchHighligh(keyword){
if(keyword){
            var messages = document.querySelectorAll(".message p");
            if(messages.length != 0)
            {
                for(var i = 0 ;i<messages.length ; i++)
                {
                    var content = messages[i].innerHTML;
                    var container = messages[i].parentNode;
                   
                   
                
                if(!content.includes("base64") )
                {
                    var matches = content.includes(keyword);
            if(matches){
               
                var length = keyword.length;
                var index = content.indexOf(keyword);
                if(index > 0)
                {
                    
                    content = content.substring(0,index) + "<span class='highlight'>" + keyword + "</span>" + content.substring(index+length,content.length);
                    messages[i].innerHTML = content;
                    container.appendChild(messages[i]);
                    scrollElement();
                    
                    
                     }
                else{
                    content = "<span class='highlight'>" + keyword + "</span>" + content.substring(index+length,content.length);
                    messages[i].innerHTML = content;
                    container.appendChild(messages[i]);
                    const origcolor =  container.style.backgroundColor;
                    heighlightAnimation(container,origcolor,"messagecontent");
                    scrollElement();
                }

                
            }
            else{
                $('.highlight').removeClass('highlight');
                document.getElementById("input-wrapper").style.display = "none";

            }
        }
        else{
            // continue;
            if(content.includes("pdf") || content.includes("word") || content.includes("txt")  || content.includes("xlsx"))
            {
                var file = messages[i].children[0].href;
                var fileContent = file.split(",")[1];
                if(atob(fileContent).includes(keyword))
                {
                const origcolor =  container.style.backgroundColor;
                 container.style.backgroundColor = "lightblue";
                  heighlightAnimation(container,origcolor,"attachment");
                  scrollElement();
                }
        } 
        }
            
            }
        }
        else{
            alert("Please Start chatting first");
            search();
            $("#textarea").focus();
        }
 }
    }
    
  
    // Video streaming

    function chooseVideo(){
    
        const defaultFile = document.getElementById("chosen");
        defaultFile.click();
        }
    
    function openPlayer(value){
    var files = value.files[0];
    let currentDate = new Date();
let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
var formData = new FormData();
formData.append( 'file', files );
formData.append( 'senderId', senderId);
formData.append( 'receiverId', receiverId);
formData.append('time',time);
$.ajax({
  url:  '/uploadVideoFile',
  type: "POST",
  data: formData,
  success: function(data) {
        if(data)
        {
            var video_step = document.getElementById("video-step");
            video_step.innerHTML = "";
          
            var fileReader = new FileReader();
    
              fileReader.addEventListener("load", function (){
              var videocontent = `
             <video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
              <source src="/Videos/${data.message}"  type="video/mp4" />
              </video>
           `;
          videoContents.push(this.result);
          div = document.createElement('DIV');
          div.innerHTML = `
                  <button type="submit" class="fileSendbtn" onclick="sendmsg()">Send</button>
                  <br>
                  <video id="player"  width="320" height="240" preload  controls autoplay  muted >
                  <source src="${this.result}" type="video/mp4"/></video>
                   `;
                  video_step.style.display = "block";
                  video_step.appendChild( div );
                  textarea.value = videocontent;
             
          
              } ,false)
           if(files)
           {
              fileReader.readAsDataURL(files);
             }
        }
        else{
            alert("Try again");
        }
  },
  error: function(data) {
    alert( 'Sorry,Start server first.' );
  },
  cache: false,
  contentType: false,
  processData: false,
});

  
}


  

// Get previous messages
function loadMessages(senderId,receiverId)
{
    var data = {
        'senderId' : senderId,
        'receiverId'  :receiverId
    };
    var jsondata  = JSON.stringify(data);
 fetch("/api/loadMessages",{
    method : 'POST',
    body : jsondata,
    headers : {
      'Content-Type' :'application/json',
    } 
 })
 .then((response)=>response.json())
 .then((data)=>{
     var messages = data.messages;
     for(i=0 ; i < messages.length ; i++)
     {
          if(messages[i].Sender == senderId)
          {
            if(!messages[i].Messages.includes(".mp4"))
            {
                if(messages[i].Messages.includes("pdf") || messages[i].Messages.includes("xlsx")|| messages[i].Messages.includes("docx") ||  messages[i].Messages.includes("txt"))
                {
                    var object_url = icons_url[messages[i].Messages.split(".")[1]];
                    var fileContent = `
                    <a href="/Documents/${messages[i].Messages}" download="${messages[i].Messages}"> 
                    <img src="${object_url}" class="img-small" >
                    </a>
                    <p>${messages[i].Messages}</p>
                 `;

                    var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
           let data = {
               user : name2,
               senderId : messages[i].Sender,
               message: fileContent,
               receiverId : messages[i].Receiver,
               time : time,
               msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
               _token : csrf,
       
           }
           
               appendMessage2(data,'outgoing');
                }
                else if(messages[i].Messages.includes(".jpeg") || messages[i].Messages.includes(".jpg") ||messages[i].Messages.includes(".svg") || messages[i].Messages.includes(".png"))
                {
                    var imgContent = `
                    <img src='/images/ChatImage/${messages[i].Messages}' class='image'></img> `;

                    var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
           let data = {
               user : name2,
               senderId : messages[i].Sender,
               message: imgContent,
               receiverId : messages[i].Receiver,
               time : time,
               msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
               _token : csrf,
       
           }
           
               appendMessage2(data,'outgoing');
                }
                else
                {
                var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
           let data = {
               user : name2,
               senderId : messages[i].Sender,
               message: messages[i].Messages,
               receiverId : messages[i].Receiver,
               time : time,
               msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
               _token : csrf,
       
           }
           
               appendMessage2(data,'outgoing');
        }
           }
           else{
               var videocontent =  `<video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
               <source src="/Videos/${messages[i].Messages}"  type="video/mp4" />
               </video>
            `;
            // ${messages[i].Messages}
            var time = messages[i].created_at.split('T')[1];
            time = time.substring(0,5);
               let data = {
                   user : name2,
                   senderId : messages[i].Sender,
                   message: videocontent,
                   receiverId : messages[i].Receiver,
                   time : time,
                   msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
                   _token : csrf,
           
               }
               
                   appendMessage2(data,'outgoing');
                
           }
          }
          else if(messages[i].Sender == receiverId)
          {
            if(!messages[i].Messages.includes(".mp4"))
            {
                if(messages[i].Messages.includes("pdf") || messages[i].Messages.includes("xlsx")|| messages[i].Messages.includes("docx") ||  messages[i].Messages.includes("txt"))
                {
                    var object_url = icons_url[messages[i].Messages.split(".")[1]];
                    var fileContent = `
                    <a href="/Documents/${messages[i].Messages}" download="${messages[i].Messages}"> 
                    <img src="${object_url}" class="img-small" >
                    </a>
                    <p>${messages[i].Messages}</p>
                 `;

                    var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
           let data = {
               user : name2,
               senderId : messages[i].Sender,
               message: fileContent,
               receiverId : messages[i].Receiver,
               time : time,
               msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
               _token : csrf,
       
           }
           
               appendMessage2(data,'outgoing');
                }
                else
                {
                var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
            let data = {
                user : receivername2,
                senderId : messages[i].Sender,
                message: messages[i].Messages,
                receiverId : messages[i].Receiver,
                time:time,
                msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
                _token : csrf,
        
            }
            appendMessage2(data,'incoming');
        }
           
            }
            else{
                var videocontent =  `<video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
                <source src="/Videos/${messages[i].Messages}"  type="video/mp4" />
                </video>
             `
             var time = messages[i].created_at.split('T')[1];
             time = time.substring(0,5);
                let data = {
                    user : receivername2,
                    senderId : messages[i].Sender,
                    message: videocontent,
                    receiverId : messages[i].Receiver,
                    time:time,
                    msgstatus : messages[i].Message_Read,
               notifications :messages[i].Notifications,
                    _token : csrf,
            
                }
                
                    appendMessage2(data,'incoming');
                    
            }
          }
     }
 })
 .catch((error)=>{
     console.log(error);
 })
}
    loadMessages(senderId,receiverId);

   function appendMessage2(data,type)
{
    let mainDiv = document.createElement('div');
    let className = type;
    mainDiv.classList.add(className,'message');
    

    var msg  = data.message;
    
    var status = userstatus;
    var msgstatus = data.msgstatus;
    var notifications = data.notifications;
    if(msg.includes("http") || msg.includes("https"))
    {
        if(!msg.includes("img"))
        {
        
           let markup = `
        
    <span><h4>${data.user}</h4></span?
    <p class="mb-0"><a target="_blank" href="${msg}" style="color:#1d7a8c" >${msg}</a>
    <br><span class="timeSpan">${data.time}`;
    tickmarkLogic(type,msgstatus,markup,mainDiv);
    }
    else{
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">${msg}
        <br><span class="timeSpan">${data.time}`;
        tickmarkLogic(type,msgstatus,markup,mainDiv);
    }
       
    }
    
   else{
            let markup = `
            <h4>${data.user}</h4>
            <p class="mb-0">${msg}
            <br><span class="timeSpan">${data.time} `;
            tickmarkLogic(type,msgstatus,markup,mainDiv);
        }
}


// Change User status
// document.addEventListener("visibilitychange", (event) => {
//         if (document.visibilityState == "visible") {
//            //  Set status online
//           var answer = changeStatus(1);
//           if(answer == '1')
//           {
//             var status2 = document.getElementById('status2');
//             status2.style.display = "none";
//             document.getElementById('status1').style.display = "block";
          
//           }
//           else
//           {
//             var status2 = document.getElementById('status2');
//             status2.style.display = "block";
//             document.getElementById('status1').style.display = "none";

//           }
        

//         } 
//         else {
//            // Set status offline
//             var answer = changeStatus(0);
//             if(answer == '1')
//           {
//             var status2 = document.getElementById('status2');
//             status2.style.display = "block";
//             document.getElementById('status1').style.display = "none";
          
//           }
//           else
//           {
//             var status2 = document.getElementById('status2');
//             status2.style.display = "none";
//             document.getElementById('status1').style.display = "block";
//           }
           
        
//         }
//       });

      
      function changeStatus(status)
      {
        var data = {
            'name': name,
            'status': status
        };
       $.ajax({
            url:  '/changeStatus',
            type: "POST",
            dataType: "json",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            
            success: async (data) => {
                // return data;
                var status2 = document.getElementById('status2');
                if(data == '1')
                {
                    if(status2.style.display = "none")
                    {
                        document.getElementById('status2').style.display = "block";
                        document.getElementById('status1').style.display = "none";
                    }
                    else
                    {
                        document.getElementById('status1').style.display = "block";
                        document.getElementById('status2').style.display = "none";
                    }
                }
                
            
            

            }
        });

      }

      async function getMessageStatus(data)
      {
        let currentDate = new Date();
        let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
        var data = {
            'senderId': data.senderId,
            'receiverId': data.receiverId,
            'message': data.message,
            'time':time
        };
       return fetch('/getMessageStatus',{
           method:"POST",
           body:JSON.stringify(data),
           headers:{
            'Content-Type' :'application/json',
           }
       })
       .then((response)=>response.json())
       .then((data)=>{
          return data;
       })
       .catch((error)=>{
           console.log(error);
       });
      }

    