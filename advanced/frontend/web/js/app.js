/**
 * @link http://yiiplayground.com/
 * @copyright Copyright (c) 2014 Giovanni Derks & Yii Playground contributors
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

app.login = {
    show: function () {
        $('#quick-login-modal').modal({
            show: true
        })
    }
};
app.notice = {
    warning: function (message) {
        $.notify({
            // options
            icon: 'glyphicon glyphicon-warning-sign',
            title: message,
            message: ''
        }, {
            // settings
            type: 'danger'
        });
    },
    error: function () {
        $.notify({
            // options
            icon: 'glyphicon glyphicon-warning-sign',
            title: message,
            message: ''
        }, {
            // settings
            type: 'danger'
        });
    }
};
app.ajax = {
    handle: function (e) {

        if (app.user.login == false) {
            return alert('请登陆');
        }

        e.preventDefault();

        var
            $link = $(e.target),
            callUrl = $link.data('href'),
            formId = $link.data('formId'),
            onDone = $link.data('onDone'),
            onFail = $link.data('onFail'),
            onAlways = $link.data('onAlways'),
            ajaxRequest;


        ajaxRequest = $.ajax({
            type: "post",
            dataType: 'json',
            url: callUrl,
            data: (typeof formId === "string" ? $('#' + formId).serializeArray() : null)
        });

        app.ajax.callbacks.target = $link;

        // Assign done handler
        if (typeof onDone === "string" && app.ajax.callbacks.hasOwnProperty(onDone)) {
            ajaxRequest.done(app.ajax.callbacks[onDone]);
        }

        // Assign fail handler
        if (typeof onFail === "string" && app.ajax.callbacks.hasOwnProperty(onFail)) {
            ajaxRequest.fail(app.ajax.callbacks[onFail]);
        }

        // Assign always handler
        if (typeof onAlways === "string" && app.ajax.callbacks.hasOwnProperty(onAlways)) {
            ajaxRequest.always(app.ajax.callbacks[onAlways]);
        }

    },
    validate: function (response) {
        //console.log(response, typeof(response));
        if (typeof (response) != 'object' || response.code != 0) {
            app.notice.warning(response.message);
            return false;
        } else {
            return true;
        }
    },
    callbacks: {
        'target': null,
        'simpleDone': function (response) {
            // This is called by the link attribute 'data-on-done' => 'simpleDone'
            console.dir(response);
            $('#ajax_result_01').html(response.body);
        },

        //回答
        'afterAnswerCreateSuccess': function (response) {
            // This is called by the link attribute 'data-on-done' => 'linkFormDone';
            // the form name is specified via 'data-form-id' => 'link_form'
            if (app.ajax.validate(response)) {
                $('#answer_item_area').append(response.data.answer_item);
                $('#answer_form_area').html(response.data.answer_form);
            }
        },
        //评论
        'afterCommentCreateSuccess': function (response) {
            if (app.ajax.validate(response)) {
                $('#comment_item_area_' + app.ajax.callbacks.target.data('id')).append(response.data);
                //$('#comment-content-' + app.ajax.callbacks.target.data('id')).val('');

                UE.getEditor('answercommententity-content-' + app.ajax.callbacks.target.data('id')).execCommand('cleardoc');
            }
        },
        //显示评论列表
        'afterShowCommentList': function (response) {
            var comment = $('#comment-' + app.ajax.callbacks.target.data('id'));

            comment.removeClass('hidden');
            comment.html(response);

        },

    }
};

app.comment = {
    //插入AT
    'insertAT': function (answer_id, username) {
        UE.getEditor('answercommententity-content-' + answer_id).execCommand("inserthtml", 'at_html', true);
    }
}