<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       .first{
        display:none;
       }
       .disp{
        display:block;
       }
        .err{
            color:red;
            
        }
        .valid{
            color:white;
            background-color:green;
          
        }
        
        h1{
          
            text-align:center;
        }
        button{
           display:block;
           margin-top:15px;}

        h3{ 
          margin-left:10px;
          color:red;
          display:inline-block;
        }

        h2{display:inline-block;}

        table{
            border-collapse:collapse;

        }
        td{
            border:1px solid #DDD;
            padding:5px;
            width:200px;
        }
        
        #container{
            width:500px;
            margin:0 auto;
        }
        #MultiNet{
            margin-left:35px;
        }
    </style>
</head>
<body>
    <?php
 
    //var_dump($_POST);
    require "fruits.php";
  
    if(!empty($_POST))
    {
   

        $error=[];
        extract($_POST);
        $paymentMethod=$paymentMethod??'notSet'; 
        // echo $paymentMethod;
        //Regex for text validation according to the value of the radio buttons
        $re= $paymentMethod==0 ? '/^4\d{3}-\d{4}-\d{4}-\d{4}$/':'/^TCKT-[a-zA-Z]{3}-\d{4,6}$/';
      
        if(empty($selectedFruits))
        {
            $error[]='fruit';
        }
        if($paymentMethod==='notSet')
        {
            $error[]='paymentMethod';

        }
        //echo $card;
  
        if(empty($error) && preg_match($re,$card)===0)
        {
            $error['paymentErr']=$paymentMethod==0? 'VISA':'MultiNet';
        }
        //var_dump($error);
        //echo $paymentMethod;


    }
    
    
    
    ?>
     
    <h1 class=<?= !isset($error)? 'first':'disp'?>>  <div class=<?= !empty($error)?'err':'valid'?>> Form <?=  !empty($error)?'Invalid':'Validated'?> </div> </h1>
    <div id="container" >
    <h2>Fruits <h3><?=  isset($error) && in_array('fruit',$error)?'At least one fruit must be selected':''?></h3></h2>

<!-- Sticky web form with validation and sanitization -->
<form action="" method='post'>
    <table>
        <!-- Fruits Table  -->

        <?php
        $i=0;
         foreach($fruits as $fruit) :?>
         
            <?php if($i%3===0) echo "<tr>";  //Displaying table rows with 3 table datas?>
                <td> <input type="checkbox" name='selectedFruits[]' value=<?=$fruit['name']?> <?= isset($selectedFruits) && in_array($fruit['name'],$selectedFruits) ? 'checked':''?> id='<?=$fruit['name']?>' >
                <label for="<?=$fruit['name']?>"><?= $fruit['name']?><?=-$fruit['price']?> &#8378;</label>
                </td>
               
            <?php
            $i++;
             if($i%3===0) echo "</tr>"; ?>



<?php endforeach ?>
    </table>
    <!-- Radio Buttons -->

    <h2>Payment Method <h3><?=  isset($error) && in_array('paymentMethod',$error)?'Payment must be selected':'' //Error message to be displayed ?></h3></h2>
    <br>
 
    <input type="radio" name='paymentMethod' value='0' id='VISA' <?=isset($paymentMethod)&& $paymentMethod!='notSet' && $paymentMethod==0 ? 'checked':''?>><label for="VISA">VISA</label>
    <input type="radio" name='paymentMethod' value='1' id='MultiNet' <?=isset($paymentMethod)&& $paymentMethod==1 ? 'checked':''?>><label for="MultiNet">MultiNet</label>

    <br>
    <br>

    <!-- Textbox Input -->

    <h2>VISA/MultiNet <h3><?=isset($error['paymentErr'])?  $error['paymentErr'] .' format is invalid ': '' ?></h3></h2> 
    <br>
    <input type="text" name='card' value=<?= isset($card) ?filter_var($card,FILTER_SANITIZE_FULL_SPECIAL_CHARS): '' //Sanitization?>>
    <button type='submit'>Pay!!!</button>


    </form>
    </div>
</body>
</html>