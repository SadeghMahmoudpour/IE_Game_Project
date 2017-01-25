/**
 * Created by sadegh on 1/19/17.
 */
$(document).ready(function() {
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        // $(".tab").addClass("active"); // instead of this do the below
        $(this).removeClass("btn-default").addClass("btn-primary");
    });
});

$('#search-button').click(function () {
    var searchKeywords = document.getElementById('search-input').value;
    window.location.href = 'http://localhost:8000/games_list?q=' + searchKeywords;
});
