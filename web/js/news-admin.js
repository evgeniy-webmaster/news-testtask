jQuery(function ($) {
    $('#createBtn').click(function () {
        $('#newsForm .modal-title').text('Create News')
        $.get('/news-admin/create', function (res) {
            $('#newsForm .modal-body').html(res)
            $('#newsForm .modal-body').on('submit', 'form', function (e) {
                e.preventDefault()
                $.pjax.submit(e, '#newsForm .modal-body')
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
                $.pjax.submit(e, '#newsForm .modal-body')
            })
            $('#newsForm').modal()
        })
    })
    $('.statusAjaxControl').click(function () {
        $.post('/news-admin/status-change', {
            'id': $(this).attr('data-modelId'),
            'value': $(this).is(':checked') ? 1 : 0
        })
    })
})
