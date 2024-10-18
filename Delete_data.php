<?php
require "./db.php";

class Delete_data{
    function getNumber(){
        global $pdo;
        $getLIsting_id = "SELECT listing_id FROM product";
        $stmt = $pdo->prepare($getLIsting_id);
        $stmt->execute();
        // $result = $stmt->fetchColumn();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // print_r($result);   
        // echo '</pre>';

        $num = array_rand($result, 3);
        foreach ($num as $key) {
            $randomNumbers[] = $result[$key]["listing_id"];
        }
        return $randomNumbers;
    }

    function deleteNum(){
        global $pdo;
        $randomNumbers = $this->getNumber();
        foreach($randomNumbers as $rand){
            echo '<br>';
            echo "Deleted number $rand";
            echo '<br>';

            $delQueryP = "DELETE FROM product WHERE listing_id = $rand";
            $stmt1 = $pdo->prepare($delQueryP);
            echo '<br>';
            if($stmt1->execute()){
                echo "Execute Succesfully product deleted";
            }
            
            $delQueryV = "DELETE FROM variations WHERE variation_id = $rand";
            $stmt = $pdo->prepare($delQueryV);
            echo '<br>';

             if($stmt->execute()){
                echo "Execute Succesfully variations deleted";
             }
            echo '<br>';

        }
    }



        }


// $dis = new Delete_data();
// $dis->deleteNum();

?>