<?php
require "db.php";
session_start();
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
function tabela()
{
    $con = povezavaBaza();
    $result = mysqli_query($con, "SELECT * FROM `rezultati` ORDER BY `st_pravilnih` DESC, `procenti` DESC LIMIT 10");
    $resultCheck = mysqli_num_rows($result);
    $a = 1;
    if ($resultCheck) {
        while($row=mysqli_fetch_assoc($result)){
            echo "<tr><td>" . $a . "</td><td>" . $row['ime'] . "</td><td>" . $row['priimek'] . "</td><td>" . $row['st_pravilnih'] . "</td><td>" . $row['st_napacnih'] . "</td><td>" .$row['procenti']. "</td></tr>";
            $a++;
        }

    }
}
if (!$_SESSION['login']) {
    $con = povezavaBaza();
    mysqli_query($con, "INSERT INTO `obiski`(`ip`) VALUES ('$ip')");
    mysqli_close($con);
    $_SESSION['login'] = 1;
}

error_reporting(0);

?>
    <!doctype html>
    <html lang="en">
    <head>
        <title>Hitri prsti</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Sen:400,700&display=swap" rel="stylesheet">
    <script src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<div class="container">
    <div class="header-options">
        <a onclick="$('#rules').modal('toggle')">Kako igrati?</a>
        <a onclick="$('#about').modal('toggle')">O projektu</a>
        <a onclick="$('#exampleModal').modal('toggle')">Lestvica</a>
    </div>
    <h4 class="text-center naslov">Hitri prsti</h4>

<div class="score">
    <span id="rightAnswers"></span>
    <span id="score-center"></span>
    <span id="wrongAnswers"></span>
