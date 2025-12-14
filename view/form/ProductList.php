<div id="content">
    <fieldset>
        <legend>Product List</legend>    
        <?php
            if (isset($content) && is_array($content) && !empty($content)) {
                echo <<<EOT
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Category ID</th>
                        </tr>
EOT;
                
                foreach ($content as $product) {
                    echo <<<EOT
                        <tr>
                            <td>{$product->getId()}</td>
                            <td>{$product->getName()}</td>
                            <td>{$product->getPrice()}</td>
                            <td>{$product->getDescription()}</td>
                            <td>{$product->getCategory()}</td>
                        </tr>
EOT;
                }
                echo <<<EOT
                    </table>
EOT;
            } else {
                echo "No products found.";
            }
        ?>
    </fieldset>
</div>