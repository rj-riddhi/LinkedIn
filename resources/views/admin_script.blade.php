<script>
    
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



</script>