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
<body>
    <!-- start -->
    <?php
        session_start();
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
        
            echo $totalCoins;
        }
        
        if(isset($_GET['coin']) && isset($_GET['beat'])){
            if($_SESSION['player'] == 1){
                $_SESSION['p1ownbet'] = $_GET['coin'];
                $_SESSION['p1bet'] = $_GET['beat'];
                $_SESSION['player'] = 2;
                header('Location: index.php');
            }else{
                $_SESSION['p2ownbet'] = $_GET['coin'];
                $_SESSION['p2bet'] = $_GET['beat'];
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
                <img src="./img/info.png" class="info">
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
                                echo "<img class='beat beat".($i+1)."' onclick='beat1(".($i+1).")' src='./img/coin.png'>";
                            }
                        }else{
                            for($i = 0; $i < 6; $i++){
                                echo "<img class='beat beat".($i+1)."' onclick='beat2(".($i+1).")' src='./img/coin.png'>";
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
        <main class="stats">
            <br>
            <br>
            <?php
                echo $_SESSION['p1ownbet'];
                echo $_SESSION['p2ownbet'];
                /* player bet */
                echo $_SESSION['p1bet'];
                echo $_SESSION['p2bet'];
            ?>
        </main>
    <?php } ?>
    <!-- ----- winner page ----- -->
    <!-- ----- script ----- -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const p1 = {
            coin: 0,
            beat: 0
        }
        const p2 = {
            coin: 0,
            beat: 0
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
        const beat1 = (e) => {
            p1.beat = e;
            for(let i = 1; i <= 6; i++){
               try {
                document.querySelector(`.beat${i}`).classList.remove("activecoin")
               } catch (error) {
                   
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.beat${i}`).classList.add("activecoin")
            }
        }
        const beat2 = (e) => {
            p2.beat = e;
            for(let i = 1; i <= 6; i++){
               try {
                document.querySelector(`.beat${i}`).classList.remove("activecoin")
               } catch (error) {
                   
               }
            }
            for(let i = 1; i <= e; i++){
                document.querySelector(`.beat${i}`).classList.add("activecoin")
            }
        }

        const siguiente =(e) => {
            if(e == 1){
                if(p1.coin != 0 && p1.beat != 0){
                    window.location.href= `index.php?coin=${p1.coin}&beat=${p1.beat}`;
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Selecciona al menos una moneda en cada campo!',
                    })
                }
            }else{
                if(p2.coin != 0 && p2.beat != 0){
                    window.location.href= `index.php?coin=${p2.coin}&beat=${p2.beat}`;
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'ERROR',
                    text: 'Selecciona al menos una moneda en cada campo!',
                    })
                }
            }
        }
    </script>
    <button class="restart" onclick="window.location.href = './index.php?restart=game'">restart</button>
</body>
</html>