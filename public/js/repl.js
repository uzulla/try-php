var pph = {
    editor: undefined,
    init: function(){
        this.editor = ace.edit("editor");
        this.editor.getSession().setMode("ace/mode/php");
        $('#execute-button').click(pph.reqEval);
        $(document).keydown(pph.shortcut);
    },
    reqEval: function(){
        $.ajax({
            url: 'eval.php',
            type: 'post',
            dataType: 'json',
            data: { code: pph.editor.getValue() },
            success: pph.evaled,
            error: function(){
                alert('error');
            }
        });
    },
    evaled: function(data){
        console.log(data);
        var $result = $('#result');
        $result.removeClass('error').removeClass('success');
        if(data.result!='ok'){
            $result.addClass('error');
        }else{
            $result.addClass('success');
        }
        $result.text(data.result);

        var $output = $('#output');
        if(data.output==null){
            $output.text('');
        }else{
            $output.text(data.output);
        }
    },
    shortcut: function (e){
        // CMD + Enter or CTRL + Enter to run code
        if (e.which === 13 && (e.ctrlKey || e.metaKey)) {
            pph.reqEval();
            e.preventDefault();
        }
    }
};

// init
$(function(){
    pph.init();
});
