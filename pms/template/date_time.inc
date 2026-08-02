  <script type="text/javascript">  
        // datetime make using jquery  
        $(document)  
            .ready(function ()  
            {  
                ShowTime();  
            });  
  
        function ShowTime()  
        {  
            var dt = new Date();  
            document.getElementById("div_date_time")  
                .innerHTML = dt.toLocaleTimeString();  
            window.setTimeout("ShowTime()", 1000); // Here 1000(milliseconds) means one 1 Sec  
        }  
        </script>  
        <script>  
        // date time make only javascript  
        function startTime()  
        {  
            var today = new Date();  
            var h = today.getHours();  
            var m = today.getMinutes();  
            var s = today.getSeconds();  
            var d = new Date();  
            var n = d.getDate();  
            var month = new Array();  
            month[0] = "January";  
            month[1] = "February";  
            month[2] = "March";  
            month[3] = "April";  
            month[4] = "May";  
            month[5] = "June";  
            month[6] = "July";  
            month[7] = "August";  
            month[8] = "September";  
            month[9] = "October";  
            month[10] = "November";  
            month[11] = "December";  
            var t = month[d.getMonth()];  
            var y = d.getFullYear();  
            m = checkTime(m);  
            s = checkTime(s);  
            document.getElementById('div_date_time')  
                .innerHTML = n + "-" + t + "-" + y + " " + h + ":" + m + ":" + s;  
            var t = setTimeout(function ()  
            {  
                startTime()  
            }, 500);  
        }  
  
        function checkTime(i)  
        {  
            if(i < 10)  
            {  
                i = "0" + i  
            }; // add zero in front of numbers < 10  
            return i;  
        }  
        </script> 