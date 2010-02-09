<?php echo CHtml::form($this->controller->createAbsoluteUrl('user/setlang')); ?>
    <div id="langdrop">
        <?php echo CHtml::dropDownList('_lang', $currentLang, array(
            'en_us' => 'English', 'fr' => 'French'), array('submit' => ''));
	?>
    </div>
</form>