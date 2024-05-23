document.addEventListener('DOMContentLoaded', function () {
    $(function() {
        $('.delete').click(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                    $.ajax({
                        method: "DELETE",
                        url: deleteUrl+ $(this).data("id"),
                    })
                        .done(function( data ) {
                            window.location.reload();
                        })
                        .fail(function( data ){
                            console.log(data)
                        })
        })
    })

}, false);
