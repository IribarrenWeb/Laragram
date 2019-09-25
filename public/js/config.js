
$(document).ready(function() {
    
    var url = window.location.origin

    likes()

    var queryOld = '';

    $('#search').keyup(function(){
        
        var querySearch = $(this).val()
        

        if (querySearch.length >= 1) {

            if (querySearch != queryOld) {

                loader('on')
            
                queryOld = querySearch
            }



            $('#search-result').fadeIn(100)
            $('.icon').removeClass('d-none').addClass('d-block')
            
            $.ajax({
                url: url + '/gente/' + querySearch,
                type: 'GET',
                success: function(response){

                    loader('off')

                    if(response.status == 'ok' && response.usuarios.length >= 1){

                        var template = '';
                        
                        response.usuarios.forEach( usuario => {
                        
                            template += 
                            `
                                <li class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <div>
                                            <img class="avatar rounded-circle" src="${url+'/user/avatar/'+ usuario.image}" alt="">
                                        </div>
                                        <div class="ml-3">
                                            <span class="d-block"><a class="list-group-item-action" href="${url+'/user/'+ usuario.nick}" title="">${usuario.nick }</a></span>
                                            <span class="d-block">${ usuario.name + ' ' + usuario.surname }</span>
                                        </div>
                                    </div>
                                </li>
                            `
                        
                        });
                        
                    }else{

                        template = '<li>No se encontraron resultados..</li>'
                    }

                    $('#list-result').html(template).fadeIn(200).delay(1100)
                }
            })
            
         }else{
             $('#search-result').fadeOut(200)
        }
    })

    function likes(){
        $('.icons').unbind().click(function(){
            var item = $(this).children('.fa-heart')
            var check_like = item.hasClass('like')
            var image_id = item.data('id')

            if (check_like) {
                item.removeClass('fas like').addClass('far dislike')

                $.get(url + '/dislike/' + image_id, function(response) {
                    console.log('dislike ' + response)
                });
            }else{
                item.removeClass('far dislike').addClass('fas like')
                $.get(url + '/like/' + image_id, function(response) {
                    console.log('like ' + response)
                });
            }

            likes()

        })
    }

    // Form edit bloqueo de submit si no hay cambio en los values
    const value_inp = $('#form-img-edit textarea').val();
    $('#form-img-edit .img-thumbnail').css('box-shadow','0px 0px 6px lightgrey')

    $('#form-img-edit textarea').keyup(function(event) {
        /* Act on the event */
        if (checkValues(this, value_inp)) {
            $('#form-img-edit :submit').removeClass('disabled').removeAttr('disabled')
            // console.log('holass')
        }else{
            // console.log('nope')
            $('#form-img-edit :submit').addClass('disabled').attr('disabled', '');
        }
    });

    $('#form-img-edit :file').mouseout(function(event) {
        /* Act on the event */
        if (checkValues(this)) {
            $('#form-img-edit :submit').removeClass('disabled').removeAttr('disabled')
            // console.log('holass')
        }else{
            // console.log('nope')
            $('#form-img-edit :submit').addClass('disabled').attr('disabled', '');
        }
    });


    function loader(option){
        switch (option) {
            case 'on':
                $('.loader').show()
                break;
            case 'off':
                $('.loader').fadeOut()
                break;
            default:
                // statements_def
                break;
        }
    }

    function checkValues(select, value_input = null){
        var value = select.value

        if (value.length >= 1 && value != value_input) {
            return true
        }else{
            return false
        }
    }

});