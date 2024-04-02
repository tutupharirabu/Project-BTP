$(document).ready(function() {
    $(document).ready(function() {
        $('#id_icon').click(function(){
            if($(this).is('.icon')){
                $('#inputpassword').attr('type', 'text');
                $(this).removeClass('icon');
            }else{
                $('#inputpassword').attr('type', 'password');
                $(this).addClass('icon');
            }
        })
    })
})
