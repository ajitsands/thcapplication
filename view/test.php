<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        

        
        
    </head>
    <body>
        <div class="container">
            <form>
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text"  class="form-control" id="name" placeholder="Enter name" name="name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" list="choosing" class="form-control" id="email0001" placeholder="Enter email" name="email0001" />
                    <datalist id="choosing">
                        <option value="test-1">
                        <option value="test-2">
                        <option value="test-3">
                        <option value="test-4">
                        <option value="test-5">
                    </datalist> 
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd0001" placeholder="Enter password" name="pswd0001" autocomplete="off" />
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label"> <input class="form-check-input" type="checkbox" name="remember" > Remember me </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
            	<script src="global_assets/js/main/jquery.min.js"></script> 
<script>

    
$(document).ready(function(){
    
  
    $('input[type="text"], input[type="search"], input[type="email"], input[type="password"]').attr('autocomplete', 'off');
        // $('input[type="search"]').attr('value', 'testing');
        
        //  console.log('Testing');
          $('input[type="email"], input[type="text"], input[type="password"], input[type="search"]').on('contextmenu', function(event) {
            event.preventDefault();
           
        });

});
</script>
        
</html>

