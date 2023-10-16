;(function($){
    $(document).ready(function(){
        $('#ajaxsubmit').on('click', function(){
            var info = $('#info').val();
            var nonce = $('#_wpnonce').val();
            console.log(info);

            $.post(urls.ajaxurl,{
                action: "ajaxtest",
                info: info,
                s:nonce
            }, function(data){
                console.log(data);
            });
            return false;
        })
    });
})(jQuery);