var currentLevel = 0;
var lastLevel = 0;
var score = 0;
var mScore = 6;
var maxTime = 100;
var timer = maxTime;
var stop = false;
var intervalID;
var game;
var orderNumbers;
var selectedCards = 0;
var lastCard;
var gamePath = '/images/forGame/';
var disabled = false;
$(document).ready(function () {
    game = $('#game');
    if (game.length > 0) {
        loadGame();
    }

});
$(window).load(function() {
    game.html('');
    showStartScreen(game);
});

function loadGame() {
    game = $('#game');
    game.append($('<div>').css({'text-align':'center'}).text('Loading . . .'));

    var aImages = [];
    for (var i = 1; i <= 20; i++) {
        var img = new Image();
        img.src = gamePath + 'cards/card' + i + '.png';
        aImages.push(img);
    }
    for (var i = 1; i <= 40; i++) {
        var img = new Image();
        img.src = gamePath + 'cards/overlay' + i + '.png';
        aImages.push(img);
    }
    var imagesList = [
        'clock.png',
        'closeButton.png',
        'closeButtonHovered.png',
        'fb.png',
        'gameMenuShadow.png',
        'gameOver.png',
        'messageBG.png',
        'play.png',
        'playBG.png',
        'playBGHover.png',
        'radio.png',
        'radioSelected.png',
        'radioSub.png',
        'radioSubSelected.png',
        'replayButton.png',
        'replayButtonHover.png',
        'shadow.png',
        'star.png',
        'startScreenBG.png',
        'subMenuBG.png',
        'tw.png',
        'vk.png',
        'winnerBG.png'
    ];
    for (var i = 0, len = imagesList.length; i < len; i++) {
        var img = new Image();
        img.src = gamePath + imagesList[i];
        aImages.push(img);
    }
}


function mainMenuLevelsClick(current) {
    lastLevel = currentLevel;
    currentLevel = $(current).attr('id');
    if ($('.cardsWrapper').length > 0) {
        if (disabled == true) return false;
        showMessage();
        return false;
    }
    $('.mainMenuLevels .selectedItem').removeClass('selectedItem');
    $(current).addClass('selectedItem');
    return false;
}

function playButtonClick() {
    if (disabled == true) return false;
    timer = maxTime;
    clearInterval(intervalID);
    score = 0;
    if($('.card').length > 0){
        $('.card').imagecube('stop');
        $('.card').imagecube('destroy');
    }
    showGameScreen(game);
    showAllCards();
}
function NOButtonClick() {
    currentLevel = lastLevel;
    $('.messageWrapper').remove();
    startCountDown();
}

function cardClick(current) {
    if (current == lastCard || disabled == true) return false;
    selectedCards++;
    if (selectedCards == 1) {
        lastCard = current;
        turnCard(current, 'right');
    }
    else if (selectedCards == 2) {

        turnCard(current, 'right');
        setTimeout(function () {
            if (orderNumbers[$(current).attr('id').substr(5)] != orderNumbers[$(lastCard).attr('id').substr(5)]) {
                turnCard(lastCard, 'left');
                turnCard(current, 'left');
            }
            else {
                score++;
                $('.scoreCount .sCount').html(score);
                $(lastCard).attr('onclick', '');
                $(current).attr('onclick', '');
                if (score == mScore) showWinnerScreen();

            }
            lastCard = null;
            selectedCards = 0;

        }, 300);
    }
    return true;
}

function turnCard(card, direction) {
    $(card).imagecube({
        direction: direction,
        speed:'500',
        repeat:false,
        pause:0
    });
    return $(card).imagecube('rotate', 'next');
}

function startCountDown() {
    clearInterval(intervalID);
    if(timer > 0) $('.countDown .count').text(--timer);
    intervalID = setInterval(function () {
        if (timer == 0 || stop == true) {
            clearInterval(intervalID);
            if (score != mScore) showGameOverScreen();
        }
        else{
            $('.countDown .count').text(--timer);
        }
    }, 1000);
}

function createElem(elem, className) {
    var newDiv = $('<' + elem + '>');
    newDiv.attr('class', className);
    return newDiv;
}
function createElemID(elem, idName) {
    var newDiv = $('<' + elem + '>');
    newDiv.attr('id', idName);
    return newDiv;
}

function generateLevelMenu() {
    var ul = createElem('ul', 'mainMenuLevels');
    var levels = ['НОВИЧОК', 'МАСТЕР', 'ПРОФЕССИОНАЛ'];
    for (var i = 0; i < 3; i++) {
        var li = $('<li>');
        if (i == currentLevel) {
            li.attr('class', 'selectedItem');
        }
        li.attr('onclick', 'mainMenuLevelsClick(this);');
        li.attr('id', i);
        li.text(levels[i]);
        ul.append(li);
    }
    return ul;
}


