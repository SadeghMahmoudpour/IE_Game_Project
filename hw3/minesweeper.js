// Test Funcs
// See Inspect Element's Console Log Output

getGameXML();
init();

getNewGame(`
    <request>
    <rows>3</rows>
    <cols>3</cols>
    <mines>3</mines>
    </request>
`);

function init() {
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

