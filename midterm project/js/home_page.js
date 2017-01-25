/**
 * Created by sadegh on 12/22/16.
 */
(function () {
    $.ajax({
        type: "GET",
        url: "http://api.ie.ce-it.ir/F95/home.xml",
        dataType: "xml",
        success: function (xml) {
            var result = checkXml(xml);
            if (result != null) {
                var homepage = result.getElementsByTagName('homepage')[0];
                if (typeof homepage != 'undefined') {
                    renderHomePage(homepage);
                } else {
                    alert('result has no \"homepage\" element');
                }
            }
        },
        error: function () {
            alert("The XML File could not be processed correctly.");
        }
    });

    function renderSlider(activeSlides) {
        var active = activeSlides;

        function getSlidesToShow(num) {
            active = Math.min(num, active);
            return active;
        }

        $('#home-slick-slider').slick({
            slidesToShow: active,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            draggable: true,
            focusOnSelect: true,
            pauseOnFocus: false,
            pauseOnHover: true,
            rtl: false,
            centerMode: true,
            responsive: [
                {
                    breakpoint: 1500,
                    settings: {
                        slidesToShow: getSlidesToShow(5),
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: getSlidesToShow(3),
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: getSlidesToShow(1),
                    }
                }
            ]
        });
    }

    function makeListeners() {
        $('#home-slick-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $('#home-carousel').carousel(nextSlide);

            var current_Slide = slick.$slides.get(currentSlide);
            current_Slide.getElementsByClassName('slick-img-container')[0].style.display = 'flex';
            current_Slide.getElementsByClassName('slick-caption')[0].style.display = 'none';
        });

        $('#home-slick-slider').on('afterChange', function (event, slick, currentSlide) {
            var current_Slide = slick.$slides.get(currentSlide);
            current_Slide.getElementsByClassName('slick-img-container')[0].style.display = 'none';
            var middleStyle = current_Slide.getElementsByClassName('slick-caption')[0];
            middleStyle.style.display = 'flex';
            middleStyle.style.backgroundColor = '#67b168';
        });

        $('#home-slick-slider').on("mouseover", '.slick-item', function (e) {
            // var slickClickedItemNumber = $(this).attr("data-slick-index");
            var hoverSlide = this.getElementsByClassName('slick-caption')[0];
            if (hoverSlide.style.display == 'none') {
                hoverSlide.style.display = 'flex';
                hoverSlide.style.backgroundColor = '#337ab7';
                this.getElementsByClassName('slick-img-container')[0].style.display = 'none';
            }
        });

        $('#home-slick-slider').on("mouseleave", '.slick-item', function (e) {
            if ($(this).attr("data-slick-index") != $('#home-slick-slider').slick('slickCurrentSlide')) {
                this.getElementsByClassName('slick-img-container')[0].style.display = 'flex';
                this.getElementsByClassName('slick-caption')[0].style.display = 'none';
            }
        });
    }

    function initSliders() {
        var currentSlide = $('#home-slick-slider').slick('slickGoTo', 0);
        document.getElementById('home-carousel').getElementsByClassName('item')[0].className += ' active';
    }

    function addMainSlider(title, abstract, large_image) {
        var mainSlider = document.getElementById('home-carousel');
        var carouselInner = mainSlider.getElementsByClassName('carousel-inner')[0];

        var carouselItem = document.createElement('div');
        carouselItem.className = 'item';

        var carouselImgContainer = document.createElement('div');
        carouselImgContainer.className = 'carousel-img-container';

        var carouselImg = document.createElement('img');
        carouselImg.setAttribute('src', large_image);

        var carouselCaption = document.createElement('div');
        carouselCaption.className = 'carousel-caption';

        var gameTitle = document.createElement('h1');
        gameTitle.innerHTML = title;

        var smallGameTitle = document.createElement('h3');
        smallGameTitle.style.display = 'none';
        smallGameTitle.innerHTML = title;

        var gameDescription = document.createElement('p');
        gameDescription.innerHTML = abstract;
        gameDescription.style.paddingLeft = '10vw';

        var gameLinks = document.createElement('div');
        gameLinks.className = 'carousel-game-links';

        var loginButton = document.createElement('a');
        loginButton.setAttribute('href', 'game_page.html?game_title=' + title);
        loginButton.innerHTML = 'ورود به <b>صفحه‌ی</b> بازی';
        loginButton.className = 'btn-primary';

        var trailerLink = document.createElement('a');
        trailerLink.setAttribute('href', 'game_page.html?game_title=' + title + '&tab=4');
        trailerLink.innerHTML = '\<span class=\"glyphicon glyphicon-play-circle\"\>\<\/span\> ';
        trailerLink.innerHTML += 'تریلر این بازی';
        trailerLink.className = 'btn-link';

        gameLinks.appendChild(loginButton);
        gameLinks.appendChild(trailerLink);
        carouselCaption.appendChild(gameTitle);
        carouselCaption.appendChild(smallGameTitle);
        carouselCaption.appendChild(gameDescription);
        carouselCaption.appendChild(gameLinks);
        carouselImgContainer.appendChild(carouselImg);
        carouselItem.appendChild(carouselImgContainer);
        carouselItem.appendChild(carouselCaption);
        carouselInner.appendChild(carouselItem);
    }

    function addSmallSlider(title, number_of_comments, small_image) {
        var homeSlickSlider = document.getElementById('home-slick-slider');

        var slickItem = document.createElement('div');
        slickItem.className = 'slick-item';

        var normalDiv = document.createElement('div');
        normalDiv.style.backgroundImage = 'url(\"' + small_image + '\")';
        normalDiv.innerHTML = 'بررسی '
        normalDiv.innerHTML += title;
        normalDiv.className = 'slick-img-container';
        normalDiv.style.display = 'flex';

        var captionDiv = document.createElement('div');
        captionDiv.className = 'slick-caption';
        var capTitle = document.createElement('div');
        capTitle.innerHTML = title;
        capTitle.className = 'cap-title';
        var comments = document.createElement('div');
        comments.innerHTML = 'تعداد نظرات:' + number_of_comments;
        var gameLink = document.createElement('a');
        gameLink.className = 'btn-default';
        gameLink.innerHTML = 'صفحه بازی';
        gameLink.setAttribute('href', 'game_page.html?game_title=' + title);


        captionDiv.style.display = 'none';

        captionDiv.appendChild(capTitle);
        captionDiv.appendChild(comments);
        captionDiv.appendChild(gameLink);
        slickItem.appendChild(normalDiv);
        slickItem.appendChild(captionDiv);
        homeSlickSlider.appendChild(slickItem);
    }

    function addGame(game) {
        var title = game.getElementsByTagName('title')[0].childNodes[0].nodeValue;
        var abstract = game.getElementsByTagName('abstract')[0].childNodes[0].nodeValue;
        var large_image = game.getElementsByTagName('large_image')[0].childNodes[0].nodeValue;
        var small_image = game.getElementsByTagName('small_image')[0].childNodes[0].nodeValue;
        var number_of_comments = game.getElementsByTagName('number_of_comments')[0].childNodes[0].nodeValue;

        addMainSlider(title, abstract, large_image);
        addSmallSlider(title, number_of_comments, small_image);
    }

    function addNewGame(game) {
        var title = game.getElementsByTagName('title')[0].childNodes[0].nodeValue;
        var newGameSlider = document.getElementById('new-games-slider');

        var gameItem = document.createElement('a');
        gameItem.setAttribute('href', 'game_page.html?game_title=' + title);
        gameItem.className = 'slick-item game-card';

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
        cardContent.innerHTML += '<input type="text" class="kv-fa-star rating-loading new-games-stars" value="' + game.getElementsByTagName('rate')[0].childNodes[0].nodeValue + '" dir="rtl" data-size="xs" title="">';
        gameItem.appendChild(gameImg);
        gameItem.appendChild(cardContent);
        newGameSlider.appendChild(gameItem);
    }

    function renderNewGamesSlider(slidesNum) {
        var active = slidesNum;

        $('.new-games-stars').rating({
            showClear: false,
            showCaption: false,
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>',
            displayOnly: true
        });

        function getSlidesToShow(num) {
            active = Math.min(num, active);
            return active;
        }

        $('#new-games-slider').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: active,
            slidesToScroll: active,
            rtl: false,
            arrows: false,
            draggable: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: getSlidesToShow(3),
                        slidesToScroll: getSlidesToShow(3),
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: getSlidesToShow(2),
                        slidesToScroll: getSlidesToShow(2)
                    }
                }
            ]
        });
    }

    function addComment(comment) {
        var text = comment.getElementsByTagName('text')[0].childNodes[0].nodeValue;
        var date = comment.getElementsByTagName('date')[0].childNodes[0].nodeValue;
        var avatar = comment.getElementsByTagName('player')[0].getElementsByTagName('avatar')[0].childNodes[0].nodeValue;

        var commentsDiv = document.getElementById('comments');

        var commentCard = document.createElement('a');
        commentCard.setAttribute('href', 'game_page.html?game_title=' + comment.getElementsByTagName('game')[0].getElementsByTagName('title')[0].childNodes[0].nodeValue + '&tab=2')
        commentCard.className = 'horiz-card row';

        var cardContent = document.createElement('div');
        cardContent.className = 'horiz-card-content col-sm-8';

        var imgContainer = document.createElement('div');
        imgContainer.className = 'horiz-card-img col-sm-2';

        var avatarimg = document.createElement('img');
        avatarimg.setAttribute('src', avatar);

        var comtext = document.createElement('h4');
        comtext.innerHTML = text;

        var comdate = document.createElement('h5');
        comdate.innerHTML = date;

        cardContent.appendChild(comtext);
        cardContent.appendChild(comdate);
        imgContainer.appendChild(avatarimg);
        commentCard.appendChild(imgContainer);
        commentCard.appendChild(cardContent);
        commentsDiv.appendChild(commentCard);
    }

    function addTutorial(tutorial) {
        console.log(tutorial);
        var title = tutorial.getElementsByTagName('title')[0].childNodes[0].nodeValue;
        var date = tutorial.getElementsByTagName('date')[0].childNodes[0].nodeValue;
        var smalllImg = tutorial.getElementsByTagName('game')[0].getElementsByTagName('small_image')[0].childNodes[0].nodeValue;

        var tutorsDiv = document.getElementById('tutors');

        var tutorCard = document.createElement('a');
        tutorCard.setAttribute('href', 'game_page.html?game_title=' + tutorial.getElementsByTagName('game')[0].getElementsByTagName('title')[0].childNodes[0].nodeValue + '&tab=0')
        tutorCard.className = 'horiz-card row';

        var cardContent = document.createElement('div');
        cardContent.className = 'horiz-card-content col-sm-8';

        var imgContainer = document.createElement('div');
        imgContainer.className = 'horiz-card-img col-sm-2';

        var gameimg = document.createElement('img');
        gameimg.setAttribute('src', smalllImg);

        var tutortext = document.createElement('h4');
        tutortext.innerHTML = title;

        var tutordate = document.createElement('h5');
        tutordate.innerHTML = date;

        cardContent.appendChild(tutortext);
        cardContent.appendChild(tutordate);
        imgContainer.appendChild(gameimg);
        tutorCard.appendChild(imgContainer);
        tutorCard.appendChild(cardContent);
        tutorsDiv.appendChild(tutorCard);
    }

    function renderHomePage(homepage) {
        var activeSlidesNumber = 7;
        var slider = homepage.getElementsByTagName('slider')[0];
        var games = slider.getElementsByTagName('game');
        var gamesNumber = games.length;

        gamesNumber *= 5;//------------------------------------------------------------------------TEMP---------------

        if (gamesNumber <= activeSlidesNumber) {
            activeSlidesNumber = gamesNumber - (gamesNumber % 2) - 1;
            if (activeSlidesNumber <= 0) {
                activeSlidesNumber = 1;
            }
        }

        // for (i = 0; i < gamesNumber; i++) {
        //     addGame(games[i], i);
        // }

        for (j = 0; j < 5; j++) {//----------------------------------------------------------------TEMP---------------
            for (i = 0; i < games.length; i++) {
                addGame(games[i], (j * games.length) + i);
            }
        }//----------------------------------------------------------------------------------------TEMP---------------

        renderSlider(activeSlidesNumber);
        makeListeners();
        initSliders();

        var newGames = homepage.getElementsByTagName('new_games')[0].getElementsByTagName('game');
        var newGamesNumber = newGames.length * 3;
        var activeNewGameSlides = 4;
        if (0 < newGamesNumber && newGamesNumber < activeNewGameSlides) {
            activeNewGameSlides = newGamesNumber - 1;
        }
        for (j = 0; j < 3; j++) {
            for (i = 0; i < newGames.length; i++) {
                addNewGame(newGames[i]);
            }
        }
        renderNewGamesSlider(activeNewGameSlides);

        var comments = homepage.getElementsByTagName('comments')[0].getElementsByTagName('comment');
        for (i = 0; i < comments.length; i++) {
            addComment(comments[i]);
        }

        var tutors = homepage.getElementsByTagName('tutorials')[0].getElementsByTagName('tutorial');
        for (i = 0; i < tutors.length; i++) {
            addTutorial(tutors[i]);
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