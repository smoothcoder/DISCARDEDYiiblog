<?php
<?= CHtml::form() ?>
    <div id="langdrop">
        <?= CHtml::dropDownList('_lang', $currentLang, array(
            'en_us' => 'English', 'fr' => 'French'), array('submit' => '')) ?>
    </div>
</form>