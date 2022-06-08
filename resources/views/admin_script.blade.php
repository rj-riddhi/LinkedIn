<script>
    document.getElementById("dashli").classList.add("active");
    document.getElementById("chartli").classList.remove("active");
    document.getElementById("actli").classList.remove("active");
    document.getElementById("calli").classList.remove("active");
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
				$('#content').toggleClass('active');
            });
			
			 $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });
			
        });
        
        function getInfo(id)
        {
            var data = {
                'id':id
            };
            fetch("/api/getUserData",{
                method : 'POST',
                body : JSON.stringify(data),
                headers : {
                    'Content-Type' :'application/json',
                } 
                })
            .then((response)=>response.json())
            .then((data)=>{
                document.getElementById("first_card").innerHTML = 'Incoming Requests';
                document.getElementById("first_card_count").innerHTML = data['incomingRequests'].length;
                document.getElementById("second_card").innerHTML = 'Outgoing Requests';
                document.getElementById("second_card_count").innerHTML = data['outgoingRequests'].length;document.getElementById("third_card").innerHTML = 'Connections';
                document.getElementById("third_card_count").innerHTML = data['connections'].length;
                document.getElementById("fourth_card_count").innerHTML = data['chats'].length;
                
            })
            .catch((error)=>{
                console.log(error);
            })
            
        }

        function edit(id)
        {
            
            var element = document.getElementById(id);
            element.setAttribute("data-toggle","modal");
            element.setAttribute("data-target","#myModal");

            // Set Hading
            document.getElementById("model-heading").innerHTML = id;
            // Add current profile image
            var currentImage = document.getElementById(id).parentNode.previousElementSibling.getElementsByTagName("img")[0].src;
            document.getElementById("avtarimg").setAttribute("src",currentImage);

            
        }

        function addImage()
        {
            var profile = document.getElementById("profileImage");
            profile.click();
        }
         var profileImage = document.getElementById("profileImage");
         profileImage.addEventListener("change",function(){
            var form = document.getElementById("form");
             const selectedFile = profileImage.files[0];
  var formdata = new FormData();
  formdata.append("profile",selectedFile);
             fetch("/api/UploadProfile",{
    method : 'POST',
        body : formdata,
         })
    .then((response)=>response.text())
    .then((data)=>{
        var count = 1;
        var total = document.getElementsByClassName("profiles").length;
        if(total > 1)
        {
          var image = document.createElement("div");
          image.classList.add("hidden-img");
          image.innerHTML = "+"+count;
          count++;
        }
        else
        {
        var image = document.createElement("img");
        image.setAttribute("src"," http://localhost:8000/images/Profiles/"+data);
        image.classList.add("profiles");
        }
        var span = document.createElement("span");
        document.getElementById("add_circle").remove();
        span.classList.add("material-icons");
        span.id = "add_circle";
        span.setAttribute("onclick","addImage()");
        span.innerHTML = "add_circle";
        form.appendChild(image);
        form.appendChild(span);
        
      })
            
        });
        var i = 0;
        function addressadd(elem)
        {
            var color = ['red','blue','pink'];
            if(i == 3)
              i=0;
            
            var div = document.createElement("div");
            div.classList.add("input-group","mb-2","col-md-12","text-center","d-flex");
            div.innerHTML = `<input class="form-control" type="text" placeholder="address line ..."/>
                <div class="input-group-prepend">
                    <div class="input-group-text" style="background-color:${color[i]}"><span class="material-icons address_add"  onclick="addressadd(this)">add_circle</span></div>
                </div>`;
             i++;
            var parent = elem.parentNode.parentNode.parentNode;
            parent.insertAdjacentElement('afterend', div);
        }

       



</script>