function showStartScreen(game) {
    var startScreen = createElem('div', 'startScreen');
    var mainMenu = createElem('div', 'mainMenu');
    var title = createElem('h1', 'mainMenuTitle');
    title.text('НАЙДИ ПАРУ');
    var text = createElem('p', 'mainMenuText');
    text.html('Картинки в «Доме со львом», нарисованные ещё<br/>в начале ХХ века, сто лет были спрятаны от нас —<br/>о них почти никто не знал. Теперь Дом открыт и<br/>известен, но картинкам так понравилось прятаться!<br/>Найдите парные картинки и почувствуйте себя<br/>первооткрывателем Дома!');

    var button = createElem('div', 'playButton');
    button.attr('onclick', 'playButtonClick();');
    var play = createElem('div', 'playButtonText');
    var shadow = createElem('div', 'playButtonShadow');
    button.append(play).append(shadow);
    mainMenu.append(title)
        .append(text)
        .append(generateLevelMenu())
        .append(button);
    game.append(startScreen.append(mainMenu));
    $('.gameField').css('border', 'solid 2px #999');
}

function showAllCards() {
    disableScreen();
    var cardsNumbers = new Array();
    orderNumbers = new Array();
    for (var i = 1; i <= mScore; i++) {
        cardsNumbers.push(i);
    }
    while (cardsNumbers.length != 0) {
        var randNumber = Math.floor(Math.random() * (cardsNumbers.length));
        var RandElement = cardsNumbers[randNumber];
        if (orderNumbers.indexOf(RandElement) != -1) {
            orderNumbers.push(RandElement);
            cardsNumbers.splice(randNumber, 1);
        }
        else {
            orderNumbers.push(RandElement);
        }
    }
    var cardsWrapper = createElem('div', 'cardsWrapper');
    for (var i = 0; i < orderNumbers.length; i++) {
        var card = createElem('div', 'card');
        card.append($('<img>').attr('src', gamePath + 'cards/card' + orderNumbers[i] + '.png'));
        card.attr('id', 'card_' + i);
        cardsWrapper.append(card);
    }
    $('.gameField').append(cardsWrapper);
    var width = '340px';
    var top = '96px';
    var left = '180px';
    var x = 4;

    if (currentLevel == 1) {
        width = '425px';
        top = '57px';
        left = '137px';
        x = 5;
    }
    else if (currentLevel == 2) {
        width = '680px';
        top = '11px';
        left = '10px';
        x = 8;
    }
    cardsWrapper.css({width:width, top:top, left:left});

    setTimeout(function () {
        var overlayNumber = 1;
        var maxX = 8;
        var i = 0;
        var hideInterval = setInterval(function () {
            if (i == orderNumbers.length) clearInterval(hideInterval);
            if (overlayNumber > x) {
                overlayNumber = maxX + 1;
                x += 8;
                maxX += 8;
            }
            $('#card_' + i).append($('<img>').attr('src', gamePath + 'cards/overlay' + overlayNumber + '.png'));
            $('#card_' + i).attr('onclick', 'cardClick(this);');
            var lastAnimate = turnCard($('#card_' + i), 'right');
            if( i == orderNumbers.length - 1) {
                lastAnimate.promise().done(function() {
                    startCountDown();
                    enableScreen();
                });
            }
            i++;
            overlayNumber++;
        }, 100);
    }, 1500);
}

function showGameScreen(game) {
    game.html('');
    var gameField = createElem('div', 'gameField');
    var gameMenu = createElem('div', 'gameMenu');
    var submenu = createElem('div', 'gameSubmenu');
    var countDown = createElem('div', 'countDown');
    var count = createElem('div', 'count');
    count.text(timer);
    var clock = createElem('div', 'clock');
    countDown.append(count).append(clock);
    submenu.append(countDown).append(createElem('div', 'separator'));
    var menuLevel = createElem('div', 'menuLevel');
    menuLevel.append(generateLevelMenu());
    submenu.append(menuLevel).append(createElem('div', 'separator'));
    var score = createElem('div', 'score');
    var star = createElem('div', 'star');
    var scoreCount = createElem('div', 'scoreCount');
    var sCount = createElem('span', 'sCount');
    sCount.text('0');
    var scoreText = createElem('span', 'text');
    scoreText.text(' из ');
    var maxScore = createElem('span', 'maxCount');
    if (currentLevel == 0) mScore = 6;
    else if (currentLevel == 1) mScore = 10;
    else if (currentLevel == 2) mScore = 20;
    maxScore.text(mScore);
    scoreCount.append(sCount).append(scoreText).append(maxScore);
    score.append(star).append(scoreCount);
    submenu.append(score).append(createElem('div', 'separator'));
    var replayButton = createElem('div', 'replayButton');
    replayButton.attr('onclick', 'playButtonClick();');
    var replayText = createElem('div', 'replayText');
    replayText.text('НАЧАТЬ ЗАНОВО');
    replayButton.append(replayText);
    var gameMenuShadow = createElem('div', 'gameMenuShadow');
    gameMenu.append(submenu)
        .append(replayButton)
        .append(gameMenuShadow);
    game.append(gameField).append(gameMenu);
}

