<?php

    session_start();
    require_once('helpers.php');
    require_once('dbconn.php');
    require_once('btnclass.php');
    // Return bet_amount
                        $queryBetAmount = "SELECT * FROM bets WHERE bet_user_id = ".$_SESSION['user_user_id']."";
                        $execQueryBetAmount = mysql_query($queryBetAmount);
                        $rowBetAmount = mysql_fetch_array($execQueryBetAmount);

                        // Return user credit
                        $queryCredit = "SELECT * FROM runningcredits WHERE user_id = ".$_SESSION['user_user_id']." ORDER BY date_created DESC LIMIT 1";
                        $execQueryCredit = mysql_query($queryCredit);
                        $rowCredit = mysql_fetch_array($execQueryCredit, MYSQL_ASSOC);
                        $final_credit = round($rowCredit['credits']);
                        if($rowBetAmount == 0 || $rowBetAmount == ""){
                            echo $final_credit." | No Bets yet";
                        }
                        if(!empty($rowBetAmount)){
                            $deducted_credit = $final_credit - $rowBetAmount['bet_amount'];
                            echo "Php ".$final_credit." - (<strong>".$rowBetAmount['bet_amount']."</strong> is my bet amt) = (".$deducted_credit.") remaining credits";
                            echo " | My Odds is: ";
                            $countOdds = mysql_fetch_array($button->check_bets());
                            if($countOdds['bet_odd_id'] != 0){
                                $getOdds1 = mysql_fetch_array($button->check_bets());
                                // Get Odds
                                $getOdds2 = "SELECT * FROM odds WHERE odd_id = ".$getOdds1['bet_odd_id']."";
                                $execOdds2 = mysql_query($getOdds2);
                                $rowOdds2 = mysql_fetch_array($execOdds2);
                                echo $rowOdds2['odd_name'];
                            }
                            else{
                                echo "Nothing Yet";
                            }
                        }

?>
