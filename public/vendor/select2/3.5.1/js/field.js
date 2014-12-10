$(document).ready(function(){
    $(".select2").each(function(index, element) {
        $(element).select2({
            minimumInputLength: 1,
            multiple   : $(this).attr('multiple'),
            ajax: {
                url: $(this).attr('url'),
                type: "POST",
                dataType : "JSON",
                data: function(term, page){
                    return {
                        q : term
                    }
                },
                results: function (data, page){
                    return { results: data.results};
                }
            },
            initSelection : function (element, callback){
                data = [];
                data = $.parseJSON($(element).attr('data-value'));

                callback(data);
            }
        });
        $(element).select2('val', $.parseJSON($(element).attr('data-value')))
        if($(element).attr('sortable'))
        {
            $(element).select2("container").find("ul.select2-choices").sortable({
                containment: 'parent',
                start: function() { $(element).select2("onSortStart"); },
                update: function() { $(element).select2("onSortEnd"); }
            });
        }
    });
});
