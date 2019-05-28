var UINestable = function () {

    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };


    return {
        //main function to initiate the module
        init: function () {

            // activate Nestable for list 1
            $('#list_1').nestable({
                group: 1
            }).on('change', updateOutput);

            // activate Nestable for list 2
            $('#list_2').nestable({
                group: 1
            }).on('change', updateOutput);

            // activate Nestable for list 2
            $('#list_3').nestable({
                group: 1
            }).on('change', updateOutput);

            // activate Nestable for list 2
            $('#list_4').nestable({
                group: 1
            }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#list_1').data('output', $('#list_2_output'), $('#list_3_output')));
            updateOutput($('#list_2').data('output', $('#list_1_output')));
            updateOutput($('#list_3').data('output', $('#list_1_output')));
            updateOutput($('#list_4').data('output', $('#list_1_output')));

        }

    };

}();