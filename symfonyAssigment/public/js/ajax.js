$(document).ready(function() {
    function makeCounter()
    {
        var count = 0;
        return function()
        {
            count++;
            return count;
        };
    }

    var counter = makeCounter();

    function loadBooks()
    {
        var index = counter();
        $.ajax({
            method: 'POST',
            url: "/ajaxAction",
            data: {
                limit:index
            },
            dataType: "json",
            success: function(response)
            {
                if(!response.data.length) {
                    alert('No More Books');
                }

                for (var i=0; i<response.data.length; i++) {
                   $('#showBooks').append(
                       ("<div class = 'col-sm-4'>" +
                           ("<img src = 'http://localhost:8000/images/images/"+response["data"][i]["image"] + "' />") +
                           ("<br/>") +
                           ("<span>Name:" + response["data"][i]["name"]+"</span>") +
                           ("<br/>") +
                           ("<span>by: " + response["data"][i]["author"]+"</span>") +
                           ("<br/>") +
                           ("<a href='http://localhost:8000/viewDetails/" + response["data"][i]["id"] + "'>View Details</a>") +
                           ("<a href='http://localhost:8000/orderBook/"+response["data"][i]["id"]+"'>Order Books</a>") +
                           "</div>"))
                }

            }
        });

    }
    loadBooks();
    $("#loadMore").on("click", function(){
        loadBooks();

    });

});
