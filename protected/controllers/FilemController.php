<?php

include('FileController.php');
class FilemController extends FileController
{
    const PAGE_SIZE=50;
    public $layout='filem';


public function actionCreate()
    {
	$model=new File;

		if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];

			$model->_instancefile=CUploadedFile::getInstance($model,'name');
			$model->size	=$model->_instancefile->size;
			$model->name	=$model->_instancefile->name;
			$model->type	=$model->_instancefile->type;
			$model->createTime=time();

			if( ($model->size>0) && $model->validate())
			{
				$storage_filename=Yii::app()->params['filePath'].$model->name;

				$type=explode('/',$model->type);
				if($type[0]=='image')
				{
					list($width, $height, $type, $attr)=@getimagesize($model->_instancefile->tempName);
					$model->widthxheight=$width.'x'.$height;
				}
			}

			if($model->save())
			{
				$model->_instancefile->saveAs($storage_filename);
				//TODO test the current controller to find redirect to files/admin or filem/admin and avoid duplicate code
				$this->redirect(array('filem/admin'));
			}

		}

		$this->pageTitle=Yii::t('lan','New File');
		$this->render('create',array('model'=>$model));


	}

}
