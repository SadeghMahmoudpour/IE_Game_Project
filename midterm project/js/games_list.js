/**
 * Created by sadegh on 1/4/17.
 */
(function () {
    var filters = {rates: [], categories: []};
    var q = getParameterByName('q');
    if (q) {
        searchGames(q);
    }

    loadCategories();

    function loadCategories() {
        $('.filter-stars').rating({
            showClear: false,
            showCaption: false,
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>',
            displayOnly: true
        });
        var url = 'http://api.ie.ce-it.ir/F95/categories.xml';
        $.get(url, function (data) {
            var result = checkXml(data);
            renderCats(result);
        });
        function renderCats(data) {
            var categories = data.getElementsByTagName('categories')[0].getElementsByTagName('category');
            var categoriesDiv = document.getElementById('category-filters');
            categoriesDiv.innerHTML = '';
            for (i = 0; i < categories.length; i++) {
                var category = categories[i].childNodes[0].nodeValue;
                ;
                var filterInput = document.createElement('div');
                filterInput.className = 'filter-input';
                filterInput.setAttribute('value', category);
                filterInput.innerHTML = category;

                categoriesDiv.appendChild(filterInput);
            }

            $('.filter-input').click(function () {
                if ($(this).hasClass('filter-active')) {
                    var retvalue = this.getAttribute('value');
                    if (this.getAttribute('type') == 'rate-filter') {
                        filters.rates = $.grep(filters.categories, function (value) {
                            return value != retvalue;
                        });
                    } else {
                        filters.categories = $.grep(filters.rates, function (value) {
                            return value != retvalue;
                        });
                    }
                    $(this).removeClass('filter-active');
                } else {
                    if (this.getAttribute('type') == 'rate-filter') {
                        filters.rates.push(this.getAttribute('value'));
                    } else {
                        filters.categories.push(this.getAttribute('value'));
                    }
                    $(this).addClass('filter-active');
                }
                filterRequest();
                function filterRequest() {
                    console.log(filters);
                    console.log(JSON.stringify(filters));
                    $.ajax({
                        type: "POST",
                        url: 'http://api.ie.ce-it.ir/F95/games_list.xml',
                        data: {"filters": JSON.stringify(filters)},
                        cache: false,
                        success: function (result) {
                            showSearchGames(checkXml(result));
                        },
                        error: function () {
                            showSearchGames('');
                        }
                    });
                }
            });
        }
    }

    function searchGames(searchKeywords) {
        $('#header-caption .content').html("<h2>نتایج جست و جو برای: " + searchKeywords + "</h2>");
        var url = 'http://api.ie.ce-it.ir/F95/games.xml?q=' + searchKeywords;
        $.get(url, function (data) {
            var result = checkXml(data);
            showSearchGames(result);
        });
    }

    $('#search-button').click(function () {
        var searchKeywords = document.getElementById('search-input').value;
        // console.log(searchKeywords);
        searchGames(searchKeywords);
    });

    function getParameterByName(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function showSearchGames(data) {
        // console.log(data);
        var related_gamesElem = document.getElementById('search-games');
        related_gamesElem.innerHTML = '';
        if(!data || !data.getElementsByTagName('games')[0])return;

        var games = data.getElementsByTagName('games')[0].getElementsByTagName('game');

        for (i = 0; i < games.length; i += 3) {
            var row = document.createElement('div');
            row.className = 'row';
            for (j = 0; j < 3 && (3 * i + j) < games.length; j++) {
                var game = games[0];

                var title = game.getElementsByTagName('title')[0].childNodes[0].nodeValue;

                var cardContainer = document.createElement('div');
                cardContainer.className = 'col-sm-4';

                var gameItem = document.createElement('a');
                gameItem.setAttribute('href', 'game_page.html?game_title=' + title);
                gameItem.className = 'game-card';

                var gameImg = document.createElement('img');
                var small_image = game.getElementsByTagName('small_image')[0].childNodes[0].nodeValue;
                gameImg.setAttribute('src', small_image);

                var cardContent = document.createElement('div');
                cardContent.className = 'card-content';

                var gameTitle = document.createElement('div');
                gameTitle.className = 'game-title';
                gameTitle.innerHTML = title;

                var categories = document.createElement('div');
                categories.className = 'game-categories';
                var gameCats = game.getElementsByTagName('categories')[0].getElementsByTagName('category');
                for (g = 0; g < gameCats.length; g++) {
                    if (g > 0)categories.innerHTML += '، '
                    categories.innerHTML += gameCats[g].childNodes[0].nodeValue;
                }

                cardContent.appendChild(gameTitle);
                cardContent.appendChild(categories);
                cardContent.innerHTML += '<input type="text" class="kv-fa-star rating-loading game-card-stars" value="' + game.getElementsByTagName('rate')[0].childNodes[0].nodeValue + '" dir="rtl" data-size="xs" title="">';
                gameItem.appendChild(gameImg);
                gameItem.appendChild(cardContent);
                cardContainer.appendChild(gameItem);
                row.appendChild(cardContainer);
            }
            related_gamesElem.appendChild(row);
            $('.game-card-stars').rating({
                showClear: false,
                showCaption: false,
                theme: 'krajee-fa',
                filledStar: '<i class="fa fa-star"></i>',
                emptyStar: '<i class="fa fa-star-o"></i>',
                displayOnly: true
            });
        }
    }

    function checkXml(xml) {
        var response = xml.getElementsByTagName("response")[0];
        if (typeof response != 'undefined') {
            var ok = response.getElementsByTagName("ok")[0];
            var description = response.getElementsByTagName("description")[0];
            if (typeof ok != 'undefined' && ok.childNodes[0].nodeValue == 'true') {
                var result = response.getElementsByTagName("result")[0];
                if (typeof description != 'undefined') {
                    console.log(description.childNodes[0].nodeValue);
                }
                if (typeof result != 'undefined') {
                    return result;
                } else {
                    alert('Response has no \"result\" element');
                }
            } else {
                if (typeof description != 'undefined') {
                    alert(description.childNodes[0].nodeValue);
                } else {
                    alert("The request was unsuccessful");
                }
            }
        } else {
            alert('Bad response');
        }
        return null;
    }
}());