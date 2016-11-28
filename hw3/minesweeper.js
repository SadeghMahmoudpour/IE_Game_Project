// Test Funcs
// See Inspect Element's Console Log Output

getNewGame(`
    <request>
    <rows>3</rows>
    <cols>3</cols>
    <mines>3</mines>
    </request>
`);

getGameXML(xmlParser);
createElements();

function xmlParser (xml) {
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xml, "text/xml");
    var game = xmlDoc.getElementsByTagName("game")[0];
    console.log(game);
    var game_title = game.getAttribute("title");
    console.log("game_title:", game_title);
    var game_id = game.getAttribute("id");
    console.log("game_id:", game_id);
    var levels = [];
    var levels_tag = game.getElementsByTagName("levels")[0];
    var levels_list = levels_tag.getElementsByTagName("level");
    for(i = 0; i<levels_list.length; i++){
        var level = levels_list[i];
        levels.push({
            id: level.getAttribute("id"),
            title: level.getAttribute("title"),
            timer: level.getAttribute("timer"),
            rows: level.getElementsByTagName("rows")[0].childNodes[0].nodeValue,
            cols: level.getElementsByTagName("cols")[0].childNodes[0].nodeValue,
            mines: level.getElementsByTagName("mines")[0].childNodes[0].nodeValue,
            time: level.getElementsByTagName("time")[0].childNodes[0].nodeValue
        });
    }
    console.log(levels);
    return {
        "game_title": game_title,
        "game_id": game_id,
        "levels": levels
    }
};


function createElements() {
    var body = document.body;

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
    modalContent.appendChild(nameInput);

    var button = document.createElement("button");
    button.innerHTML = "OK"
    modalContent.appendChild(button);

    var window = document.createElement("div");
    window.className = "window";
    body.appendChild(window);

    var titleBar = document.createElement("div");
    titleBar.className = "title-bar";
    window.appendChild(titleBar);

    var gameTitle = document.createElement("span");
    gameTitle.id = "game-title";
    gameTitle.innerHTML = "Minesweeper Online - Beginner!";
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
    window.appendChild(top);

    var counter = document.createElement("span");
    counter.className = "counter";
    counter.innerHTML = "123";
    top.appendChild(counter);

    var smile = document.createElement("span");
    smile.className = "smile";
    smile.setAttribute("data-value", "normal");
    top.appendChild(smile);

    var counter = document.createElement("span");
    counter.className = "counter";
    counter.innerHTML = "321";
    top.appendChild(counter);

    var grid = document.createElement("div");
    grid.className = "grid";
    window.appendChild(grid);
}

