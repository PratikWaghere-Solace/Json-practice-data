<?php

require './db.php';


class Insert_data{
        function insertData(){
        // Configuration
        $dbHost = '127.0.0.1';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'inventory';

        try {
            // Create a PDO instance
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUsername, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Function to generate random title
            function generateRandomTitle() {
                $adjectives = array('New', 'Used', 'Refurbished', 'Vintage');
                $nouns = array('Laptop', 'Phone', 'Tablet', 'Watch');
                $randomAdjective = $adjectives[array_rand($adjectives)];
                $randomNoun = $nouns[array_rand($nouns)];
                return $randomAdjective . ' ' . $randomNoun;
            }

            // Store generated listing IDs
            $listingIds = [];

            // Begin a transaction
            $pdo->beginTransaction();

            // Insert random data into product table
            
            $getdata = "SELECT MAX(listing_id) as list FROM product";
            $stmt = $pdo->prepare($getdata);
            $stmt->execute();
            $lastid = $stmt->fetchColumn(); 

            for ($i = 1; $i <= 5; $i++) {
                $title = generateRandomTitle();
                $productQuery = "INSERT INTO product (listing_id, title) VALUES (:listing_id, :title) 
                                ON DUPLICATE KEY UPDATE title = :title";

                $productStmt = $pdo->prepare($productQuery);

                $listing_id = $i + $lastid;

                // Bind parameters
                $productStmt->bindParam(':listing_id', $listing_id);
                $productStmt->bindParam(':title', $title);

                // Execute the product insert
                if ($productStmt->execute()) {
                    $listingIds[] = $listing_id; // Store the valid listing IDs
                } else {
                    echo "Error inserting data into product: " . $pdo->errorInfo()[2] . "\n";
                }
            }

            // Function to generate random variation data
            function generateRandomVariation() {
                $names = array('Red', 'Blue', 'Green', 'Yellow');
                $skus = array('121', '232', '343', '454');
                $randomName = $names[array_rand($names)];
                $randomSku = $skus[array_rand($skus)];
                return array($randomName, $randomSku);
            }

            // Insert random variation data into table
            $variationsPerProduct = 5; // Number of variations for each product

            foreach ($listingIds as $listingId) {
                for ($j = 0; $j < $variationsPerProduct; $j++) {
                    list($name, $sku) = generateRandomVariation();

                    $variationQuery = "INSERT INTO variations (listing_id, name, sku) VALUES (:listing_id, :name, :sku) 
                                    ON DUPLICATE KEY UPDATE name = :name, sku = :sku";

                    $variationStmt = $pdo->prepare($variationQuery);

                    // Bind parameters for variations
                    $variationStmt->bindParam(':listing_id', $listingId);
                    $variationStmt->bindParam(':name', $name);
                    $variationStmt->bindParam(':sku', $sku);

                    // Execute the variations insert
                    if (!$variationStmt->execute()) {
                        echo "Error inserting data into variations: " . $pdo->errorInfo()[2] . "\n";
                    }
                }
            }

            // Commit the transaction
            $pdo->commit();

            echo "Data inserted successfully!";

        } catch (PDOException $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }

        // Close the connection
        $pdo = null;
        }
}

// $add = new Insert_data();
// $add->insertData();

?>
