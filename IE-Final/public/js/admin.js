/**
 * Created by sadegh on 1/20/17.
 */
$('#search-button').click(function () {
    var searchKeywords = document.getElementById('search-input').value;
    window.location.href = 'http://localhost:8000/games_list?q=' + searchKeywords;
});

$('.game').click(function () {
    $('#gameId-input').val($(this).attr('game-id'));
    $('#title-input').val($(this).attr('title'));
    $('#abstract-input').val($(this).attr('abstract'));
    $('#info-input').val($(this).attr('info'));
    $('#large_image-input').val($(this).attr('large_image'));
    $('#small_image-input').val($(this).attr('small_image'));
});

