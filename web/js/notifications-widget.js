jQuery(function () {
    $('.removeNotify').click(function () {
        var id = $(this).attr('data-id')
        $.post('/notify/delete?id=' + id)
        $(this).parent().remove()
    })
})
