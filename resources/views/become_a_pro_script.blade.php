<script>

  document.getElementById("addTech").onclick = function() {
	var form = document.getElementById("myForm");
  var count = document.querySelectorAll(".input-wrapper");
  var list = document.getElementsByClassName("col-md-3");
  for(var i = 0 ; i<list.length ; i++)
  {
    if(list[i].value == "")
    {
      show_msg("error","Please enter technology in current feild");
  	return false;
    }
    if(i !=0 )
    {
      for(var j = i-1 ; j>=0 ; j--)
      {
    if(list[i].value.toLowerCase().replace(/\s/g, '') == list[j].value.toLowerCase().replace(/\s/g, ''))
    {
      show_msg("error","Please enter  different technology ");
  	return false;
    }
  }
    }
  }if(count.length > 19)
  {
    show_msg("error","Max limit is 20 technologies");
  	return false;
  }
  else{
	var input = document.createElement("input");
  var element = document.createElement("div");
  element.classList.add("input-group-prepend");
  
  var element2 = document.createElement("div");
  element2.classList.add("input-group-text","input-wrapper",count.length);
  element2.style.cursor="pointer";
  element2.onclick = function() { 
    var classnumber = element2.classList[2];
   
   var node  = document.getElementsByClassName(classnumber);
   
   node[0].remove();
   node[1].remove();
   node[2].remove();
  };
  element2.classList.add("mr-2");
  element2.innerHTML = "X";
  element.appendChild(element2);
  input.type = "text";
  input.classList.add("form-control","col-md-3",count.length);
  element.classList.add(count.length);
  form.appendChild(input);
  form.appendChild(element);
  }
    }
    
  
function checkStrongPass(value){
  var pass = value;
  var passmatch = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,14}$/;
  if(!pass.match(passmatch)){
    show_msg("error","Please Enter strong Password which contains Password must contain at least 1 capital letter, 1 small letter, 1 number and one special character. Password length must be in between 6 to 14 characters.");
    $("#password1").focus();
    return false;
  }
}

function selectImage(){
  var profile = document.getElementById("profileImage");
  profile.click();


}

$(document).on("change","#profileImage",(e)=>{
  var profile = document.getElementById('profileImage');
  const selectedFile = profile.files[0];
  var formdata = new FormData();
  formdata.append("profile",selectedFile);
  fetch("/api/UploadProfile",{
    method : 'POST',
        body : formdata,
         })
    .then((response)=>response.text())
    .then((data)=>{
      var image = document.getElementById("avtarimg");
      image.src = "images/Profiles/"+data;
      })
 
});

function userType(value)
{
    if(value == 'Admin')
    {
      var ele = document.getElementsByClassName('tech');
      for(var i = 0 ; i<ele.length ; i++)
      {
        ele[i].disabled = true;
      }
    }
}

$(document).on("click","#custregisterbtn",(e)=>{
  
  let currentDate = new Date();
  let datearr = currentDate.toLocaleDateString().split("/");
    let date = datearr[2] + "-" + datearr[0]+ "-" + datearr[1];
  
  var profile = document.getElementById("avtarimg").src;
  if(profile == "https://cdn2.iconfinder.com/data/icons/user-people-4/48/5-512.png"){
    show_msg("error","Please set your profile Image");
    $("#avtarimg").focus();
    return false;
  }
  profile = profile.split("Profiles/")[1];
  var firstname = document.getElementById('inputFirstName').value;
  var lastname = document.getElementById('inputLastName').value;
  var email = document.getElementById('email').value;
  var phone = document.getElementById('phone1').value;
  var pass = document.getElementById('password1').value;
  var user_type = document.getElementById("user_type").value;
  
  var confirmpass = document.getElementById('password2').value;
  var termsCheckBox = document.getElementById('invalidCheck2');
  
  
  if(firstname==""){
    show_msg("error","Please fill FirstName");
    $("#inputFirstName").focus();
    return false;
  }
  document.getElementById('inputFirstName').value = firstname;
  if(lastname==""){
    show_msg("error","Please fill LastName");
    $("#inputLastName").focus();
    return false;
  }
  document.getElementById('inputLastName').value = lastname;
  if(email==""){
    show_msg("error","Please Enter Emaill");
    $("#email").focus();
    return false;
  }
  

  var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  if(!email.match(validRegex)){
    show_msg("error","Please Enter Valid Emaill in the form of abc@gmail.com");
    $("#email").focus();
    return false;
  }
  document.getElementById('email').value = email;
  if(phone==""){
    show_msg("error","Please Phone number");
    $("#phone1").focus();
    return false;
  }
  if(phone.length < 10){
    show_msg("error","Phone number feild should have 10 digits");
    $("#phone1").focus();
    return false;
  }
  document.getElementById('phone1').value = phone;
   
  var passmatch = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,14}$/;
  if(pass==""){
    show_msg("error","Enter password");
    $("#password1").focus();
    return false;
  }
  if(!pass.match(passmatch) )
  {
    show_msg("error","Please Enter strong Password which contains at least 1 capital letter, 1 small letter, 1 number and one special character. Password length must be in between 6 to 14 characters.");
    $("#password1").focus();
    return false;
  }
  document.getElementById('password1').value = pass;
  if(pass != confirmpass){
    show_msg("error","Confirm password is not matched ");
    $("#password2").focus();
    return false;
  }
if(user_type == 'Type')
{
  show_msg("error","Select User Type ");
    $("#user_type").focus();
    return false;
}
  if(termsCheckBox.checked != true){
    show_msg('error' , '✔ Please accept terms & Conditions ');
    $("#invalidCheck2").focus();
    return false;

  }
  var tech = document.getElementsByClassName("col-md-3");
  const arr = [];
  for(var i = 0 ; i<tech.length ; i++)
  {
    arr[i] = tech[i].value.toLowerCase().replace(/\s/g, '');
  }
  function checkIfDuplicateExists(arr) {
    return new Set(arr).size !== arr.length
}
  const arr2 = (Array.from(new Set(arr)));
  if(arr.length > arr2.length)
  {
    show_msg("error","Please enter distinct technologies ");
    return false;
  }
 
  var formdata = {
    'profile' : profile,
    'firstname' : firstname,
    'lastname' : lastname,
    'email' : email,
    'phone' : phone,
    'pass' : pass,
    'usertype' : user_type,
    'confirmpass' : confirmpass,
    'arr' : arr2,
    'date' : date
  };
  var jsondata = JSON.stringify(formdata);
 document.getElementById('custregisterbtn').innerHTML = "Loading....";
fetch("/api/Loginuser",{
    method : 'POST',
        body : jsondata,
        headers : {
          'Content-Type' :'application/json',
        } 
      })
    .then((response)=>response.json())
    .then((data)=>{
      
      if(data['insert'] == "success"){
        show_msg('success' , 'Registration successfull check your mail!!! ');
        document.getElementById('custregisterbtn').innerHTML = "Check Mail";
        // window.location = ("welcome/"+data['data']['name']);
      }
      else
      {
        show_msg("error",data.msg);
        document.getElementById('custregisterbtn').innerHTML = "Register";
      }
    });
 });


 function show_msg(type,text){
  if(type == 'error'){
    var message_box = document.getElementById("error-message");
    
    }else{
    var message_box = document.getElementById("success-message");
  }
  message_box.innerHTML = text;
  // message_box.classList.add('animated', 'fadeInDown');
  message_box.style.display = "block";
  setTimeout(function(){
    // message_box.classList.remove('fadeInDown');
    message_box.style.display = "none";
  },3000);
}
</script>