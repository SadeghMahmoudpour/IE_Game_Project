// Test Funcs
// See Inspect Element's Console Log Output

(function () {
    var interval = null;
    var winInterval = null;
    var mouseDown = false;
    var endGame = false;
    var notFound = 0;
    var username = '';
    var levels = [];
    var game_id;
    var game_title;
    var cellwidth = 24;
    var cellheight = 24;

    getGameXML(xmlParser);
    function xmlParser(xml_str) {
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(xml_str, "text/xml");
        var game = xmlDoc.getElementsByTagName("game")[0];
        game_title = game.getAttribute("title");
        game_id = game.getAttribute("id");
        if (game_id != "minesweeper")window.alert("This game is not Minesweeper!");
        var levels_tag = game.getElementsByTagName("levels")[0];
        var levels_list = levels_tag.getElementsByTagName("level");
        for (i = 0; i < levels_list.length; i++) {
            var level = levels_list[i];
            levels.push({
                id: level.getAttribute("id"),
                title: level.getAttribute("title"),
                timer: (level.getAttribute("timer") == "true"),
                rows: level.getElementsByTagName("rows")[0].childNodes[0].nodeValue,
                cols: level.getElementsByTagName("cols")[0].childNodes[0].nodeValue,
                mines: level.getElementsByTagName("mines")[0].childNodes[0].nodeValue,
                time: level.getElementsByTagName("time")[0].childNodes[0].nodeValue
            });
        }

        createElements(game_title, levels);
        newGame(1);
    }

    function newGame(lvlid) {
        var level = levels[lvlid - 1];
        getNewGame(`<request>
             <rows>${level.rows}</rows>
             <cols>${level.cols}</cols>
             <mines>${level.mines}</mines>
        </request>`, function (xmlStr) {

// Process and convert xmlStr to DOM using XSLTProcessor
            var parser = new DOMParser();
            var xsltProcessor = new XSLTProcessor();
            xsltProcessor.importStylesheet(makeXSL());

            var xmlDoc = parser.parseFromString(xmlStr, "text/xml").childNodes[0];
            var fragment = xsltProcessor.transformToFragment(xmlDoc, document);

            var old_grid = document.getElementsByClassName('grid')[0];
            old_grid.parentNode.replaceChild(fragment, old_grid);
        });
        manageElements(level);
        setWinInterval(lvlid);
    }

    //---------------------------------------------------------------------WIN FUNCTION----------------------------------
    function checkWin() {
        var grid = document.getElementsByClassName("grid")[0];
        var cells = grid.getElementsByTagName("span");
        for (i = 0; i < cells.length; i++) {
            if (cells[i].getAttribute('data-value') != 'mine' && cells[i].getAttribute('class') != 'revealed')return false;
        }
        return true;
    }

    function setWinInterval(lvlid) {
        winInterval = setInterval(function () {
            if (checkWin()) {
                endGame = true;
                if (interval != null) {
                    clearInterval(interval);
                }
                document.getElementsByClassName("counter")[0].innerHTML = 0;
                showflags();
                changeSmile("win");
                window.alert("YOU WIN " + username + "!");
                clearInterval(winInterval);
                $.ajax({
                    type: "POST",
                    url: 'http://localhost:8000/api/minesweeper',
                    data: {"score": JSON.stringify(document.getElementsByClassName("counter")[1].innerHTML),
                    "level":JSON.stringify(lvlid)},
                    cache: false,
                    success: function (result) {
                        console.log(result);
                        if(result == 'success'){
                            alert('دمت گرم امتیازت رفت بالاتر');
                        }
                    },
                });
                if (lvlid < levels.length)newGame(lvlid + 1);
            }
        }, 1000);
    }

    function showflags() {
        var grid = document.getElementsByClassName("grid")[0];
        var cells = grid.getElementsByTagName("span");
        for (i = 0; i < cells.length; i++) {
            var cell = cells[i];
            if (cell.getAttribute("data-value") == "mine") {
                cell.className = "flag";
            }
        }
    }

    //---------------------------------------------------MANAGE ELEMENTS FOR NEW LEVEL-------------------------------------------------
    function manageElements(level) {
        if (interval != null) {
            clearInterval(interval);
        }
        if (winInterval != null) {
            clearInterval(winInterval);
        }
        changeSmile(null);
        winInterval = null;
        interval = null;
        mouseDown = false;
        endGame = false;
        notFound = level.mines;

        var counters = document.getElementsByClassName("counter");
        var remainedMinesCounter = counters[0];
        remainedMinesCounter.innerHTML = level.mines;
        var timer = counters[1];
        timer.innerHTML = 0;
        if (level.timer) {
            timer.innerHTML = level.time;
        }

        document.addEventListener("mouseup", documentmouseup);

        var mywindow = document.getElementsByClassName("window")[0];
        mywindow.addEventListener('mousedown', event => event.preventDefault());
        mywindow.style.width = ((level.cols * cellwidth) + 16) + "px";
        mywindow.style.height = "auto";

        document.getElementById("game-title").innerHTML = game_title + " - " + level.title;

        var grid = mywindow.getElementsByClassName("grid")[0];
        // grid.setAttribute("style", "margin:8px;");
        grid.style.margin = '8px';
        grid.addEventListener('contextmenu', event => event.preventDefault());
        if (level.timer) {
            grid.addEventListener("mouseup", startTimer);
        }
        grid.addEventListener("mouseup", gridmouseup);
        grid.addEventListener("mousedown", gridmousedown);

        var cells = grid.getElementsByTagName("span");
        for (i = 0; i < cells.length; i++) {
            // cells[i].setAttribute("style", "flex: none; width:1.5rem; height:1.5rem;");
            cells[i].style.flex = "none";
            cells[i].style.width = cellwidth + 'px';
            cells[i].style.height = cellheight + 'px';
            if (!level.timer) {
                cells[i].addEventListener("mouseup", startCounter);
            }
            cells[i].addEventListener("mouseup", cellmouseup);
            cells[i].addEventListener("mousedown", cellmousedown);
            cells[i].addEventListener("mouseleave", cellmouseleave);
            cells[i].addEventListener("mouseenter", cellmouseenter);
            cells[i].addEventListener("click", cellclick);
        }

        //--------------------------------------------------------WINDOW SIZE CHANGER-----------------------------------------
        mywindow.addEventListener("mousedown", function (e) {
            var lcorner = mywindow.offsetLeft + mywindow.clientWidth - 10;
            var rcorner = mywindow.offsetLeft + mywindow.clientWidth + 10;
            var ucorner = mywindow.offsetTop + mywindow.clientHeight - 10;
            var dcorner = mywindow.offsetTop + mywindow.clientHeight + 10;
            // console.log(lcorner, rcorner, ucorner, dcorner, e.clientX, e.clientY);
            if (e.clientX < rcorner && e.clientX > lcorner && e.clientY < dcorner && e.clientY > ucorner) {
                document.addEventListener("mousemove", mywinresize, true);
            }
        }, false);
        document.addEventListener("mouseup", function () {
            document.removeEventListener("mousemove", mywinresize, true);
        }, false);
        function mywinresize(e) {
            var winwidth = e.clientX - mywindow.offsetLeft;
            var winheight = e.clientY - mywindow.offsetTop;
            mywindow.style.width = (winwidth) + 'px';
            mywindow.style.height = (winheight) + 'px';
            cellwidth = Math.floor((winwidth - 16) / level.cols);
            cellheight = Math.floor((winheight - 16) / level.rows);
            var sidemargin = Math.floor((winwidth - (level.cols * cellwidth)) / 2);
            for (j = 0; j < cells.length; j++) {
                cells[j].style.width = (cellwidth) + 'px';
                cells[j].style.height = (cellheight) + 'px';
            }
            grid.style.margin = ("8px "+sidemargin+"px");
            mywindow.style.height = "auto";
        }

        //-------------------------------------------------------------------------------------------------
    }

    //-----------------------------------------------------------CONTROLLER LISTENERS------------------------
    function cellclick(e) {
        if (e.button == 0) {
            if (this.className == "revealed") {
                var datavalue = this.getAttribute("data-value");
                if (datavalue != null && datavalue.match(/^[0-9]$/)) {
                    var row_col = this.id.split("-");
                    var row = parseInt(row_col[0]);
                    var col = parseInt(row_col[1]);
                    var bombnum = parseInt(datavalue);
                    var flagnum = 0;
                    var i = -1;
                    var j = -1;
                    for (i = -1; i < 2; i++) {
                        for (j = -1; j < 2; j++) {
                            if (!(i == 0 && j == 0)) {
                                var neighbor = document.getElementById((row + i) + "-" + (col + j));
                                if (neighbor != null && neighbor.className == "flag")flagnum++;
                            }
                        }
                    }
                    if (bombnum == flagnum) {
                        for (i = -1; i < 2; i++) {
                            for (j = -1; j < 2; j++) {
                                if (!(i == 0 && j == 0)) {
                                    if (revealNeighbors(document.getElementById((row + i) + "-" + (col + j))))gameOver((row + i) + "-" + (col + j));
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function cellmouseenter() {
        if (mouseDown && !this.hasAttribute("class")) {
            this.className = "active";
        }
    }

    function cellmouseleave() {
        if (this.className == "active") {
            this.removeAttribute("class");
        }
    }

    function cellmousedown(e) {
        if (!endGame) {
            if (e.button == 0) {
                if (!this.hasAttribute("class")) {
                    this.className = "active";
                }
            } else if (e.button == 1) {
                if (this.className == "question") {
                    this.removeAttribute("class");
                } else if (!this.hasAttribute("class")) {
                    this.className = "question";
                }
            } else if (e.button == 2) {
                if (this.className == "flag") {
                    this.className = "question";
                    notFound++;
                } else if (this.className == "question") {
                    this.removeAttribute("class");
                } else if (!this.hasAttribute("class") && notFound > 0) {
                    this.className = "flag";
                    notFound--;
                }
                mineCounter();
            }
        }
    }

    function cellmouseup(e) {
        if (e.button == 0) {
            if (mouseDown && this.getAttribute("class") == "active") {
                if (revealNeighbors(this)) {
                    gameOver(this.id);
                }
            }
        }
    }

    function documentmouseup(e) {
        mouseDown = false;
        if (e.button == 0) {
            if (document.getElementsByClassName("smile")[0].getAttribute("data-value") == "hover") {
                changeSmile("ok");
            }
        }
    }

    function gridmouseup(e) {
        if (!document.getElementsByClassName("smile")[0].hasAttribute("data-value"))changeSmile("ok");
    }

    function gridmousedown(e) {
        if (!endGame) {
            mouseDown = true;
            if (e.button == 0) {
                changeSmile("hover");
            }
        }
    }

    //--------------------------------------------------------CHANGES SMILE DATA VALUE------------------------
    function changeSmile(status) {
        var smile = document.getElementsByClassName("smile")[0];
        if (status == null) {
            smile.removeAttribute("data-value");
        } else {
            smile.setAttribute("data-value", status);
        }
    }

    //-------------------------------------------------------CLICK COUNTER WHEN LEVEL DOES'T HAVE TIMER-----------
    function startCounter(e) {
        if (!endGame && e.button == 0) {
            var counter = document.getElementsByClassName("counter")[1];
            counter.innerHTML = parseInt(counter.innerHTML) + 1;
        }
    }

    //--------------------------------------------------------COUNTS REMINDED MINES--------------------------
    function mineCounter() {
        document.getElementsByClassName("counter")[0].innerHTML = notFound;
    }

    //------------------------------------------------------------------------------------------------------
    function revealNeighbors(cell) {
        if (cell == null || cell.className == "revealed" || cell.className == "flag")return false;
        if (cell.getAttribute("data-value") == "mine")return true;
        var row_col = cell.id.split("-");
        var row = parseInt(row_col[0]);
        var col = parseInt(row_col[1]);

        cell.className = "revealed";

        var bombs = 0;
        for (i = -1; i < 2; i++) {
            for (j = -1; j < 2; j++) {
                if (!(i == 0 && j == 0)) {
                    var neighbor = document.getElementById((row + i) + "-" + (col + j));
                    if (neighbor != null && neighbor.getAttribute("data-value") == "mine")bombs++;
                }
            }
        }
        if (bombs == 0) {
            revealNeighbors(document.getElementById((row - 1) + "-" + (col - 1)));
            revealNeighbors(document.getElementById((row - 1) + "-" + col));
            revealNeighbors(document.getElementById((row - 1) + "-" + (col + 1)));
            revealNeighbors(document.getElementById(row + "-" + (col - 1)));
            revealNeighbors(document.getElementById(row + "-" + (col + 1)));
            revealNeighbors(document.getElementById((row + 1) + "-" + (col - 1)));
            revealNeighbors(document.getElementById((row + 1) + "-" + col));
            revealNeighbors(document.getElementById((row + 1) + "-" + (col + 1)));
        } else {
            cell.setAttribute("data-value", bombs);
        }
        return false;
    }

    //--------------------------------------------------------STARTS LEVEL TIMER------------------------------------
    function startTimer() {
        if (interval == null) {
            interval = setInterval(function () {
                var timer = document.getElementsByClassName("counter")[1];
                var time = parseInt(timer.innerHTML) - 1;
                timer.innerHTML = time;
                if (time == -1) {
                    gameOver(null);
                    timer.innerHTML = 0;
                }
            }, 1000);
        }
    }

    //----------------------------------------------------------GAME OVER---------------------------------------------
    function gameOver(cellid) {
        endGame = true;
        if (interval != null) {
            clearInterval(interval);
        }
        if (winInterval != null) {
            clearInterval(winInterval);
        }
        changeSmile("normal");
        showMines(cellid);
        window.alert("YOU LOST " + username + "!");
    }

    function showMines(cellid) {
        var grid = document.getElementsByClassName("grid")[0];
        var cells = grid.getElementsByTagName("span");
        for (i = 0; i < cells.length; i++) {
            var cell = cells[i];
            if (cell.getAttribute("data-value") == "mine") {
                cell.className = "revealed";
                if (cellid != null && cellid == cell.id) {
                    cell.style.color = "#810500";
                }
            }
        }
    }

    //----------------------------------------------------------------------MAKE XSL------------------------------
    function makeXSL() {
// This XSL Should Convert level.xml to
// appreciate DOM elements for #grid.
        var xsltText = `
            <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
            <xsl:template match="/grid">              
                <div class="grid">                    
                    <xsl:for-each select="/grid/row">                      
                        <xsl:for-each select="./col">                        
                            <span>
                                <xsl:attribute name="id">
                                    <xsl:value-of select="../@row"/>-<xsl:value-of select="@col"/>
                                </xsl:attribute> 
                                <xsl:if test="@mine">
                                    <xsl:attribute name="data-value">mine</xsl:attribute>
                                </xsl:if>                                
                            </span>
                        </xsl:for-each>
                    </xsl:for-each>                    
                </div>
            </xsl:template>
            </xsl:stylesheet>
            `;

        var parser = new DOMParser();
        return parser.parseFromString(xsltText, "text/xml").childNodes[0];
    }

    //------------------------------------------------------------CREATES PAGE ELEMENTTS---------------------------------
    function createElements(game_title, levels) {
        var body = document.body;
        body.style.position = "relative";

        var alertModal = document.createElement("div");
        alertModal.id = "alert-modal";
        alertModal.className = "modal";
        body.appendChild(alertModal);

        var modalContent = document.createElement("div");
        modalContent.className = "modal-content";
        alertModal.appendChild(modalContent);

        var nameInput = document.createElement("input");
        nameInput.id = "name";
        nameInput.className = "field";
        nameInput.placeholder = "Enter your name";
        nameInput.setAttribute("type", "text");
        modalContent.appendChild(nameInput);

        var button = document.createElement("button");
        button.innerHTML = "OK"
        modalContent.appendChild(button);
        //------------------------------------------------------------------MODAL GET USERNAME-----------------------
        button.addEventListener("click", function () {
            var input = nameInput.value;
            if (input.match(/^[a-z]*$/)) {
                username = input;
                alertModal.style.display = "none";
            } else {
                window.alert("UserName characters should be between a to z");
            }
        });

        var mywindow = document.createElement("div");
        mywindow.className = "window";
        mywindow.style.position = "absolute";
        body.appendChild(mywindow);

        var titleBar = document.createElement("div");
        titleBar.className = "title-bar";
        titleBar.style.cursor = "pointer";
        var leftoffset = 0;
        var topoffset = 0;
        //------------------------------------------------------------------WINDOW DRAG AND DROP---------------------
        titleBar.addEventListener("mousedown", function (e) {
            leftoffset = e.clientX - mywindow.offsetLeft;
            topoffset = e.clientY - mywindow.offsetTop;
            document.addEventListener("mousemove", mywinmove, true);
        }, false);
        document.addEventListener("mouseup", function () {
            document.removeEventListener("mousemove", mywinmove, true);
        }, false);
        function mywinmove(e) {
            mywindow.style.position = "absolute";
            mywindow.style.top = (e.clientY - topoffset) + 'px';
            mywindow.style.left = (e.clientX - leftoffset) + 'px';
        }

        mywindow.appendChild(titleBar);

        var gameTitle = document.createElement("span");
        gameTitle.id = "game-title";
        gameTitle.innerHTML = game_title + " - " + levels[0].title;
        titleBar.appendChild(gameTitle);

        var actionBar = document.createElement("div");
        titleBar.appendChild(actionBar);

        var btnMinimize = document.createElement("span");
        btnMinimize.id = "btn-minimize";
        btnMinimize.className = "btn";
        btnMinimize.innerHTML = "-";
        actionBar.appendChild(btnMinimize);

        var btnClose = document.createElement("span");
        btnClose.id = "btn-close";
        btnClose.className = "btn";
        btnClose.innerHTML = "x";
        actionBar.appendChild(btnClose);

        var top = document.createElement("div");
        top.className = "top";
        mywindow.appendChild(top);

        var counter1 = document.createElement("span");
        counter1.className = "counter";
        counter1.innerHTML = "0";
        top.appendChild(counter1);

        var smile = document.createElement("span");
        smile.className = "smile";
        //---------------------------------------------------NEW GAME BY CLICK ON SMILE-----------------------------
        smile.addEventListener("click", function () {
            var level = null;
            do {
                var input = prompt("Please enter game level(1 - " + levels.length + ")");
                level = parseInt(input);
            } while ((input != null && isNaN(level)) || level <= 0 || level > levels.length);
            if (!isNaN(level)) {
                newGame(level);
            }
        });
        smile.style.cursor = "pointer";
        top.appendChild(smile);

        var counter2 = document.createElement("span");
        counter2.className = "counter";
        counter2.innerHTML = "0";
        top.appendChild(counter2);

        var grid = document.createElement("div");
        grid.className = "grid";
        mywindow.appendChild(grid);

        document.write("<style>.grid span.flag:after {color:#ff1300 !important;} " +
            ".grid span.question:after { content:'?️' !important; color:lightseagreen !important;}</style>");
    }
}());

