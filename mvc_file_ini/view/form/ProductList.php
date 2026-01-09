<div id="content">
    <fieldset>
        <legend>Product list</legend>    
        <?php
            if (isset($content) && !empty($content)) {
                echo <<<EOT
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Category</th>
                        </tr>
EOT;
                // Itera sobre todos los productos
                foreach ($content as $product) {
                    // Obtiene el ID de la categoría (puede ser vacío)
                    $categoryId = $product->getCategory();
                    $categoryName = !empty($categoryId) ? $categoryId : 'N/A';
                    
                    echo <<<EOT
                        <tr>
                            <td>{$product->getId()}</td>
                            <td>{$product->getName()}</td>
                            <td>{$product->getPrice()}</td>
                            <td>{$product->getDescription()}</td>
                            <td>{$categoryName}</td>
                        </tr>
EOT;
                }
                echo <<<EOT
                    </table>
EOT;
            }
        ?>
    </fieldset>
</div>