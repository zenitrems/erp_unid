<?php
if (isset($_POST["from_date"])) {
     require_once "cron/database.php";
     $output = '';
     $query = "  
           SELECT * FROM multimoneda  
           WHERE insertDate = '" . $_POST["from_date"] . "'
      ";
     $result = mysqli_query($mysqli, $query);
     $output .= '  
           <table class="table table-bordered">  
                <tr>  
                     <th>Cambio</th>  
                     <th>Actualizado</th>    
                </tr>  
      ';
     if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_array($result)) {
               $output .= '  
                     <tr>  
                          <td>' . $row["source"] . "=>" . $row["target"] . '=' . $row["value"] ."$" . '</td>                      
                          <td> ' . $row["updated"] . '</td>                          
                     </tr>  
                ';
          }
     } else {
          $output .= '  
                <tr>  
                     <td colspan="5">Sin datos</td>  
                </tr>  
           ';
     }
     $output .= '</table>';
     echo $output;
}
