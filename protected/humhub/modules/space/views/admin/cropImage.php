<?php

use humhub\compat\CActiveForm;
use yii\helpers\Url;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <?php $form = CActiveForm::begin(['id' => 'space-crop-image-form']); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model, 'cropX', ['id' => 'cropX']); ?>
        <?php echo $form->hiddenField($model, 'cropY', ['id' => 'cropY']); ?>
        <?php echo $form->hiddenField($model, 'cropW', ['id' => 'cropW']); ?>
        <?php echo $form->hiddenField($model, 'cropH', ['id' => 'cropH']); ?>

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?php echo Yii::t('SpaceModule.views_admin_cropImage', '<strong>Modify</strong> space image'); ?></h4>
        </div>
        <div class="modal-body">

            <style>
                /* Dirty Workaround against bootstrap and jcrop */
                img {
                    max-width: 100% !important;
                }

                .jcrop-keymgr {
                    display: none !important;
                }

            </style>

            <div id="cropimage">
                <?php
                echo \yii\helpers\Html::img($profileImage->getUrl('_org'), ['id' => 'foobar']);

                echo raoul2000\jcrop\JCropWidget::widget([
                    'selector' => '#foobar',
                    'pluginOptions' => [
                        'aspectRatio' => 1,
                        'minSize' => [50, 50],
                        'setSelect' => [0, 0, 100, 100],
                        'bgColor' => 'black',
                        'bgOpacity' => '0.5',
                        'onChange' => new yii\web\JsExpression('function(c){ $("#cropX").val(c.x);$("#cropY").val(c.y);$("#cropW").val(c.w);$("#cropH").val(c.h); }')
                    ]
                ]);
                ?>
            </div>


        </div>
        <div class="modal-footer">

            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                    'url' => $space->createUrl('/space/admin/crop-image'),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
            ?>

            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?php echo Yii::t('SpaceModule.views_admin_cropImage', 'Close'); ?></button>

            <div id="crop-loader" class="loader loader-modal hidden">
                <div class="sk-spinner sk-spinner-three-bounce">
                    <div class="sk-bounce1"></div>
                    <div class="sk-bounce2"></div>
                    <div class="sk-bounce3"></div>
                </div>
            </div>
        </div>

        <?php echo \humhub\widgets\DataSaved::widget(); ?>
        <?php CActiveForm::end(); ?>
    </div>

</div>









