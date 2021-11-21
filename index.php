<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chinos - dcots</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./img/logo.png">
</head>
<?php session_start(); ?>
<body
<?php
    if($_SESSION['game'] == 'winner'){
        echo 'class="overhidden"';
    }
?>

>
    <!-- start -->
    <?php
        if(isset($_GET['restart']) || !isset($_SESSION['player'])){
            $_SESSION['player'] = 1;
            /* player total coins */
            $_SESSION['p1coins'] = 3;
            $_SESSION['p2coins'] = 3;
            /* player own coins bet */
            $_SESSION['p1ownbet'] = 0;
            $_SESSION['p2ownbet'] = 0;
            /* player bet */
            $_SESSION['p1bet'] = 0;
            $_SESSION['p2bet'] = 0;
            /* game state */
            $_SESSION['game'] = 'menu';
            /* winner */
            $_SESSION['winner'] = 0;

            if(isset($_GET['restart'])){
                header('Location: index.php');
            }
        }

        /* set game state */
        if(isset($_GET['game'])){
            $_SESSION['game'] = $_GET['game'];
            header('Location: index.php');
        }

        if($_SESSION['game'] == 'stats'){
            $totalCoins = $_SESSION['p1ownbet']+$_SESSION['p2ownbet'];
            $winner = 0;
            if($_SESSION['p1bet'] == $totalCoins){
                $winner = 1;


            }else if($_SESSION['p2bet'] == $totalCoins){
                $winner = 2;
            }
        }

        if(isset($_GET['nexRound'])){
            $winner = 0;
            if($_SESSION['p1bet'] == $totalCoins){
                $winner = 1;
                /* player total coins */
                $_SESSION['p1coins'] = $_SESSION['p1coins']+$_SESSION['p2ownbet'];
                $_SESSION['p2coins'] = $_SESSION['p2coins'] - $_SESSION['p2ownbet'];
                /* player own coins bet */
                $_SESSION['p1ownbet'] = 0;
                $_SESSION['p2ownbet'] = 0;
                /* player bet */
                $_SESSION['p1bet'] = 0;
                $_SESSION['p2bet'] = 0;

            }else if($_SESSION['p2bet'] == $totalCoins){
                $winner = 2;
                /* player total coins */
                $_SESSION['p2coins'] = $_SESSION['p2coins']+$_SESSION['p1ownbet'];
                $_SESSION['p1coins'] = $_SESSION['p1coins'] - $_SESSION['p1ownbet'];
                /* player own coins bet */
                $_SESSION['p1ownbet'] = 0;
                $_SESSION['p2ownbet'] = 0;
                /* player bet */
                $_SESSION['p1bet'] = 0;
                $_SESSION['p2bet'] = 0;
            }else{
                /* player own coins bet */
                $_SESSION['p1ownbet'] = 0;
                $_SESSION['p2ownbet'] = 0;
                /* player bet */
                $_SESSION['p1bet'] = 0;
                $_SESSION['p2bet'] = 0;
            }

            if( $_SESSION['p1coins'] == 0 ||  $_SESSION['p2coins'] == 0){
                $_SESSION['game'] = 'winner';
                $_SESSION['winner'] = $winner;
                header('Location: index.php');
            }else{
                $_SESSION['game'] = 'game';
                header('Location: index.php');
            }
        }
        
        if(isset($_GET['coin']) && isset($_GET['bet'])){
            if($_SESSION['player'] == 1){
                $_SESSION['p1ownbet'] = $_GET['coin'];
                $_SESSION['p1bet'] = $_GET['bet'];
                $_SESSION['player'] = 2;
                header('Location: index.php');
            }else{
                $_SESSION['p2ownbet'] = $_GET['coin'];
                $_SESSION['p2bet'] = $_GET['bet'];
                $_SESSION['player'] = 1;
                $_SESSION['game'] = 'stats';
                header('Location: index.php');
            }
        }
    ?>

    <!-- ----- home page ----- -->
    <?php
        if($_SESSION['game'] == 'menu'){ ?>
            <main class="home">
                <img src="./img/info.png" class="info" onclick="info()">
                <h1>CHINOS</h1>
                <button onclick="window.location.href = './index.php?game=game'">JUGAR</button>
            </main>
        <?php }
    ?>
    <!-- ----- gameplay ----- -->
    <?php
        if($_SESSION['game'] == 'game'){ ?>
            <main class="gameplay">
                <div class="turn">
                    <h1>PLAYER <?php echo $_SESSION['player'];?></h1>
                </div>
               <div class="box">
                <h1>CUANTAS MONEADAS DESEA APOSTAR <?php echo $_SESSION['player'];?></h1>
                <div class="userCoins">
                        <?php
                            if($_SESSION['player'] == 1){
                                for($i = 0; $i < $_SESSION['p1coins']; $i++){
                                    echo "<img class='coin coins coin".($i+1)."' onclick='coin1(".($i+1).")' src='./img/coin.png'>";
                                }
                            }else{
                                for($i = 0; $i < $_SESSION['p2coins']; $i++){
                                    echo "<img class='coin coins coin".($i+1)."' onclick='coin2(".($i+1).")' src='./img/coin.png'>";
                                }
                            }              
                        ?>
                    </div>
               </div>
               <div class="box">
                <h1>CUANTAS CREE QUE HABRÁ EN TOTAL ?</h1>
                <div class="userCoins">
                        <?php
                        if($_SESSION['player'] == 1){
                            for($i = 0; $i < 6; $i++){
                                echo "<img class='bet bet".($i+1)."' onclick='bet1(".($i+1).")' src='./img/coin.png'>";
                            }
                        }else{
                            
                            for($i = 0; $i < 6; $i++){
                                if(($_SESSION['p1bet']-1) == $i){
                                    echo "<img class='dissabled' src='./img/coin.png'>";
                                    echo "<span class='display:none; bet".($i+1)."'></span>";
                                }else{
                                    echo "<img class='bet bet".($i+1)."' onclick='bet2(".($i+1).")' src='./img/coin.png'>";
                                }
                            }
                        }     
                        ?>
                    </div>
               </div>
               <?php
                 if($_SESSION['player'] == 1){
                    echo "<button class='next' onclick='siguiente(1)'>SIGUIENTE</button>";
                }else{
                    echo "<button class='next' onclick='siguiente(2)'>SIGUIENTE</button>";
                } 
               ?>
            </main>
        <?php }
    ?>
    <!-- ----- game stats ----- -->
    <?php if($_SESSION['game'] == 'stats'){ ?>
        <main class="gameplay">
            <div class="turn">
                <?php
                    if($winner != 0){
                        echo "<h1>PLAYER ".$winner." WON!</h1>";
                    }else{
                        echo "<h1>EMPATE!</h1>";
                    }
                ?>
            </div>
            <div class="box">
            <h1>MONEDAS TOTALES</h1>
                <div class="usercoins">
                    <?php
                        for($i = 0; $i < $totalCoins; $i++){
                            echo "<img class='goldcoin'  src='./img/coin.png'>";
                        }
                    ?>
                </div>
            </div>
            <div class="box">
            <h1>MONEDAS APOSTADAS POR JUGADOR 1</h1>
                <div class="usercoins">
                    <?php
                        for($i = 0; $i < $_SESSION['p1bet']; $i++){
                            echo "<img class='goldcoin'  src='./img/coin.png'>";
                        }
                    ?>
                </div>
                <h1>PREDICCIÓN JUGADOR 1</h1>
                <div class="usercoins">
                    <?php
                        for($i = 0; $i < $_SESSION['p1ownbet']; $i++){
                            echo "<img class='goldcoin'  src='./img/coin.png'>";
                        }
                    ?>
                </div>
            </div>
            <div class="box">
            <h1>MONEDAS APOSTADAS POR JUGADOR 2</h1>
                <div class="usercoins">
                    <?php
                        for($i = 0; $i < $_SESSION['p2bet']; $i++){
                            echo "<img class='goldcoin'  src='./img/coin.png'>";
                        }
                    ?>
                </div>
                <h1>PREDICCIÓN JUGADOR 2</h1>
                <div class="usercoins">
                    <?php
                        for($i = 0; $i < $_SESSION['p2ownbet']; $i++){
                            echo "<img class='goldcoin'  src='./img/coin.png'>";
                        }
                    ?>
                </div>
            </div>
            <button class='next' onclick='window.location.href = "./index.php?nexRound=true"'>SIGUIENTE</button>
        </main>
    <?php } ?>
    <!-- ----- winner page ----- -->
    <?php
        if($_SESSION['game'] == 'winner'){?>
        <div class="wrapper">
            <div class="modal">
                <span class="emoji round">🏆</span>
                <h1>EL JUGADOR <?php echo $_SESSION['winner'];?> HA GANADO!</h1>
                <a href="./index.php?restart=true" class="modal-btn">VOLVER A JUGAR</a>
            </div>
            <div id="confetti-wrapper">
        </div>

        <?php }
    ?>
    <!-- ----- script ----- -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const p1 = {
            coin: 0,
            bet: 0
        }
        const p2 = {
            coin: 0,
            bet: 0
        }

        const coin1 = (e) => {
            p1.coin = e;
            for(let i = 1; i <= 6; i++){
               try {
                document.querySelector(`.coin${i}`).classList.remove("activecoin")
               } catch (error) {
                   
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.coin${i}`).classList.add("activecoin")
            }
        }
        const coin2 = (e) => {
            p2.coin = e;
            for(let i = 1; i <= 6; i++){
               try {
                document.querySelector(`.coin${i}`).classList.remove("activecoin")
               } catch (error) {
                   
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.coin${i}`).classList.add("activecoin")
            }
        }
        const bet1 = (e) => {
            p1.bet = e;
            for(let i = 1; i <= 6; i++){
               try {
                document.querySelector(`.bet${i}`).classList.remove("activecoin")
               } catch (error) {
                   
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.bet${i}`).classList.add("activecoin")
            }
        }
        const bet2 = (e) => {
            p2.bet = e;
            for(let i = 1; i <= 6; i++){
               try {
                    document.querySelector(`.bet${i}`).classList.remove("activecoin") 
               } catch (error) {
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.bet${i}`).classList.add("activecoin")
            }
        }

        const siguiente =(e) => {
            if(e == 1){
                if(p1.coin != 0 && p1.bet != 0){
                    window.location.href= `index.php?coin=${p1.coin}&bet=${p1.bet}`;
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Selecciona al menos una moneda en cada campo!',
                    })
                }
            }else{
                if(p2.coin != 0 && p2.bet != 0){
                    window.location.href= `index.php?coin=${p2.coin}&bet=${p2.bet}`;
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Selecciona al menos una moneda en cada campo!',
                    })
                }
            }
        }

        <?php
            if($_SESSION['game'] == 'winner'){ ?>
              for(i=0; i<100; i++) {
                // Random rotation
                var randomRotation = Math.floor(Math.random() * 360);
                    // Random Scale
                var randomScale = Math.random() * 1;
                // Random width & height between 0 and viewport
                var randomWidth = Math.floor(Math.random() * Math.max(document.documentElement.clientWidth, window.innerWidth || 0));
                var randomHeight =  Math.floor(Math.random() * Math.max(document.documentElement.clientHeight, window.innerHeight || 500));
                
                // Random animation-delay
                var randomAnimationDelay = Math.floor(Math.random() * 15);
                console.log(randomAnimationDelay);

                // Random colors
                var colors = ['#0CD977', '#FF1C1C', '#FF93DE', '#5767ED', '#FFC61C', '#8497B0']
                var randomColor = colors[Math.floor(Math.random() * colors.length)];

                // Create confetti piece
                var confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.top=randomHeight + 'px';
                confetti.style.right=randomWidth + 'px';
                confetti.style.backgroundColor=randomColor;
                // confetti.style.transform='scale(' + randomScale + ')';
                confetti.style.obacity=randomScale;
                confetti.style.transform='skew(15deg) rotate(' + randomRotation + 'deg)';
                confetti.style.animationDelay=randomAnimationDelay + 's';
                document.getElementById("confetti-wrapper").appendChild(confetti);
                }

                window.onload = frame();
            <?php };
        ?>

        const info = () => {
            Swal.fire(
            'NORMAS',
            'EL JUGADOR UNO ELIGE CUANTAS MONEDAS QUIERE APOSTAR Y CUANTAS CREE QUE HABRÁ EN TOTAL, EL JUGADOR DOS HARÁ LO MISMO. <br><br> EL JUGADOR QUE ADIVINE EL TOTAL DE MONEDAS SE QUEDARA CON LAS MONEDAS QUE HA APOSTADO EL RIVAL, EL JUGADOR QUE SE QUEDE CON 0 MONEDAS PIERDE. <br><br> NO SE PUEDE APOSTAR LO MISMO QUE EL RIVAL.'
            )
        }
    </script>
    <!-- <button class="restart" onclick="window.location.href = './index.php?restart=game'">restart</button> -->
</body>
</html>