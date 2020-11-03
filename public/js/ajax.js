$(document).ready(function() {
    $.ajax({
        method: 'POST',
        url: "/ajaxAction",
        data: {
            limit:1
        },
        dataType: "json",
        success: function(response) {
            for (var i=0; i<response.data.length; i++) {
                var path = "{{path('viewBooksDetails')}}";
                $('#showBooks').append(
                    ("<div class='col-sm-4'>" +
                        ("<img src='http://localhost:8000/images/images/"+response["data"][i]["image"]+"' />")+
                        ("<br/>")+
                        ("<span>Name:"+response["data"][i]["name"]+"</span>")+
                        ("<br/>") +
                        ("<span>by: "+response["data"][i]["author"]+"</span>")+
                        ("<br/>")+
                        ("<a href='http://localhost:8000/viewDetails/"+response["data"][i]["id"]+"'>View Details</a>")+
                        ("<a href='http://localhost:8000/orderBook/"+response["data"][i]["id"]+"'>Order Books</a>")+
                        "</div>"))
            }

        }
    });


    function makeCounter() {
        var count = 1;
        return function() {
            count++;
            return count;
        };
    }
    var counter = makeCounter();
    // The actual counter is contained in the counter closure.
    // You can create new independent counters by simply assigning
    // the function to a new variable
    $("#loadMore").click(function () {


        var index = counter();
        $.ajax({
            method: 'POST',
            url: "/ajaxAction",
            data: {
                limit:index
            },
            dataType: "json",
            success: function(response) {
                // console.log(response['data'])
                // console.log(response['data']);
                for (var i=0; i<response.data.length; i++) {
                   $('#showBooks').append(
                       ("<div class='col-sm-4'>" +
                           ("<img src='http://localhost:8000/images/images/"+response["data"][i]["image"]+"' />")+
                           ("<br/>")+
                           ("<span>Name:"+response["data"][i]["name"]+"</span>")+
                           ("<br/>") +
                           ("<span>by: "+response["data"][i]["author"]+"</span>")+
                           ("<br/>")+
                           ("<a href='http://localhost:8000/viewDetails/"+response["data"][i]["id"]+"'>View Details</a>")+
                           ("<a href='http://localhost:8000/orderBook/"+response["data"][i]["id"]+"'>Order Books</a>")+
                           "</div>"))
                }


            }
        });

        // Probably update your counter element
        // $("#counter").text(i);
    });
});