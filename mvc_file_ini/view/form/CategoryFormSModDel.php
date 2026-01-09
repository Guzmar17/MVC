<div id="content">
    <form method="post" action="">
        <fieldset>
            <legend>SearchById</legend>
            <label>Id *:</label>
            <input type="text" placeholder="Id" name="id" value="<?php echo (isset($content) && method_exists($content, 'getId')) ? htmlspecialchars($content->getId()) : ''; ?>" />
            <label>Name *:</label>
            <input type="text" placeholder="Name" name="name" value="<?php echo (isset($content) && method_exists($content, 'getName')) ? htmlspecialchars($content->getName()) : ''; ?>" />

            <label>* Required fields</label>
            <input type="submit" name="action" value="add" />
             <input type="submit" name="action" value="modify" />
             <input type="submit" name="action" value="delete" />
            <input type="submit" name="reset" value="reset" onClick="form_reset(this.form.id);" />
        </fieldset>
    </form>
</div>