/**
 * Created by floor12 on 22.12.2016.
 */


$(document).on('click', 'a.open-superfile', function (event) {
    obj = $(event.target);
    window.open("/superfile/get?hash=" + obj.data('hash'), '_blank');
})

$(document).on('click', 'a.comments-create', function () {
    object_id = $(this).data('object_id');
    classname = $(this).data('class');
    showForm('comment/form', {classname: classname, object_id: object_id});
})

$(document).on('click', 'a.comments-total', function () {
    commentsBlock = $(this).parent().parent().find('div.comments-comments');
    showComments(commentsBlock);
})

function showComments(commentsBlock) {
    object_id = commentsBlock.data('object_id');
    classname = commentsBlock.data('class');
    $.ajax({
        url: '/comment',
        data: {classname: classname, object_id: object_id},
        success: function (response) {
            commentsBlock.html(response);
            commentsBlock.fadeIn(200);
        },
    });
}

function deleteComment(id) {
    if (confirm("Вы уверены что хотите удалить?"))
        $.ajax({
            data: {id: id},
            method: 'DELETE',
            url: '/comment/delete',
            success: function (response) {
                commentsBlock = $(response);
                showComments(commentsBlock);
                info('Комментарий удален.', 1)
            },
            error: function () {
                alert('Ошибка удаления');
                info('Ошибка удаления объекта.', 2)
            }
        })

}