<form method="POST">
    <div class="form-group">
        <select name="school_id" class="form-control" required>
            <option value="">Select School</option>
            <option value="all">All Schools</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>"><?php echo htmlspecialchars($school['school_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group as-check">
        <?php foreach ($sel_themes as $theme): ?>
   
          <div class="form-check ">
                <input class="form-check-input" type="checkbox" name="theme_ids[]" value="<?php echo $theme['id']; ?>" id="theme_<?php echo $theme['id']; ?>">
                <label class="form-check-label" for="theme_<?php echo $theme['id']; ?>">
                    <?php echo htmlspecialchars($theme['theme_name']); ?>
                    
                </label>
          </div>
        <?php endforeach; ?>
    </div>
    <div class="btn-flex">
    <button type="submit" name="assign_themes" class="btn btn-primary">Assign Themes</button>
    <button type="submit" name="delete_themes" class="btn btn-danger">Delete Selected Themes</button>
</div>
</form>