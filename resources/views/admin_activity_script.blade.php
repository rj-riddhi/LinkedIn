<script >
    
    

    document.getElementById("dashli").classList.remove("active");
    document.getElementById("chartli").classList.remove("active");
    document.getElementById("calli").classList.remove("active");
    document.getElementById("actli").classList.add("active");
    

    fetch("/activities")
    .then((response)=>response.json())
    .then((data)=>{
        var colors = ['primary','danger','success','warning'] ;
      var array = data.array;
    var list = document.getElementsByClassName("streamline");
    
    var j = 0;
    for(var i = 0 ;i<array.length  ; i++ )
    {
        let data=window.performance.getEntriesByType("navigation")[0].type;
         if(data == 'reload')
         i = 0;
         

        var time = array[i].time;
        var currenttime = new Date();
        var time2 = currenttime.getFullYear()+"-"+(('0' + (currenttime.getMonth()+1)).slice(-2))+"-"+('0' + currenttime.getDate()).slice(-2)+" "+currenttime.getHours()+":"+currenttime.getMinutes()

        var arr1 = time.split(" ");
        var arr2 = time2.split(" ");
        if(arr1[0] == arr2[0] )
        {
            var hrs1 = arr1[1].split(":")[0];
            var hrs2 = arr2[1].split(":")[0];
            
            var min1 = arr1[1].split(":")[1];
            var min2 = arr2[1].split(":")[1];
            
            if((hrs2-hrs1) == 1)
            {
             var diff =(59-parseInt(min1))+ parseInt(min2);
             diff  = diff+" mins";
            }
            else if((hrs2-hrs1) >= 2)
            {
            diff = (hrs2-hrs1)+" hr/s";
            }
            else
            {
                var diff = min2-min1;
                diff  = diff+" mins ";
            }
            
            
            
        }
        else
        {
            var day1 = arr1[0].split("-")[2];
            var day2 = arr2[0].split("-")[2];
            var diff = (day2-day1)+" day/s";
        }
        if(j == (colors.length-1))
        j=0;
    var content = `<div class="sl-item sl-${colors[j]}">
                                            <div class="sl-content">
                                                <small class="text-muted">${diff}  ago</small>
                                                <p>${array[i].notification}</p>
                                            </div>
                                        </div>`;
                                        j++;
    }
    list[0].innerHTML += content;
    

    })
    .catch((error)=>{
        console.log(error);
    })

    // let i = 0;
    
    // i++;
</script>