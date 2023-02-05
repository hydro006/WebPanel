<?php




    if(isset($_POST['GraczeServ'])){




            $last_2 = count($products["Players"]);

            $json_data_2 = file_get_contents("dane.json");
            $products_2 = json_decode($json_data_2,true);


            $products_2["Players"][$last_2] = $_POST['GraczeServ'];

            $json_2 = json_encode($products_2);


            file_put_contents("dane.json", $json_2);
        

            

    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">



    </script>
    <title>WebPanel</title>
</head>
<body>
    

    <div class="container">
    
        <h3 id="tekst">Panel Administracyjny</h3>

       <div class="grid">

            <div class="lista-graczy">

                
                <h3>Lista Graczy</h3>


                <table>
                    <thead>
                       <tr>



                          <th>Nazwa Gracza</th>
                          <th>Powód</th>
                          <th>Akcje</th>
                          
                       </tr>
                    </thead>
                    <tbody id="data-output">

                    <?php
                       
                                     
                       $json_data = file_get_contents("dane.json");
                       $products = json_decode($json_data,true);


                       
                       if(count($products) != 0){

                          
                           for($i = 0; $i < count($products['Players']); $i++){
                               
                          

                    ?>

                        <tr>
                            <form action="index.php?username=<?php echo $products['Players'][$i];?>" method="POST">
                                <td><?php echo $products['Players'][$i]; ?></td>
                                <td><input type="text" name="PowodInput-<?php echo $products['Players'][$i];?>" placeholder="Podaj Powód Bana" required/></td>
                                <td><input type="submit" name="PrzyciskBan" value="Zbanuj"/></td>
                            </form>
                        </tr>

                    <?php
                           }
                       }

                       if(isset($_POST['PrzyciskBan'])){
                        


                            $last = count($products["Bans"]);

                            $nazwa_gracza = $_GET['username'];
                            $powod_bana = $_POST['PowodInput-'.$_GET['username']];

                            $key = array_search($nazwa_gracza, $products['Players']);
                            

                            

                            $products["Bans"][$last]['nick'] = $nazwa_gracza;
                            $products["Bans"][$last]['reason'] = $powod_bana;

                            
                            $key = array_search($nazwa_gracza, $products['Players']);
                            


                            array_splice($products['Players'], $key, 1);
                            
                            $json = json_encode($products);


                            file_put_contents("dane.json", $json);
    
    
                            echo "<script> window.location.href='index.php';</script>";


                           
                            
                       }


                    ?>
                       
                    </tbody>
                 </table>





            </div>

            <div class="lista-graczy-banned">

                <h3>Lista Graczy Zbanowanych</h3>


                <table>
                    <thead>
                       <tr>
                          <th>Nazwa Gracza</th>
                          <th>Powód</th>

                       </tr>
                    </thead>
                    <tbody id="data-output">


                        <?php
                                
                                $json_data = file_get_contents("dane.json");
                                $products = json_decode($json_data,true);


                                
                                if(count($products) != 0){
  
                                   
                                    for($i = 0; $i < count($products['Bans']); $i++){
                                        
                                   

                                        ?>

                                            <tr>
                                                
                                                <td><?php echo $products['Bans'][$i]['nick'] ?></td>
                                                <td><?php echo $products['Bans'][$i]['reason'] ?></td>
                                                
                                            </tr>

                                        <?php
                                    }
                                }
                            
                        ?>


                       
                    </tbody>
                 </table>
            </div>
            
       </div>

    </div>

   
</body>
</html>
