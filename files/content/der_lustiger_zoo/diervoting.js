$(document).ready(function() {
    $("#diervoter").append("<a href='#' id=\"{{$tier}}\" class=\"bdiervote\">Yes! That's genau mein Tier!</a>");
    $("#diervoter a").click(function(e) {
        // stop normal link click
        e.preventDefault();
     
        // send request
        $.ajax({
            type:'POST',
            url:'{{$target}}',
            data: {
                diervoter: $(this).attr('id')
                },
            success: function(xml) {
                // format and output result
                $("#diervoter").html($("button_after", xml).text());
                $("#diervote_ergebnis").html($("ergebnis", xml).text())
            }
        });
    });
});