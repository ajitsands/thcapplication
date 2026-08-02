<style>
    input[type="text"],
    input[type="search"],
    input[type="email"],
    input[type="password"] {
        -webkit-autofill: none;
    }
    
    input[type="search"] {
       pointer-events: none;
    }
    
</style>

<script>
$(document).ready(function(){
    
    function CommonSetting(){
        $('input[type="text"], input[type="search"], input[type="email"], input[type="password"]').attr('autocomplete', 'off');
        $('input[type="search"]').attr('value', 'testing');
        $('input[type="search"]').attr('id', 'datable_search_filter');
        $('input[type="text"]').on('contextmenu', function(event) {
            return false;
        });
    }
    
    $(document).on('init.dt', function () {
        CommonSetting();
    });
    
    CommonSetting();
    
    $('input[type="text"], input[type="search"], input[type="email"], input[type="password"]').prop('disabled', true);
    
    setTimeout(function() {
       $('input[type="text"], input[type="search"], input[type="email"], input[type="password"]').prop('disabled', false);
    }, 2000);

    
});
</script>