function showGameOverScreen() {
    var gameField = $('.gameField');
    gameField.html('');
    var text = createElem('div', 'gameOverText');
    text.html('Не расстраивайтесь!<br/>У нас тоже сразу не получалось!<br/>Попробуйте ещё раз — картинки ждут!');
    var img = createElem('div', 'gameOverImg');
    gameField.append(text).append(img);
}

function showWinnerScreen() {
    clearInterval(intervalID);
    $('.card').imagecube('destroy');
    var gameField = $('.gameField');
    gameField.html('');
    gameField.css('border-color', '#cccc00');
    var winnerBG = createElem('div', 'winnerBG');
    var title = createElem('h1', 'winnerTitle');
    title.text('ПОЗДРАВЛЯEM!');
    var text = createElem('p', 'winnerText');
    text.html('Вы открыли все картинки в Доме!<br/>Теперь вы в нашей команде первооткрывателей.');
    var share = createElem('div', 'winnerShare');
    share.text('Рассказать друзьям:');
    var vk = createElemID('div', 'vk_game');
    var tw = createElem('div', 'tw_game');
    var fb = createElemID('div', 'fb_game');
    share.append(vk)
        .append(tw)
        .append(fb);
    gameField.append(winnerBG)
        .append(title)
        .append(text)
        .append(share);

    var shareTitle='Дом со львом';
    var url = window.location.toString();
    var summary = 'Я открыл все картинки в Доме!';
    fb.append($('<a>').attr({href: "http://www.facebook.com/sharer.php?s=100&p[title]=" + shareTitle + "&p[summary]=" + summary + "&p[url]=" + url,
        'target': '_blank'
    }).css({width: '100%', height: '100%', display: 'block'}));


    var shareText = 'Я открыл все картинки в Доме!';
    tw.append($('<a>').attr({href: "https://twitter.com/share?text=" + shareText,
        'target': '_blank'
    }).css({width: '100%', height: '100%', display: 'block'}));

    document.getElementById('vk_game').innerHTML = VK.Share.button({
        url: 'http://lion-house.ru/museum/game.php',
        title: 'Дом со Львом',
        description: 'Я открыл все картинки в Доме!',
        image: '',
        noparse: true
    }, {type: 'custom', text: '<div style="width:32px;height:32px;"></div>'} );
}


function showMessage() {
    clearInterval(intervalID);
    if ($('.messageWrapper').length > 0) return false;
    var messageWrapper = createElem('div', 'messageWrapper');
    var messageBG = createElem('div', 'messageBG');
    if (lastLevel == 2) {
        messageBG.css({width:'680px', height:'425px', top:'11px', left:'10px'});
    }
    var closeMessage = createElem('div', 'closeMessage');
    closeMessage.attr('onclick', 'NOButtonClick();');
    messageBG.append(closeMessage);
    var textMessage = createElem('div', 'textMessage');
    textMessage.html('Изменение уровня приведёт к обновлению игры.<br/>Хотите начать новую игру?');
    var buttonYES = createElem('div', 'buttonYES');
    buttonYES.text('ДА');
    buttonYES.attr('onclick', 'playButtonClick();');
    var buttonNO = createElem('div', 'buttonNO');
    buttonNO.text('НЕТ');
    buttonNO.attr('onclick', 'NOButtonClick();');
    messageWrapper.append(messageBG)
        .append(textMessage)
        .append(buttonYES)
        .append(buttonNO);
    $('.gameField').append(messageWrapper);
    return true;
}

function disableScreen(){
    disabled = true;
    $('#game').append($('<div>').css({position: 'absolute', width: '100%', height: '100%', 'z-index': 9999, top: 0, left: 0}).attr('class', 'disableScreen'));
}
function enableScreen() {
    disabled = false;
    $('.disableScreen').remove();
}