</div>
    <div class="text-center" style="margin-top:50px">
        <div id="answer" class="input-field" style="display: inline-block;">&nbsp;</div>
    </div>
    <div class="keyboard">

    </div>
    <div class="row" style="margin-top: 30px">
        <div class="col-sm-6">
            <div class="row">
            <div class="col-sm-6">
                <input id="guess" class="input-field" value="">
            </div>
            <div class="col-sm-6">
                <div id="clock" class="clock"></div>
            </div>
        </div>
        </div>
        <div class="col-sm-6" style="text-align: right">
            <button class="btn-st" onclick="location.reload();" id="redoBtn">Ponovi</button>
            <button class="btn-st" onclick="startgame();" id="startBtn">začni</button>
            <button class="btn-st" onclick="stopGame();" id="stopBtn">ustavi</button>
        </div>
    </div>


    <div id="result" class="text-center">
        <table class="table">
            <tbody>
            <tr>
                <th>Število besed na minuto</th>
                <td id="numOfAll">0</td>

            </tr>
            <tr>
                <th>Natančnost</th>
                <td id="percentage">0</td>

            </tr>

            <tr>
                <th scope="row">Število pravilnih besed</th>

                <td id="numOfRight">0</td>
            </tr>
            <tr>
                <th scope="row">Število nepravilnih besed</th>

                <td id="numOfWrong">0</td>
            </tr>
            <tr>
                <th scope="row">Število pritiskov tipk</th>

                <td id="numOfClicks">0</td>
            </tr>
            </tbody>
        </table>
        <p id="shrani">Želiš rezultat shraniti na <span onclick="$('#exampleModal').modal('toggle')">lestvico</span>? <span class="da" onclick="document.getElementById('save').style.display='block'; location.href='#shrani'">Da</span></p>
        <div id="save" style="margin-bottom: 40px">
        <input type="text" placeholder="ime" id="ime">
        <input type="text" placeholder="priimek" id="priimek">
            <button onclick="save()" class="save-btn">Shrani</button>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Lestvica</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ime</th>
                            <th scope="col">Priimek</th>
                            <th scope="col">Pravilnih</th>
                            <th scope="col">Nepravilnih</th>
                            <th scope="col">%</th>
                        </tr>
                        </thead>
                        <tbody><?php
                        tabela();
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Zapri</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rules" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">kako igrati</h4>
                </div>
                <div class="modal-body">
                    <h5>1. Začetek igre: </h5>
                    <p>Igra se začne s pritiskom gumba "začni".</p>
                    <img src="img/zacni.JPG" style="height:35px">
                    <br>
                    <br>
                    <h5>2. Tipkanje: </h5>
                    <ul style="padding: 10px;">
                        <li>s pritiskanjem fizične tipkovnica (priporočljivo)</li>
                        <img src="img/real-keyboard.png" style="height:35px">
                        <br><br>
                        <li>s pritiskanjem virtualne tipkovnica</li>
                        <img src="img/virtual-keyboard.JPG" style="height:35px">
                    </ul>
                    <br>
                    <br>
                    <h5>3. Potrditev besed: </h5>
                    <p>Napisano besedo potrdimo s klikom na tipki "enter" ali "space".</p>
                    <br>
                    <br>
                    <h5>4. Premor: </h5>
                    <p>Igro ustavimo s klikom na gumb "ustavi".</p>
                    <img src="img/ustavi.JPG" style="height:35px">
                    <br>
                    <br>
                    <h5>5. Ponovni poskus: </h5>
                    <p>Poskus lahko ponovimo s osvežitvijo brskalnika ali s klikom na gumb "ponovi".</p>
                    <img src="img/ponovi.JPG" style="height:35px">
                    <br>
                    <br>
                    <h5>5. Cilj igre: </h5>
                    <p>Pravilno pretipkati čim več podanih besed brez gledanja na tipkovnico, s tem urimo našo orientacijo po tipkovnici ter hitrost tipkanja, časa pa imate natanko 60 sekund.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Zapri</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">O projektu</h4>
                </div>
                <div class="modal-body">
                    <h5>Pozdravljeni, </h5>
                    <p>"hitri prsti" je bil naslov ACM RTK 2020 (državnega tekmovanja iz znanja računalništva in informatike). Cilj naloge je bil v dveh urah razviti spletno aplikacijo, ki jo vidite pred seboj. Ideja naloge se mi je že takoj po prejetih navodilih zdela izredno zanimiva. Zato sem sklenil, da jo po oddaji ne glede na rezultat še nekoliko nadgradim in omogočil igranje širši javnosti, da si lahko zdaj, ko pouk poteka od doma gibanje na prostem pa je omejeno, nekoliko krajšamo čas in ne nazadnje tudi urimo možgane.</p>
                    <p>Vsem želim lep dan, obilo zdravja ter optimizma.</p>
                    <p style="text-align: right">- Žan Lah</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Zapri</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
    <div class="overlay text-center"><img style="margin-top: 50px; height: 200px; width:200px" src="https://cdn.jsdelivr.net/npm/@duetds/icons@latest/lib/assets/messaging-action-error.svg" alt="error"> <br><br> <h4>Se opravičujem, ampak spletna stran je namenjena le namiznim računalnikom.</h4></div>
