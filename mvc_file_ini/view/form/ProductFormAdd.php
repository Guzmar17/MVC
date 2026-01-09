<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>Add product</legend>
            
            <!-- Campo ID -->
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php if (isset($content)) { echo $content->getId(); } ?>" />
            
            <!-- Campo Name -->
            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" value="<?php if (isset($content)) { echo $content->getName(); } ?>" />
            
            <!-- Campo Price -->
            <label>Price *:</label>
            <input type="text" placeholder="Price (e.g., 10.50)" name="price" value="<?php if (isset($content)) { echo $content->getPrice(); } ?>" />
            
            <!-- Campo Description (textarea) -->
            <label>Description:</label>
            <textarea name="description" rows="4" cols="50" placeholder="Product description (optional)"><?php if (isset($content)) { echo $content->getDescription(); } ?></textarea>
            
            <!-- Campo Category (select) -->
            <label>Category:</label>
            <select name="category">
                <option value="">-- Select a category --</option>
             <?php
                    // DEBUG - Eliminar después de verificar
                    if (!isset($categories)) {
                        echo "<option value=''>ERROR: Categories variable not set</option>";
                    } else if (empty($categories)) {
                        echo "<option value=''>No categories found</option>";
                    } else {
                        // Muestra todas las categorías disponibles
                        foreach ($categories as $category) {
                            $selected = "";
                            // Si hay un producto cargado, marca su categoría como seleccionada
                            if (isset($content) && $content->getCategory() == $category->getId()) {
                                $selected = "selected";
                            }
                            echo "<option value='" . htmlspecialchars($category->getId()) . "' {$selected}>" . htmlspecialchars($category->getName()) . "</option>";
                        }
                    }
                ?>
            </select>

            <label>* Required fields</label>
            
            <!-- Botones de acción -->
            <input type="submit" name="action" value="add" />
            <input type="reset" value="reset" />
        </fieldset>
    </form>
</div>