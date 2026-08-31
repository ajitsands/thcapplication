  <script type="text/javascript">  
        // datetime make using jquery  
        $(document).ready(function () {  
            ShowTime();  
        });  
  
        function ShowTime() {  
            var dt = new Date();  
            var el = document.getElementById("div_date_time");  
            if (el) {  
                var options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };  
                var timeStr = dt.toLocaleTimeString('en-US', options);  
                var dateStr = dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });  
                el.innerHTML = '<i class="icon-alarm mr-1" style="font-size: 13px; vertical-align: -1px;"></i> ' + dateStr + ' ' + timeStr;  
            }  
            window.setTimeout(ShowTime, 1000);  
        }  
        </script>  
        <script>  
        // date time make only javascript  
        function startTime() {  
            var today = new Date();  
            var h = today.getHours();  
            var m = today.getMinutes();  
            var s = today.getSeconds();  
            var d = new Date();  
            var n = d.getDate();  
            var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];  
            var t = month[d.getMonth()];  
            var y = d.getFullYear();  
            m = checkTime(m);  
            s = checkTime(s);  
            var el = document.getElementById('div_date_time');  
            if (el) {  
                el.innerHTML = '<i class="icon-alarm mr-1" style="font-size: 13px; vertical-align: -1px;"></i> ' + n + '-' + t + '-' + y + ' ' + h + ':' + m + ':' + s;  
            }  
            window.setTimeout(startTime, 1000);  
        }  
  
        function checkTime(i) {  
            if(i < 10) {  
                i = "0" + i;  
            }  
            return i;  
        }  
        </script> 