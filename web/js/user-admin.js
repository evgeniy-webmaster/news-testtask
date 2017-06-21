jQuery(function ($) {
    $('#createUserBtn').click(function () {
        $.get('/user-admin/create', function (res) {
            $('#userForm .modal-title').text('Create User')
            $('#userForm .modal-body').html(res)
            $('#userForm .modal-body').on('submit', 'form', function (event) {
                event.preventDefault()
                $.pjax.submit(event, '#userForm .modal-body', { 'push': false })
            })
        })
    })
    $('.userUpdateBtn').click(function () {
        $(this).attr('data-userId')
        $.get('/user-admin/update', { 'id': $(this).attr('data-userId') }, function (res) {
            $('#userForm .modal-title').text('Update User')
            $('#userForm .modal-body').html(res)
            $('#userForm .modal-body').on('submit', 'form', function (event) {
                event.preventDefault()
                $.pjax.submit(event, '#userForm .modal-body', { 'push': false })
            })
        })
    })
})
