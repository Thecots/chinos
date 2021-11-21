<?php
    /* global  */
    $p = 1;
    $p1 = 3;
    $p2 = 3;
    $p1a = 0;
    $p2a = 0;
    $p1p = 0;
    $p2p = 0;
    $turnos = 0;

    /* main function */
    function main(&$p, &$p1, &$p2, &$p1a, &$p2a, &$p1p, &$p2p, &$turnos){
        $turnos++;

        /* turn player 1 */
        system('clear');
        turn1($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p);
        
        
        system('clear');
        echo "\e[0;30;45mEnter para turno de jugador numero 2\e[0m\n";
        readline('');
        
        /* turn player 2 */
        system('clear');
        turn2($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p);

        /* print board */
        printBoard($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p);

        /* loop */
        if(!winner($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p,$turnos)){ main($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p, $turnos); };
    }

    /* turn 1*/
    function turn1(&$p, &$p1, &$p2, &$p1a, &$p2a, &$p1p, &$p2p){
        $i = true;
        while($i){
            system('clear');
            echo "\e[0;30;45m(Tienes $p1 monedas)                          \e[0m\n";
            echo "\e[0;34;45m PLAYER 1 - \e[0m\e[0;30;45mCuantas monedas quiere apostar? \e[0m\n";
            $p1a = readline("");
            if(is_numeric($p1a)){
                if($p1a > $p1){
                    system('clear');
                    echo "\e[0;30;45mNo tienes tantas monedas, pulsa [enter] para volver a introducir un valor\e[0m\n";
                    readline("");
                }else{
                    $i = false;
                }
            }else{
                system('clear');
                echo "\e[0;30;45mCaracter invalido, ingresa un número\e[0m\n";
                readline("");
            }
        }
        $i = true;
        while($i){
            system('clear');
            echo "\e[0;30;45m(Has apostado $p1a monedas)                             \e[0m\n";
            echo "\e[0;34;45m PLAYER 1 - \e[0m\e[0;30;45mCuantas monedas cree que habrá en total? \e[0m\n";
            $p1p = readline("");
            if(is_numeric($p1p)){
                $i = false;
            }else{
                system('clear');
                echo "\e[0;30;45mCaracter invalido, ingresa un número\e[0m\n";
                readline("");
            }
        }
    }

     /* turn 2*/
     function turn2(&$p, &$p1, &$p2, &$p1a, &$p2a, &$p1p, &$p2p){
        $i = true;
        while($i){
            system('clear');
            echo "\e[0;30;45m(Tienes $p2 monedas)                          \e[0m\n";
            echo "\e[1;37;45m PLAYER 2 - \e[0m\e[0;30;45mCuantas monedas quiere apostar? \e[0m\n";
            $p2a = readline("");
            if(is_numeric($p2a)){
                if($p2a > $p2){
                    system('clear');
                    echo "\e[0;30;45mNo tienes tantas monedas, pulsa [enter] para volver a introducir un valor\e[0m\n";
                    readline("");
                }else{
                    $i = false;
                }
            }else{
                system('clear');
                echo "\e[0;30;45mCaracter invalido, ingresa un número\e[0m\n";
                readline("");
            }
        }
        $i = true;
        while($i){
            system('clear');
            echo "\e[0;30;45m(Has apostado $p2a monedas)                             \e[0m\n";
            echo "\e[1;37;45m PLAYER 2 - \e[0m\e[0;30;45mCuantas monedas cree que habrá en total? \e[0m\n";
            $p2p = readline("");
            
            if(is_numeric($p2p)){
                if($p2p == $p1p){
                    system('clear');
                    echo "\e[0;30;45mNo puedes predecir lo mismo que el jugador 1\e[0m\n";
                    readline("");
                }else{
                    $i = false;
                }   
            }else{
                system('clear');
                echo "\e[0;30;45mCaracter invalido, ingresa un número\e[0m\n";
                readline("");
            }
        }
    }

    /* Print board */
    function printBoard(&$p, &$p1, &$p2, &$p1a, &$p2a, &$p1p, &$p2p){
        system('clear');
        $total = $p1a+$p2a;
        echo "\e[0;30;45m APUESTAS:           \e[0m\n";
        echo "\e[0;30;45m Jugador 1 => $p1a      \e[0m\n";
        echo "\e[0;30;45m Jugador 2 => $p2a      \e[0m\n";
        echo "\e[0;30;45m Total: $total            \e[0m\n";
        echo "\e[0;30;45m                     \e[0m\n";
        echo "\e[0;30;45m PREDICCIONES        \e[0m\n";
        echo "\e[0;30;45m Jugador 1 => $p1p      \e[0m\n";
        echo "\e[0;30;45m Jugador 2 => $p2p      \e[0m\n";
        echo "\e[0;30;45m                     \e[0m\n";

    }

    /* Check if there are any winner*/
    function winner(&$p, &$p1, &$p2, &$p1a, &$p2a, &$p1p, &$p2p, &$turnos){
        $total = $p1a+$p2a;
        echo "\e[0;30;45m                                                       \e[0m\n";
        /* Check if player 1 win */
        if($p1p == $total){
            $p1 = $p1+$p2a;
            $p2 = $p2-$p2a;
            echo "\e[0;30;45mPlayer 1 win         \e[0m\n";
        }

        /* Check if player 2 win */
        if($p2p == $total){
            $p2 = $p2+$p1a;
            $p1 = $p1-$p1a;
            echo "\e[0;30;45mPlayer 2 win         \e[0m\n";
        }

        if($p2p != $total && $p1p != $total){
            echo "\e[0;30;45mNingún jugador ha hacertado el número total de monedas \e[0m\n";
        }

        if($p1 == 0 || $p2 == 0){
            system('clear');
            if($p2 == 0){
                echo "\n\e[0;30;45m  _____ _____ _____ _____ ____  _____ _____    ___    \e[0m";
                echo "\n\e[0;30;45m |   __|  _  |   | |  _  |    \|     | __  |  |_  |   \e[0m";
                echo "\n\e[0;30;45m |  |  |     | | | |     |  |  |  |  |    -|   _| |_  \e[0m";
                echo "\n\e[0;30;45m |_____|__|__|_|___|__|__|____/|_____|__|__|  |_____| \e[0m";
                echo "\n\e[0;30;45m                                                      \e[0m";
            }else{
                echo "\n\e[0;30;45m  _____ _____ _____ _____ ____  _____ _____    ___  \e[0m";
                echo "\n\e[0;30;45m |   __|  _  |   | |  _  |    \|     | __  |  |_  | \e[0m";
                echo "\n\e[0;30;45m |  |  |     | | | |     |  |  |  |  |    -|  |  _| \e[0m";
                echo "\n\e[0;30;45m |_____|__|__|_|___|__|__|____/|_____|__|__|  |___| \e[0m";
                echo "\n\e[0;30;45m                                                    \e[0m";
            }
            echo "\n\e[0;30;45m Turnos totales: $turnos                                    \e[0m";
            echo "\n\e[0;30;45m                                                      \e[0m\n";
            return true;
        }else{
            echo "\e[0;30;45m                                                       \e[0m\n";
            echo "\e[0;30;45mPulsa [enter] para continuar \e[0m\n";
            readline("");
            return false;
        }
    }


    /* start the game */
    main($p, $p1, $p2, $p1a, $p2a, $p1p, $p2p, $turnos);
?>