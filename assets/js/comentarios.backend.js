$(document).ready(function(){
    $(".comment_toggle").click(function(){
        $(this).toggle("fast");
        $(this).next().toggle("fast");
    });
    $('.comment').click(function(){
        $(this).toggle("fast");
        $(this).prev().toggle("fast");
    });
    $('#toggle_change_set').click(function(){
        $('#change_set_container').toggle('fast');
    });
});