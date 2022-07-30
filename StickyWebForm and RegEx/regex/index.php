<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regular Expression</title>
    <style> 
         b { color: blue; } 
         span { font-weight: bold; color: red;}     
    </style>
</head>
<body>
    <?php
    var_dump($_POST);
        if ( !empty($_POST)) {
            extract($_POST) ; 
            $error = [] ;

            // Bilkent ID : is a number with 8 digits, and the first one is 2.
            $re = '/^2\d{7}$/' ;
            if ( preg_match($re, $bilkent) === 0) {
                $error[] = "bilkent" ; 
            }  

            // RGB Color Code : rgb(d, d, d)
            $color = preg_replace('/\s+/', '', $color) ;
            $re = '/^rgb\(\d{1,3},\d{1,3},\d{1,3}\)$/i' ; 
            if ( preg_match($re, $color) === 0) {
                $error[] = "color" ; 
            } 

            // Time  00:00 -> 23:59 
            $re = '/^([01]\d|2[0-3]):[0-5]\d$/';
            if ( preg_match($re, $time) === 0) {
                $error[] = "time" ; 
            } 

            // Parse email addresses in free text.
            $re = '/(\w+)@((?:\w+\.){1,3}(?:com|tr))/iu' ;
            preg_match_all($re, $email, $result) ;


        }
    ?>
    <h1>RegEx Samples</h1>
    <form action="" method="post">
      <table>
          <tr>
              <td>Bilkent ID:</td>
              <td>
                  <input type="text" name="bilkent"
                   value="<?= $bilkent ?? '' ?>" 
                  >
              </td>
              <td>
                  <?php
                    if ( isset($error)) {
                        echo in_array("bilkent", $error) ? "INVALID" : "VALID" ;
                    }
                  ?>
              </td>
          </tr>
        
          <tr>
              <td>RGB Color Code:</td>
              <td>
                  <input type="text" name="color"
                   value="<?= $color ?? '' ?>" 
                  >
              </td>
              <td>
                  <?php
                    if ( isset($error)) {
                        echo in_array("color", $error) ? "INVALID" : "VALID" ;
                    }
                  ?>
              </td>
          </tr>
          <tr>
              <td>Time:</td>
              <td>
                  <input type="text" name="time"
                   value="<?= $time ?? '' ?>" 
                  >
              </td>
              <td>
                  <?php
                    if ( isset($error)) {
                        echo in_array("time", $error) ? "INVALID" : "VALID" ;
                    }
                  ?>
              </td>
          </tr>

          <tr>
            <td>Parse Emails:</td>
            <td>
                <textarea name="email" id="email" cols="30" rows="5"><?= $email ?? '' ?></textarea>
                </div>
            </td>
            <td>
                It parses email addresses such as admin@ctis.bilkent.edu.tr and ali@hotmail.com and others. Copy and paste this line.
            </td>
      </tr>
          <tr>
            <td>Mark Times:</td>
            <td>
                <textarea name="mark" id="mark" cols="30" rows="5"><?= $mark ?? '' ?></textarea>
                </div>
            </td>
            <td>
                Example: Midterm will start at 13:45 and finish at 16:00. Copy this line into textarea
            </td>
      </tr>
          <tr>
              <td colspan="3">
                  <input type="submit" value="Validate">
              </td>
          </tr>
      </table>
      <p>
      <?php
          if ( !empty($result[0])) {
            echo "<h3>Parsed Emails : </h3>" ;
            echo "<p><span>Emails (full) : </span>" , join(" , ", $result[0]), "</p>" ;
            echo "<p><span>Emails (user) : </span>" , join(" , ", $result[1]), "</p>" ;
            echo "<p><span>Emails (domain) : </span> " , join(" , ", $result[2]), "</p>" ;
          }

          if (!empty($mark)) {
            $res = preg_replace('/(([01]\d|2[0-3]):[0-5]\d)/', '<b>\1</b>', $mark ) ;
            echo "<h3>Marked Time Data : </h3>" ;
            echo "<p>$res</p>" ;
          }
      ?>
    </p>

    </form>
</body>
</html>