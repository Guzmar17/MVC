<div id="content">
    <form method="post" action="" id="ProductFormAdd">
        <fieldset>
            <legend>Add Product</legend>
            
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php if (isset($content)) { echo htmlspecialchars($content->getId()); } ?>" />

            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" value="<?php if (isset($content)) { echo htmlspecialchars($content->getName()); } ?>" />

            <label>Price *:</label>
            <input type="text" placeholder="Price (e.g., 1.25)" name="price" value="<?php if (isset($content)) { echo htmlspecialchars($content->getPrice()); } ?>" />

            <label>Description (Optional):</label>
            <input type="text" placeholder="treatment, product, face" name="description" value="<?php if (isset($content)) { echo htmlspecialchars($content->getDescription()); } ?>" />

            <label>Category (Optional):</label>
            <select name="category">
                <option value="">-- Select Category --</option>
                <option value="1" <?php if(isset($content) && $content->getCategory() == 1) echo 'selected'; ?>>Cosmetic</option>
                <option value="2" <?php if(isset($content) && $content->getCategory() == 2) echo 'selected'; ?>>Health</option>
            </select>

            <label>* Required fields</label>
            <input type="submit" name="action" value="add" />
            <input type="reset" name="reset" value="reset" onClick="form_reset(this.form.id);" />
        </fieldset>
    </form>
</div>