<script>
    document.getElementById("stopBtn").disabled = true;
    var up = new Audio('coin.mp3');
    var bad = new Audio('bad.mp3');
    var play = false;
    var stop = false;
    var endGame = false;
    var numberOfClicks =0;
    var pravilnih =0;
    var napacnih = 0;
    var lastKey;
    var guess = document.getElementById('guess');
    var word= 0;
    var guessWord;
    var mozneBesede = [
        "abeceda",
        "papiga",
        "ja",
        "ne",
        "plavanje",
        "drevo",
        "akcija",
        "ustreza",
        "policija",
        "virus",
        "gasilec",
        "omara",
        "metulj",
        "mivka",
        "kraljica",
        "šah",
        "letalo",
        "avokado",
        "etrot",
        "reka",
        "odpoklic",
        "razhroščevalnik",
        "avtomobil",
        "motor",
        "napajalnik",
        "kozarec",
        "vrečka",
        "galvan",
        "amper",
        "doktor",
        "zobotrebec",
        "piščalka",
        "učbenik",
        "zvezek",
        "vodnik",
        "planetarij",
        "vezava",
        "astrofizik",
        "novica",
        "vesolje",
        "luknja",
        "avtobus",
        "mehanika",
        "direktor",
        "radio",
        "televizija",
        "pisanje",
        "klanec",
        "krojač",
        "študij",
        "fakulteta",
        "podpis",
        "državljanstvo",
        "matura",
        "glagol",
        "erotika",
        "dramatika",
        "impresionizem",
        "psevdonim",
        "umetnik",
        "galaksija",
        "umetnost",
        "komedija",
        "kobilica",
        "čebela",
        "konj",
        "lev",
        "računalnik",
        "prenosnik",
        "podloga",
        "opojnost",
        "pesnik",
        "dramatik",
        "komplet",
        "pepelka",
        "trnuljčica",
        "jogurt",
        "krava",
        "medved",
        "smog",
        "delo",
        "časopis",
        "članek",
        "večer",
        "minecraft",
        "gasilci",
        "drava",
        "sava",
        "mura",
        "jabolko",
        "češnja",
        "banana",
        "plastika",
        "aluminij",
        "očala",
        "sijalka",
        "kartica",
        "denar",
        "kovanec",
        "papir"
    ];

    var resitevArray = [];
    function generateWords(){
        resitevArray = [];
        for (var i = 0; i<5; i++){
            var random =Math.floor(Math.random()*100);
            if(checkWord(mozneBesede[random])){
                i--;
            }
            else {
                resitevArray.push(mozneBesede[random]);
            }
        }
        function checkWord(beseda){
            var hj = false;
            for (var t =0; t<resitevArray.length; t++ ){
                if (beseda == resitevArray[t]){
                    hj = true
                }
            }
            return hj;
        }
        let answerContainer = document.getElementById('answer');
        answerContainer.innerHTML="";
        resitevArray.forEach(function(a, index){
            let span = document.createElement('span');
            span.classList.add("answerSpan");
            span.classList.add("animation-"+index);
            console.log(index);
            span.id="resitev-"+a;
            span.innerText=a;
            answerContainer.appendChild(span);
        });
        document.getElementById("resitev-"+resitevArray[word]).classList.add("answer-next");
    }
    var crke = ["q","w","e","r","t","z","u","i","o","p","š","đ","ž","a","s","d","f","g","h","j","k","l","č","ć","y","x","c","v","b","n","m"];
    let content = document.querySelector('.keyboard');
    crke.forEach(function(item){
        let button = document.createElement('button');
        button.classList.add("btn-normal");
        button.innerText=item;
        button.value=item;
        button.id=item;
        button.addEventListener('click', function(){
            click(item);
        });
        content.appendChild(button);
        if (item == "ž"){
            let enter = document.createElement('br');
            content.appendChild(enter);
        }
        if (item == "ć"){
            let enterBtn = document.createElement('button');
            enterBtn.classList.add("btn-enter");
            enterBtn.innerText="enter";
            enterBtn.value="enter";
            enterBtn.id="enter";
            enterBtn.addEventListener('click', function(){
                click("enter");
            });
            content.appendChild(enterBtn);
            let enter = document.createElement('br');
            content.appendChild(enter);
        }
    });

    document.addEventListener('keydown', function(event) {
        if (!endGame && play) {
            try {
                numberOfClicks++;
                if (event.keyCode == 13 || event.keyCode == 32) {
                    wordCheck();
                    document.getElementById("enter").classList.add('clicked');
                    setTimeout(function() {
                        document.getElementById("enter").classList.remove('clicked');
                    }, 200);
                } else {

                    if (lastKey) {
                        document.getElementById(lastKey).classList.remove('clicked');
                    }
                    document.getElementById(event.key).classList.add('clicked');
                    setTimeout(function() {
                        document.getElementById(event.key).classList.remove('clicked');
                    }, 200);
                    lastKey = event.key;
                }
            } catch (e) {
                console.log("neznana tipka");
            }
        }
    }, false);

    function click(item){
        if (play && !endGame) {
            if(item == "enter"){
                wordCheck();
                document.getElementById("enter").classList.add('clicked');
                setTimeout(function() {
                    document.getElementById("enter").classList.remove('clicked');
                }, 200);
            }
            var a = guess.value;
            guess.value = a + item;
        }
    }
    var seconds=60;
    function countdown() {
        if (play){

            if(seconds < 60) {
                document.getElementById("clock").innerHTML = "0:"+seconds;
            }
            if (seconds >0 ) {
                seconds--;
            } else {
                gameover();
            }
        }
        else {
            document.getElementById("guess").disabled = true;
        }
    }

    document.getElementById("clock").innerHTML="1:00";

    function wordCheck(){
        console.log(resitevArray);
        guessWord = document.getElementById("guess").value;
        console.log(guessWord);
        if (guessWord == resitevArray[word]){
            document.getElementById("resitev-"+resitevArray[word]).classList.remove("answer-next");
            document.getElementById("resitev-"+resitevArray[word]).classList.add("answer-right");
            pravilnih++;
            up.play();
            document.getElementById('rightAnswers').innerText=pravilnih;
                document.getElementById('rightAnswers').classList.add('bounceIn');

            setTimeout(function() {
                document.getElementById('rightAnswers').classList.remove('bounceIn');
            }, 1000);

        }
        else {
            napacnih++;
            document.getElementById("resitev-"+resitevArray[word]).classList.remove("answer-next");
            document.getElementById("resitev-"+resitevArray[word]).classList.add("answer-wrong");
            bad.play();
            document.getElementById('wrongAnswers').innerText=napacnih;
            document.getElementById('wrongAnswers').classList.add('bounceIn');

            setTimeout(function() {
                document.getElementById('wrongAnswers').classList.remove('bounceIn');
            }, 1000);



        }
        document.getElementById("guess").value = "";
        if (word >= 4){
            word = 0;
            generateWords();
        }
        else {
            word++;
            document.getElementById("resitev-"+resitevArray[word]).classList.add("answer-next");
        }
    }
    function startgame(){
        document.getElementById("guess").value="";
        document.getElementById("redoBtn").style.display = "none";
        document.getElementById("guess").disabled = false;
        document.getElementById("guess").focus();
        document.getElementById("startBtn").disabled = true;
        document.getElementById("stopBtn").disabled = false;
        if (!play){
            play=true;
        }
        if (!stop){
            document.getElementById('wrongAnswers').innerText="";
            document.getElementById('rightAnswers').innerText="";
            generateWords();
        }
    }


    function gameover(){
        endGame= true;
        document.getElementById("redoBtn").style.display = "inline-block";
        document.getElementById("stopBtn").disabled = true;
        document.getElementById("startBtn").disabled = true;
        document.getElementById("guess").disabled = true;
        document.getElementById("numOfClicks").innerText = numberOfClicks;
        document.getElementById("percentage").innerText = Math.round(pravilnih /(pravilnih + napacnih) *100) /10 +" %";
        document.getElementById("numOfRight").innerText = pravilnih;
        document.getElementById("numOfWrong").innerText = napacnih;
        document.getElementById("numOfAll").innerText = pravilnih + napacnih;
        document.getElementById("result").style.display="block";
    }

    function stopGame(){
        document.getElementById("redoBtn").style.display = "none";
        play= false;
        stop = true;
        document.getElementById("startBtn").disabled = false;
        document.getElementById("stopBtn").disabled = true;
    }
    window.setInterval(function() {
        countdown();
    }, 1000);

    function save(){
        var ime = document.getElementById('ime').value;
        var priimek = document.getElementById('priimek').value;
                $.ajax({
                    url: 'save.php',
                    method: 'POST',
                    data: {
                        ime: ime,
                        priimek: priimek,
                        stp:pravilnih,
                        stn: napacnih
                    },
                    success: function (data) {
                     console.log("podatki shranjeni.")
                    }
                });
        location.href = "https://zanlah.si/hitri-prsti";
      /*  console.log(ime);
        console.log(priimek);
        const Https = new XMLHttpRequest();
        const url='https://zanlah.si/hitri-prsti/api.php?ime='+ime +'&priimek='+priimek+'&stp='+pravilnih+'&stn='+napacnih;
        Https.open("GET", url);
        Https.send();
        location.reload();*/
    }
</script>
</html>

