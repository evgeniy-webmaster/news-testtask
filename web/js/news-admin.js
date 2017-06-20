jQuery(function ($) {
    $('#createBtn').click(function () {
        $('#newsForm .modal-title').text('Create News')
        $.get('/news-admin/create', function (res) {
            $('#newsForm .modal-body').html(res)
            $('#newsForm .modal-body').on('submit', 'form', function (e) {
                e.preventDefault()
                $.pjax.submit(e, '#newsForm .modal-body', { 'push': false })
            })
        })
    })
    $(document).on('click', '.newsUpdate', function (e) {
        e.preventDefault()
        $('#newsForm .modal-title').text('Update News')
        $.get($(this).attr('href'), function (res) {
            $('#newsForm .modal-body').html(res)
            $('#newsForm .modal-body').on('submit', 'form', function (e) {
                e.preventDefault()
                $.pjax.submit(e, '#newsForm .modal-body', { 'push': false })
            })
            $('#newsForm').modal()
        })
    })
    var lastClicked = null
    $(document).on('click', '.statusAjaxControl', function () {
        lastClicked = $(this)
        $.post('/news-admin/status-change', {
            'id': $(this).attr('data-modelId'),
            'value': $(this).is(':checked') ? 1 : 0,
        })
    })
    $(document).ajaxError(function (event, request, settings) {
        if(request.status == 403) {
            $('#newsForm .modal-title').text('Error')
            $('#newsForm .modal-body').html('<div class="alert alert-danger">' + request.responseText + '</div>')
            $('#newsForm').modal('show')
            if(settings.url == '/news-admin/status-change')
                $(lastClicked).prop('checked', !$(lastClicked).prop('checked'))
        }
    })
})
