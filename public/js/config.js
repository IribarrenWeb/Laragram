
$(document).ready(function () {

    /**
     * Setup of ajax headers for csrf token
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Initialize variables and functions
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */
    var url = window.location.origin
    var queryOld = '';
    likes()


    /**
     * Functionality to get a query search and showing the results in a view
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */
    $('#search').focusout(function(){
        $('#search-result').fadeOut(200)
    })

    $('#search').focusin(function(){
        $('#search-result').fadeIn(200)
        search()
    })

    /**
     * Functionality to search user with ajax
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * *
     */
    function search(){

        $('#search').keyup(function () {
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
                    success: function (response) {
    
                        if (response.status == 'ok' && response.usuarios.length >= 1) {
    
                            var template = '';
    
                            response.usuarios.forEach(usuario => {
    
                                template +=
                                    `
                                    <li class="d-flex align-items-center">
                                        <div class="d-flex">
                                            <div>
                                                <img class="avatar rounded-circle" src="${url + '/user/avatar/' + usuario.image}" alt="">
                                            </div>
                                            <div class="ml-3">
                                                <span class="d-block"><a class="list-group-item-action" href="${url + '/user/' + usuario.nick}" title="">${usuario.nick}</a></span>
                                                <span class="d-block">${ usuario.name + ' ' + usuario.surname}</span>
                                            </div>
                                        </div>
                                    </li>
                                `
                            });
                        } else {
                            template = '<li>No se encontraron resultados..</li>'
                        }
                        $('#list-result').html(template).fadeIn(200, function(){
                            loader('off')
                        })
                    }
                })
            } else {
                $('#search-result').fadeOut(200)
            }
        })
    }


    /**
     * Functionality to add a comment with ajax
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * *
     */
    $('.form_comment').find('textarea').keyup(function (object) {

        let form = $('.form_comment')
        let action = form.attr('action')
        let comment = $(this).val()
        let id = $(this).siblings('input[name="id"]').val()
        let button = $(this).siblings('div').find('button[type=submit]')
        let element = $(this)

        if (comment.length >= 1) {
            button.removeAttr('disabled')
        } else {
            button.attr('disabled', '')
        }

        console.log()
        form.unbind().submit(function (e) {
            e.preventDefault();

            if (comment.length >= 1) {

                $.ajax({
                    type: "post",
                    url: action,
                    data: { id: id, content: comment },
                    success: function (response) {
                        if (response.status) {

                            form.find('textarea').val('')

                            let template =
                                `
                                <p class="mb-0 d-inline-block">
                                    <strong class="d-inline-block mr-1">                                
                                        ${response.user}
                                    </strong>
                                    ${response.comment}
                                </p>
                            `
                            element.parents('div.card-home').find('.comment_show').fadeOut(400, function () {
                                $(this).html(template)
                            }).fadeIn(300)

                        } else {
                            alert('Oh, a ocurrido un error')
                        }
                    }
                });
            }
        })
    })


    /**
     * Functionality to block button submit if there is no changes in the images values
     * View: image.edit
     *  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */
    const value_inp = $('#form-img-edit textarea').val();
    $('#form-img-edit .img-thumbnail').css('box-shadow', '0px 0px 6px lightgrey')

    $('#form-img-edit textarea').keyup(function (event) {
        /* Act on the event */
        if (checkValues(this, value_inp)) {
            $('#form-img-edit :submit').removeClass('disabled').removeAttr('disabled')
        } else {
            $('#form-img-edit :submit').addClass('disabled').attr('disabled', '');
        }
    });

    $('#form-img-edit :file').mouseout(function (event) {
        /* Act on the event */
        if (checkValues(this)) {
            $('#form-img-edit :submit').removeClass('disabled').removeAttr('disabled')
            // console.log('holass')
        } else {
            // console.log('nope')
            $('#form-img-edit :submit').addClass('disabled').attr('disabled', '');
        }
    });


    /**
     * Various functions
     * * * * * * * * * * * * * * * * * * * * * * * *
     */
    function likes() {
        $('.likes > img').unbind().click(function () {
            var item = $(this)
            var check_like = item.hasClass('like')
            var image_id = item.data('id')

            if (check_like) {
                // $.get(url + '/dislike/' + image_id, function (response) {
                //     console.log('dislike ' + response)
                // });
                item.animate(
                    { width: '27px' },
                    'fast',
                    function () {

                        item.attr('src', url + '/images/like.png')
                            .removeClass('like')
                        

                    }).addClass('dislike').animate({ width: '24px' }, 'fast')


            } else {
                item.animate(
                    { width: '27px' },
                    'fast',
                    function () {

                        item.attr('src', url + '/images/likered.png')
                            .removeClass('dislike')

                    }).addClass('like').animate({ width: '24px' }, 'fast')

                // item.removeClass('far dislike').addClass('fas like')
                // $.get(url + '/like/' + image_id, function (response) {
                //     console.log('like ' + response)
                //     checkLikes(image_id, item)
                // });
            }

            likes()

        })
    }

    function loader(option) {
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

    function checkValues(select, value_input = null) {
        var value = select.value

        if (value.length >= 1 && value != value_input) {
            return true
        } else {
            return false
        }
    }


});