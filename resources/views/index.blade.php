<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Chat App</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

       <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- External css -->
<link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}" media="screen" />
       <!-- <link rel="stylesheet" type="text/css" href="./style.css" media="screen" /> -->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
       <link rel="stylesheet" type="text/css" href="https://cdn.tutorialjinni.com/emojionearea/3.4.2/emojionearea.min.css" />
<script src="https://cdn.tutorialjinni.com/emojionearea/3.4.2/emojionearea.min.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

      
   </head>
    <body>

        <section class="chat_section">
           <div class="brand" >
               <div class="row">
                <div class="col-3 ">
                  <img  id="dpImage" />
                 </div>
                 <div class="col-9 ">
                  <h1 id="receiverName" class="m-0"></h1>
                  <span id="status1"><i class="fa fa-circle online" ></i> online</span>
                  <span id="status2"><i class="fa fa-circle offline" ></i> offline</span>
                </div>
               </div>
               
               
               
                <div class="links">
                </div>
               </div>
               <div class="form-group input-wrapper" id="input-wrapper">
              <input type="text" class="form-control" id="keyword" placeholder="Search here.."/>
              <span class="span"><i class="fa fa-search"  aria-hidden="true" onclick="search()"></i></span>
              
            </div>
            <div class="message_area" id="scrolling_div">
            </div> 
             <div class="emojiarea" style="display: none;" ></div>
             

              <div class="loginPopup">
                <div class="formPopup" id="popupForm">
                  <div class="formContainer">
                      
                    <div class="preview_holder">
                        <div id="preview">
                          <img src="" id="preview_img" class="preview_img" />
                          <span id="preview_text" class="preview_text">File Preview</span>
                          </div>
                      </div>
                      <button type="submit" class="message-submit" onclick="sendmsg()">Send</button>
                </div>
                </div>
              </div>


              <div id="image-template"  ></div>
             

               <div id="video-step" class="embed-responsive embed-responsive-4by3">
               <video src=""></video>
               </div>
            <div class="message-box">
                <i class="fas fa-camera" onclick='chooseImage()'></i>
                <input type="file" id="fileInput" onchange="sendImage(this)" accept="image/*" hidden="hidden" />
                <i class="fas fa-video" onclick="chooseVideo()"></i>
                <!-- <form action="/single" method="POST" enctype="multipart/form-data" style="display:none"> -->
                 <input type="file" id="chosen" name="video" onchange="openPlayer(this)"  accept="video/*" hidden="hidden" />
                 <!-- <button type="submit" id="videoForm" hidden="hidden">Submit</button>
                </form> -->
                <i class='fas fa-smile-beam' onclick='emojies()'></i>
                <i class="fas fa-times" onclick="removeEmojis()" style="display:none"></i>
                <i class="fa fa-paperclip attachment" aria-hidden="true" onclick='chooseDocument()'></i>
                <input type="file" id="fileInput2" name="file" onchange="sendDocument(this)" hidden="hidden" />
                <!-- <input type="file" id="fileInput2" onchange="searchInsideDocument()" hidden="hidden" /> -->
                <i class="fa fa-search" aria-hidden="true" onclick="searchMsg()"></i>
               
  
  

  

                    <textarea type="text" class="message-input" id="textarea" placeholder="Type message..."></textarea>
                    <button type="submit" class="message-submit" onclick="sendmsg()">Send</button>
                    
               
                  </div>
        </section>
        <!-- <script src="http://127.0.0.1:8000/socket.io/socket.io.js"></script> -->

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    

        <script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
        <!-- <script src="https://rawgit.com/theraot/emoji/master/emoji.js" charset="utf-8"></script> -->
        <script src="{{ url('js/client.js') }}" async defer></script>
       
    </body>
</html>