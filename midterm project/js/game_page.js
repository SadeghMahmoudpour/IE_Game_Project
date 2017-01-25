/**
 * Created by sadegh on 12/27/16.
 */
(function () {
    var cache = {};
    var tabTitles = {0: "info", 1: "leaderboard", 2: "comments", 3: "related_games", 4: "gallery"};
    var gameTitle = getParameterByName('game_title');
    var commentsNum = 0;
    var commentsOffset = 0;

    startLoading();

    $('#search-button').click(function () {
        var searchKeywords = document.getElementById('search-input').value;
        console.log(searchKeywords);
        window.location.href = '../html/games_list.html?q=' + searchKeywords;
    });

    function startLoading() {
        loadHeader();
        var tabId = 0;
        if (getParameterByName('tab')) {
            tabId = parseInt(getParameterByName('tab'));
        }
        $('.nav-tabs a[href="#gametab-' + tabTitles[tabId] + '"]').tab('show');
        loadTab(tabId, function (data) {
            var result = checkXml(data);
            renderTab(tabId, result);
        });
        addTabListeners();
    }

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

    function renderTab(tabIndex, result) {
        console.log(result);
        switch (tabIndex) {
            case 0:
                renderInfoTab(result);
                break;
            case 1:
                renderleaderboard(result);
                break;
            case 2:
                renderComments(result);
                break;
            case 3:
                renderRelatedGames(result);
                break;
            case 4:
                renderGallery(result);
                break;
        }
    }

    function addTabListeners() {
        $('.tabs .nav-tabs').on("click", 'li', function (e) {
            var tabIndex = $(".tabs .nav-tabs li").index(this);
            loadTab(tabIndex, function (data) {
                var result = checkXml(data);
                renderTab(tabIndex, result);
            });
        });
        $('#load-more-button').click(function () {

            var url = 'http://api.ie.ce-it.ir/F95/games/' + gameTitle + '/comments.xml?offset=' + commentsOffset;
            var data = $.get(url, function (data) {
                renderComments(checkXml(data));
            });
        });
    }

    function loadGallerySliders() {
        $('#gallery-slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            rtl: false,
            asNavFor: '#gallery-slider-nav'
        });
        $('#gallery-slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '#gallery-slider-for',
            dots: true,
            centerMode: true,
            focusOnSelect: true,
            rtl: false
        });
    }

    function renderGallery(data) {
        console.log(data);
        var images = data.getElementsByTagName('images')[0].getElementsByTagName('image');
        var videos = data.getElementsByTagName('videos')[0].getElementsByTagName('video');

        var gallerySliderFor = document.getElementById('gallery-slider-for');
        var gallerySliderNav = document.getElementById('gallery-slider-nav');

        for (i = 0; i < images.length; i++) {
            var image = images[i];
            var imgDiv = document.createElement('div');
            imgDiv.className = 'slick-item game-card';
            var img = document.createElement('img');
            img.setAttribute('src', image.getElementsByTagName('url')[0].childNodes[0].nodeValue);

            imgDiv.appendChild(img);
            gallerySliderFor.appendChild(imgDiv.cloneNode(true));
            gallerySliderNav.appendChild(imgDiv);
        }

        for (i = 0; i < videos.length; i++) {
            var video = videos[i];
            var vidDiv = document.createElement('div');
            vidDiv.className = 'slick-item game-card';
            var iframe = document.createElement('iframe');
            iframe.setAttribute('src', video.getElementsByTagName('url')[0].childNodes[0].nodeValue);
            iframe.style.position = 'relative';
            iframe.style.height = '100%';
            iframe.style.width = '100%';

            var imgDiv = document.createElement('div');
            imgDiv.className = 'slick-item game-card';
            var img = document.createElement('img');
            img.setAttribute('src', "../images/images/trailer.png");
            imgDiv.appendChild(img);

            vidDiv.appendChild(iframe);
            gallerySliderFor.appendChild(vidDiv);
            gallerySliderNav.appendChild(imgDiv);
        }

        loadGallerySliders()
    }

    function renderRelatedGames(data) {
        console.log(data);
        var related_gamesElem = document.getElementById('gametab-related_games');

        var games = data.getElementsByTagName('games')[0].getElementsByTagName('game');

        for (i = 0; i < 3; i++) {
            var row = document.createElement('div');
            row.className = 'row';
            for (j = 0; j < 4; j++) {
                var game = games[0];

                var title = game.getElementsByTagName('title')[0].childNodes[0].nodeValue;

                var cardContainer = document.createElement('div');
                cardContainer.className = 'col-sm-3';

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
                cardContent.innerHTML += '<input type="text" class="kv-fa-star rating-loading related-games-stars" value="' + game.getElementsByTagName('rate')[0].childNodes[0].nodeValue + '" dir="rtl" data-size="xs" title="">';
                gameItem.appendChild(gameImg);
                gameItem.appendChild(cardContent);
                cardContainer.appendChild(gameItem);
                row.appendChild(cardContainer);
            }
            related_gamesElem.appendChild(row);
            $('.related-games-stars').rating({
                showClear: false,
                showCaption: false,
                theme: 'krajee-fa',
                filledStar: '<i class="fa fa-star"></i>',
                emptyStar: '<i class="fa fa-star-o"></i>',
                displayOnly: true
            });
        }

        // for (i = 0; i < games.length; i += 4) {
        //     var row = document.createElement('div');
        //     row.className = 'row';
        //     for (j = 0; j < 4 && (4 * i + j) < games.length; j++) {
        //         var game = games[4 * i + j];
        //         var gameItem = document.createElement('div');
        //         gameItem.className = 'game-card col-sm-3';
        //
        //         var gameImg = document.createElement('img');
        //         var small_image = game.getElementsByTagName('small_image')[0].childNodes[0].nodeValue;
        //         gameImg.setAttribute('src', small_image);
        //
        //         gameItem.appendChild(gameImg);
        //         row.appendChild(gameItem)
        //     }
        //     related_gamesElem.appendChild(row);
        // }
    }

    function renderComments(data) {
        console.log(data);
        if (!data)return;
        var commentsDiv = document.getElementById('gametab-comments').getElementsByTagName('table')[0].getElementsByTagName('tbody')[0];
        commentsDiv.innerHTML = '';

        var comments = data.getElementsByTagName('comments')[0].getElementsByTagName('comment');
        commentsOffset += comments.length;
        for (i = 0; i < comments.length; i++) {
            var comment = comments[i];
            var text = comment.getElementsByTagName('text')[0].childNodes[0].nodeValue;
            var date = comment.getElementsByTagName('date')[0].childNodes[0].nodeValue;
            var avatar = comment.getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue;

            var tr = document.createElement('tr');
            var td = document.createElement('td');

            var commentCard = document.createElement('div');
            commentCard.className = 'horiz-card row';

            var cardContent = document.createElement('div');
            cardContent.className = 'horiz-card-content col-sm-6';

            var imgContainer = document.createElement('div');
            imgContainer.className = 'horiz-card-img col-sm-2';

            var avatarimg = document.createElement('img');
            avatarimg.setAttribute('src', avatar);

            var comtext = document.createElement('h4');
            comtext.innerHTML = comment.getElementsByTagName('player')[0].getElementsByTagName('name')[0].childNodes[0].nodeValue + ': ';
            comtext.innerHTML += text;

            var comdate = document.createElement('h5');
            comdate.innerHTML = date;

            var stars = document.createElement('div');
            stars.className = 'col-sm-4';
            stars.style.textAlign = 'left';
            var rate = parseFloat(comment.getElementsByTagName('rate')[0].childNodes[0].nodeValue);
            if (rate > 0) {
                stars.innerHTML = '<input type="text" class="kv-fa-star rating-loading comment-stars" value="' + rate + '" dir="rtl" data-size="xs" title="">';
            }

            cardContent.appendChild(comdate);
            cardContent.appendChild(comtext);
            imgContainer.appendChild(avatarimg);
            commentCard.appendChild(imgContainer);
            commentCard.appendChild(cardContent);
            commentCard.appendChild(stars);
            td.appendChild(commentCard);
            tr.appendChild(td);
            commentsDiv.appendChild(tr);
        }

        if (commentsOffset >= commentsNum) {
            var loadCommentsDiv = document.getElementById('load-more-div');
            loadCommentsDiv.style.display = 'none';
        }
        $('.comment-stars').rating({
            showClear: false,
            showCaption: false,
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>',
            displayOnly: true
        });
    }

    function renderleaderboard(data) {
        var records = data.getElementsByTagName('leaderboard')[0].getElementsByTagName('record');
        if (records[0]) {
            var firstPlace = document.getElementById('first_place');
            firstPlace.getElementsByClassName('score_container')[0].getElementsByClassName('square')[0].innerHTML = records[0].getElementsByTagName('level')[0].childNodes[0].nodeValue;
            firstPlace.getElementsByClassName('name')[0].innerHTML = records[0].getElementsByTagName('player')[0].getElementsByTagName('name')[0].childNodes[0].nodeValue;
            firstPlace.getElementsByClassName('number')[0].innerHTML = records[0].getElementsByTagName('score')[0].childNodes[0].nodeValue;
            firstPlace.getElementsByTagName('img')[0].setAttribute('src', records[0].getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue);
        }
        if (records[1]) {
            var secondPlace = document.getElementById('second_place');
            secondPlace.getElementsByClassName('score_container')[0].getElementsByClassName('square')[0].innerHTML = records[1].getElementsByTagName('level')[0].childNodes[0].nodeValue;
            secondPlace.getElementsByClassName('name')[0].innerHTML = records[1].getElementsByTagName('player')[0].getElementsByTagName('name')[0].childNodes[0].nodeValue;
            secondPlace.getElementsByClassName('number')[0].innerHTML = records[1].getElementsByTagName('score')[0].childNodes[0].nodeValue;
            secondPlace.getElementsByTagName('img')[0].setAttribute('src', records[1].getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue);
        }
        if (records[2]) {
            var thirdPlace = document.getElementById('third_place');
            thirdPlace.getElementsByClassName('score_container')[0].getElementsByClassName('square')[0].innerHTML = records[2].getElementsByTagName('level')[0].childNodes[0].nodeValue;
            thirdPlace.getElementsByClassName('name')[0].innerHTML = records[2].getElementsByTagName('player')[0].getElementsByTagName('name')[0].childNodes[0].nodeValue;
            thirdPlace.getElementsByClassName('number')[0].innerHTML = records[2].getElementsByTagName('score')[0].childNodes[0].nodeValue;
            thirdPlace.getElementsByTagName('img')[0].setAttribute('src', records[2].getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue);
        }

        var leaderTable = document.getElementById('gametab-leaderboard').getElementsByTagName('table')[0].getElementsByTagName('tbody')[0];
        for (i = 0; i < records.length; i++) {
            var record = records[i];
            var tr = document.createElement('tr');
            var place = document.createElement('td');
            place.innerHTML = (i + 1) + '.';
            if (i < 3) {
                var star = document.createElement('span');
                star.className = 'glyphicon glyphicon-star';
                if (i == 0) star.style.color = '#FFD700';
                else if (i == 1) star.style.color = '#C0C0C0';
                else star.style.color = '#cd7f32';
                place.appendChild(star);
            }

            var playerName = document.createElement('td');
            playerName.className = 'player-name';
            var avatar = document.createElement('img');
            avatar.setAttribute('src', record.getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue);
            playerName.appendChild(avatar);
            playerName.innerHTML += record.getElementsByTagName('player')[0].getElementsByTagName('name')[0].childNodes[0].nodeValue;

            var level = document.createElement('td');
            level.className = 'number';
            level.innerHTML = record.getElementsByTagName('level')[0].childNodes[0].nodeValue;

            var displacement = document.createElement('td');
            displacement.className = 'displacement';
            var disNum = parseInt(record.getElementsByTagName('displacement')[0].childNodes[0].nodeValue);
            if (disNum < 0) {
                displacement.innerHTML = '\<i class=\"fa fa-sort-desc\" aria-hidden=\"true\"\>\<\/i\>';
                displacement.innerHTML += '(' + disNum + ')';
            } else {
                displacement.innerHTML = '\<i class=\"fa fa-sort-asc\" aria-hidden=\"true\"\>\<\/i\>';
                displacement.innerHTML += '(+' + disNum + ')';
            }

            var scoreTd = document.createElement('td');
            scoreTd.className = 'number';
            scoreTd.innerHTML = record.getElementsByTagName('score')[0].childNodes[0].nodeValue;

            tr.appendChild(place);
            tr.appendChild(playerName);
            tr.appendChild(level);
            tr.appendChild(displacement);
            tr.appendChild(scoreTd);
            leaderTable.appendChild(tr);
        }
    }

    function renderInfoTab(data) {
        var info = data.getElementsByTagName('game')[0].getElementsByTagName('info')[0].childNodes[0].nodeValue;
        var infoTab = document.getElementById('gametab-info');
        // info.innerHTML = '\<h1\>اطلاعات بازی\</h1\>\<hr\/\>';
        infoTab.innerHTML += info;
    }

    function renderHeader(game) {
        console.log(game);
        var headerCard = document.getElementById('header-caption').getElementsByClassName('content')[0].getElementsByClassName('horiz-card')[0];
        var headerImg = headerCard.getElementsByClassName('horiz-card-img')[0].getElementsByTagName('img')[0];
        var imgSrc = game.getElementsByTagName('small_image')[0].childNodes[0].nodeValue;
        commentsNum = parseInt(game.getElementsByTagName('number_of_comments')[0].childNodes[0].nodeValue);
        headerImg.setAttribute('src', imgSrc);

        var title = game.getElementsByTagName('title')[0].childNodes[0].nodeValue;
        var gameTitle = document.createElement('h1');
        gameTitle.innerHTML = title;
        var smallGameTitle = document.createElement('h3');
        smallGameTitle.style.display = 'none';
        smallGameTitle.innerHTML = title;
        var headerContent = headerCard.getElementsByClassName('horiz-card-content')[0];
        headerContent.appendChild(smallGameTitle);
        headerContent.appendChild(gameTitle);

        var categories = game.getElementsByTagName('categories')[0].getElementsByTagName('category');
        var cats = document.createElement('h4');
        for (i = 0; i < categories.length; i++) {
            cats.innerHTML += categories[i].childNodes[0].nodeValue;
            if (i < categories.length - 1) {
                cats.innerHTML += '، ';
            }
        }
        headerContent.appendChild(cats);
        var lastLine = document.createElement('div');
        lastLine.style.display = 'flex';
        lastLine.style.alignItems = 'center';
        var starsSpan = document.createElement('span');
        var rate = game.getElementsByTagName('rate')[0].childNodes[0].nodeValue;
        starsSpan.innerHTML += '<input type="text" class="kv-fa-star rating-loading header-stars" value="' + rate + '" dir="rtl" data-size="xs" title="">';
        var rateSpan = document.createElement('span');
        rateSpan.style.marginRight = '15px';
        rateSpan.innerHTML = rate;
        var commentsSpan = document.createElement('span');
        commentsSpan.style.marginRight = '15px';
        commentsSpan.innerHTML = '(' + parseFloat(commentsNum) + ' رأی' + ')';

        lastLine.appendChild(starsSpan);
        lastLine.appendChild(rateSpan);
        lastLine.appendChild(commentsSpan);

        headerContent.appendChild(lastLine);

        var commentsNumDiv = document.getElementById('comments-number');
        commentsNumDiv.innerHTML = commentsNum + ' نظر';

        $('.header-stars').rating({
            showClear: false,
            showCaption: false,
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>',
            displayOnly: true
        });
    }

    function loadHeader() {
        var url = "http://api.ie.ce-it.ir/F95/games/" + gameTitle + "/header.xml";
        $.get(url, function (data) {
            console.log(data);
            var result = checkXml(data);
            if (result != null) {
                var game = result.getElementsByTagName('game')[0];
                if (typeof game != 'undefined') {
                    renderHeader(game);
                } else {
                    alert('result has no \"game\" element');
                }
            }
        });
        // $.ajax({
        //     type: "GET",
        //     url: "http://api.ie.ce-it.ir/F95/games/بازی The Last Guardian/header.xml",
        //     dataType: "xml",
        //     success: function (xml) {
        //         var result = checkXml(xml);
        //         if (result != null) {
        //             var game = result.getElementsByTagName('game')[0];
        //             if (typeof game != 'undefined') {
        //                 renderHeader(game);
        //             } else {
        //                 alert('result has no \"game\" element');
        //             }
        //         }
        //     },
        //     error: function () {
        //         alert("The XML File could not be processed correctly.");
        //     }
        // });
    }

    function loadTab(tabId, callback) {
        if (!cache[tabId]) {
            var url = 'http://api.ie.ce-it.ir/F95/games/' + gameTitle + '/' + tabTitles[tabId] + '.xml';
            cache[tabId] = $.get(url).promise();
            cache[tabId].done(callback);
            console.log('get-request');
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