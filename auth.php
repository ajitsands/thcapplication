  <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"> </script>
  
  <script>
 
  $.post( "app/auth.php",{action:"login",username:"1001",password:"12345"}, function( data ) {
 alert(data);
});
        
    </script>
   