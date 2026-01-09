<div id="content">
    <form method="post" action="" id="ProductFormSModDel">
        <fieldset>
            <legend>Search / Modify / Delete Product</legend>
            
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php echo (isset($content) && method_exists($content, 'getId')) ? htmlspecialchars($content->getId()) : ''; ?>" />
            <input type="submit" name="action" value="search" />

            <hr/> <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" value="<?php echo (isset($content) && method_exists($content, 'getName')) ? htmlspecialchars($content->getName()) : ''; ?>" />

            <label>Price *:</label>
            <input type="text" placeholder="Price" name="price" value="<?php echo (isset($content) && method_exists($content, 'getPrice')) ? htmlspecialchars($content->getPrice()) : ''; ?>" />

            <label>Description (Optional):</label>
            <input type="text" placeholder="Description" name="description" value="<?php echo (isset($content) && method_exists($content, 'getDescription')) ? htmlspecialchars($content->getDescription()) : ''; ?>" />

            <label>Category (Optional):</label>
            <select name="category">
                <option value="">-- Select Category --</option>
                <?php   
                    $currentCatId = (isset($content) && method_exists($content, 'getCategory')) ? $content->getCategory() : null;
                ?>
                <option value="1" <?php if($currentCatId == 1) echo 'selected'; ?>>Cosmetic</option>
                <option value="2" <?php if($currentCatId == 2) echo 'selected'; ?>>Health</option>
            </select>
            
            <br/>

            <label>* Required fields</label>
            <br/>
            <input type="submit" name="action" value="modify" />
            <input type="submit" name="action" value="delete" />
            <input type="reset" name="reset" value="reset" onClick="form_reset(this.form.id);" />
        </fieldset>
    </form>
</div>