<div class="container">
    <div class="row">
        <!-- First main column -->
        <div class="col-sm">
            <div class="row">
                <!-- Nested columns in first main column -->
                <div class="col-sm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" value="<?php echo $character['name']; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="birthYear">Birth Year</label>
                        <input type="number" id="birthYear" class="form-control" value="<?php echo $character['birthYear']; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" class="form-control" value="<?php echo $character['age']; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>
            </div>
        </div>
        <!-- Second main column -->
        <div class="col-sm">
            <div class="row">
                <!-- Nested columns in second main column -->
                <div class="col-sm">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" id="occupation" class="form-control" value="<?php echo $character['occupation']; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="ransom">Ransom</label>
                        <input type="number" id="ransom" class="form-control" value="<?php echo $character['ransom']; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="str">Strength</label>
    <input type="number" id="str" class="form-control" value="<?php echo $character['str']; ?>" <?php echo $readonly; ?>>
</div>
<div class="form-group">
    <label for="dex">Dexterity</label>
    <input type="number" id="dex" class="form-control" value="<?php echo $character['dex']; ?>" <?php echo $readonly; ?>>
</div>
<div class="form-check">
    <input type="checkbox" id="strengthSpell" class="form-check-input" <?php echo $character['strengthSpell'] ? 'checked' : ''; ?> <?php echo $readonly; ?>>
    <label class="form-check-label" for="strengthSpell">Strength Spell</label>
</div>
