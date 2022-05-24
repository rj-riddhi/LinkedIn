<script>
// const params = new URLSearchParams(window.location.search);

// let name = params.get("name");
let name = `{{$name}}`;
var senderId  = `{{$senderId}}`;
let name2 = name.split(" ")[0];

let receivername = `{{$name2}}`;
receivername2 = receivername.split(" ")[0];
var receiverId = `{{$receiverId}}`;

let csrf = `{{$csrf}}`;
var jsondata = JSON.stringify(receivername);

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
    document.getElementById("dpImage").setAttribute("src",`{{url('images/Profiles/${data}')}}`);
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
    return data.Status;
    })
.catch((error)=>{
    console.log(error);
});
}
getUserStatus();

var dashboardlink = `<a class="nav-links" href="/welcome/`+name+`">Dashboard</a>
                     <a class="nav-links" href="/connections/`+name+`">Connections</a>
                     <a class="nav-links" href="/logout" >Logout</a>`;
document.querySelector(".links").innerHTML += dashboardlink;
const socket = io.connect('localhost:8000'); 
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
        let data = {
            user:name2,
            senderId : senderId,
            message: msg.trim(),
            time : time,
            receiverId : receiverId,
            _token : csrf,
    
        }
        appendMessage(data,'outgoing');
        // getMessageStatus(data);
        
        // console.log(data);
   socket.emit('messagereceive',data);
    // var msgstatus = getMessageStatus(data);
     
    

}

function appendMessage(data,type)
{
    let mainDiv = document.createElement('div');
    let className = type;
    mainDiv.classList.add(className,'message');
    

    var msg  = data.message;
    // var status = getUserStatus();
    
    if(msg.includes("http") || msg.includes("https"))
    {
        if(!msg.includes("img"))
        {
        
           let markup = `
        
    <span><h4>${data.user}</h4></span?
    <p class="mb-0"><a target="_blank" href="${msg}" style="color:#1d7a8c" >${msg}</a>
    <br><span class="timeSpan">${data.time}
    <i class="fa fa-check " aria-hidden="true"></i>
    <i class="fa fa-check second-tick " aria-hidden="true" ></i>
    </span></p>`;
    
    addMrakup(markup,mainDiv);
    }
    else{
        let markup = `
        <h4>${data.user}</h4>
        <p class="mb-0">${msg}
        <br><span class="timeSpan">${data.time}
        <i class="fa fa-check " aria-hidden="true"></i>
    <i class="fa fa-check second-tick " aria-hidden="true" ></i>
    </span></p>`;
        addMrakup(markup,mainDiv);
    }
       
    }
   else{
            let markup = `
            <h4>${data.user}</h4>
            <p class="mb-0">${msg}
            <br><span class="timeSpan">${data.time} `;
            // var msgstatus = getMessageStatus(data);
    // console.log();
           if(type == 'outgoing')
           {
            if(data.status == '0')
                    {
                        markup += `<i class="fa fa-check " aria-hidden="true"></i>
                        </span> </p>`;
                        addMrakup(markup,mainDiv);
                    }
                    else
                    {
                    if(data.status == '1')
                    {
                        markup += `<i class="fa fa-check " aria-hidden="true"></i>
                        <i class="fa fa-check second-tick " aria-hidden="true" ></i>
                        </span> </p>`;
                        addMrakup(markup,mainDiv);
                        
                    }
                    else
                    {
                        markup += `<i class="fa fa-check read-tick" aria-hidden="true"></i>
                        <i class="fa fa-check second-tick read-tick" aria-hidden="true" ></i>
                        </span> </p>`;
                        addMrakup(markup,mainDiv);
                    }
                    }
           }
           else
           {
            
            addMrakup(markup,mainDiv,data);
            
           }
        }
}

function addMrakup(markup,mainDiv,data)
{
    mainDiv.innerHTML = markup;
    messageArea.appendChild(mainDiv);
    textarea.value = '';

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
    // var emojiCount = emoji.length;
        
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
    // console.log(file);
    if (!file.type.match("image.*")) {
        alert("Plase select image file");
    }
    else{
        var fileReader = new FileReader();

    fileReader.addEventListener("load", function (){
        preview_img.style.display = "block";
    preview_text.style.display = "none";

    preview_img.setAttribute("src", this.result);
    document.getElementById("popupForm").style.display = "block";
    var image  = `<img src='${this.result}' class='image'></img>`;
    textarea.value = image;
    } ,false)
    
    if(file)
    {
        fileReader.readAsDataURL(file);
    }
}
    
}

// File upload

function chooseDocument(){
    
    const defaultFile = document.getElementById("fileInput2");
    defaultFile.click();
}


let image_template = document.getElementById('image-template');
        
let icons_url = {
  'xlsx' : 'https://img.icons8.com/color/48/000000/ms-excel.png',
  'pdf' : 'https://img.icons8.com/color/50/000000/pdf.png',
  'docx' : 'https://img.icons8.com/color/48/000000/word.png',
  'txt' : 'https://tse2.mm.bing.net/th?id=OIP.AnLDKCxGST8WS62C-dB9fwHaHa&pid=Api&P=0&w=201&h=201',
};

