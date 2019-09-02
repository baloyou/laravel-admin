<?php

/**
 * 该组件会将触发元素的 data-href 属性作为“确定”链接。
 * 必须包含如下的元素
 * <a href='#' data-href='url' data-toggle="modal" data-target="#confirm">
 */
?>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirmTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmTitle">提示</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                你正在进行敏感操作，确定继续吗？
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" data-dismiss="modal" href='#'>取消</a>
                <a class="btn btn-primary btn-ok" href='#'>确定</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".btn_confirm").click(function() {
            var confirm = $("#confirm")

            var confirm_msg = $(this).data('msg');
            if(confirm_msg){
                confirm.find('.modal-body').html(confirm_msg)
            }

            confirm.modal('show').find(".btn-ok").attr('href', $(this).data('href'))
                .click(function(){
                    confirm.modal('hide');
                });
            return false;
        });
    })
    // $('#confirm').on('show.bs.modal', function(e) {
    //     $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    // });
</script>