<div class ="footer">

</div>
<script src="layout/js/jquery-3.4.1.min.js"></script>
<script src="layout/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    
    $("#serche").on("keyup",function(){
        var value =$(this).val().toLowerCase();
        $("#emp tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
            
        });
        $("#emp tr:first").show();
    });
    
    /*
    $("#serche").keyup(function(){
        var value =$(this).val().toLowerCase();
        value=$.trim(value);
        $(".select-users").html('');
        //console.log(value);
        if(value!=="")
        {
            $.ajax({
            url: "p1.php",
            data: {
                value:value
            },
            success: function(data) {
                if(data!=""){$(".select-users").html(data);}
                else{document.getElementById(".select-users").innerHTML="Rien";}
                
            }
            });
        }
        
    });*/

});
</script>
</body>
</html>