function get_extenstion( file ){
  return file.name.split( "." )[1];
}

function sendDocument( value ){
  let files = value.files[0];
  let object_url = null, div = null, extension=null;

  image_template.innerHTML = "";


  var fileReader = new FileReader();
extension = get_extenstion( files );
    object_url = icons_url[extension];
   
    fileReader.readAsDataURL(files);

    fileReader.addEventListener("load", function (){
    var fileContent = `
    <a href="${this.result}" download="${files.name}"> 
    <img src="${object_url}" class="img-small" >
    </a>
    <p>${files.name}</p>
 `;

    div = document.createElement('DIV');

        div.innerHTML = `
        <button type="submit" class="fileSendbtn" onclick="sendmsg()">Send</button>
        <br>
        <img src="${object_url}" class="img-small" >
                           <p>${files.name}</p>
                           `;
        image_template.style.display = "block";
        image_template.appendChild( div );
        textarea.value = fileContent;
   
       } ,false);
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

                   
                
                if(!content.includes("base64"))
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
            if(content.includes("pdf") || content.includes("word") || content.includes("txt") )
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

        // document.getElementById("videoForm").click();
    
    // var fdata = new FormData();
    var files = value.files[0];

var formData = new FormData();
formData.append( 'file', files );
formData.append( 'senderId', senderId);
formData.append( 'receiverId', receiverId);
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
              <source src="${this.result}"  type="video/mp4" />
              </video>
           `;
          
          div = document.createElement('DIV');
          
                  div.innerHTML = `
                  <button type="submit" class="fileSendbtn" onclick="sendmsg()">Send</button>
                  <br>
                  <video id="player"  width="320" height="240" preload  controls   muted >
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
    alert( 'Sorry.' );
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
            if(!messages[i].Messages.includes("./Videos"))
            {
                var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
           let data = {
               user : name2,
               senderId : messages[i].Sender,
               message: messages[i].Messages,
               receiverId : messages[i].Receiver,
               time : time,
               _token : csrf,
       
           }
           
               appendMessage(data,'outgoing');
           }
           else{
               var videocontent =  `<video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
               <source src="${messages[i].Messages}"  type="video/mp4" />
               </video>
            `;
            var time = messages[i].created_at.split('T')[1];
            time = time.substring(0,5);
               let data = {
                   user : name2,
                   senderId : messages[i].Sender,
                   message: videocontent,
                   receiverId : messages[i].Receiver,
                   time : time,
                   _token : csrf,
           
               }
               
                   appendMessage(data,'outgoing');
                //    getMessageStatus(data);
           }
          }
          else if(messages[i].Sender == receiverId)
          {
            if(!messages[i].Messages.includes("./Videos"))
            {
                var time = messages[i].created_at.split('T')[1];
                time = time.substring(0,5);
            let data = {
                user : receivername2,
                senderId : messages[i].Sender,
                message: messages[i].Messages,
                receiverId : messages[i].Receiver,
                time:time,
                _token : csrf,
        
            }
            appendMessage(data,'incoming');
            // getMessageStatus(data);
            }
            else{
                var videocontent =  `<video id="player"  width="320" height="240" preload  controls  autoplay  width="320" height="320" muted >
                <source src="${messages[i].Messages}"  type="video/mp4" />
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
                    _token : csrf,
            
                }
                
                    appendMessage(data,'incoming');
                    // getMessageStatus(data);
            }
          }
     }
 })
 .catch((error)=>{
     console.log(error);
 })
}
    loadMessages(senderId,receiverId);


// Change User status
// document.addEventListener("visibilitychange", (event) => {
//         if (document.visibilityState == "visible") {
//            //  Set status online
//         //   changeStatus(1);
//             var status2 = document.getElementById('status2');
//           status2.style.display = "none";
//           document.getElementById('status1').style.display = "block";

//         } 
//         else {
//            // Set status offline
//             // changeStatus(0);
//            var status2 = document.getElementById('status2');
//             status2.style.display = "block";
//             document.getElementById('status1').style.display = "none";
//         }
//       });

      
      function changeStatus(status)
      {
       $.ajax({
            url:  '/changeStatus',
            type: "POST",
            data: {
                'name': name,
                'status': status,
                },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                return data;
            }
        });

      }

      function getMessageStatus(data)
      {
        let currentDate = new Date();
        let time = currentDate.getHours() + ":" + currentDate.getMinutes() ;
        var data = {
            'senderId': data.senderId,
            'receiverId': data.receiverId,
            'message': data.message,
            'time':time
        };
        $.ajax({
            url:  '/getMessageStatus',
            type: "POST",
            dataType: "json",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            complete: function(data) {
                
                console.log(data);
                // return data;
               
            }
        });
        
        
      }

    </script>