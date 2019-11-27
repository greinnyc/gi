<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\TimePicker;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\bootstrap\Modal;



//$this->registerJsFile('@web/js/eventoScript.js', ['depends' => [yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $model app\models\Eventos */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$js = <<<JS
    cargarDatatable();
JS;

$this->registerJs($js);

?>
<?= Html::input('hidden','table_items_data','', $options=['class'=>'form-control', 'id'=>'table_items_data']) ?>
<?= Html::input('hidden','item_url','', $options=['class'=>'form-control item_url', 'id'=>Url::to(['items-evento/get-items-evento','evento' => $model->evento_codigo])]) ?>


<div class="eventos-form">

    <?php $form = ActiveForm::begin(['id'=>'eventos']); ?>

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datos">Datos y Programación</a></li>
            <li><a data-toggle="tab" href="#programacion">Programación</a></li>
            <li><a data-toggle="tab" href="#invitados">Invitados</a></li>
            <li><a data-toggle="tab" href="#staff">Staff</a></li>

        </ul>

        <div class="tab-content">
            <div id="datos" class="tab-pane fade in active">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre') ?>
                    </div>

                    <div class="col-12 col-md-6">
                         <?=
                            $form->field($model, 'Estado_codigo')->widget(SwitchInput::classname([
                                'name' => 'Estado_codigo',
                                'pluginOptions' => [
                                    'onText' => 'Si',
                                    'offText' => 'No',
                                ]
                            ]))->label('Estado');
                           
                        ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Sede</label>
                        <?= Select2::widget([   
                                                'name'=>'sede',
                                                'data' => ArrayHelper::map($model_sedes->getSedes(), "Codigo","Descripcion"),
                                                'language' => 'es',
                                                'options' =>[  
                                                                'placeholder' => 'Seleccione ',
                                                                'id'=>'sede'
                                                            ],
                                                'pluginOptions' =>  [
                                                                        'allowClear' => true,
                                                                    ]
                        ]) ?>

                    </div>
                    <div class="col-12 col-md-6">
                        <label>Ubicación</label>
                        <?=
                           DepDrop::widget([
                                             'name'=>'ubicacion_sede',
                                             'options' => ['id'=>'ubicacion_sedes'],
                                             'type' => DepDrop::TYPE_SELECT2,
                                             'pluginOptions'=>[
                                                 'depends'=>['sede'],
                                                 'placeholder' => 'Select...',
                                                 'url' => Url::to(['sede-ubicacion/get-ubicacion'])
                                             ]
                                        ]);
                        ?>
                    </div>
                
                    <div class="col-12" style="text-align:center;margin-top:20px">
                        <label>ÍTEMS DEL EVENTO</label>
                        <hr  size="2" width="100%" style='margin-top:0px; margin-bottom: 20px;border: 0;border-top: 1px solid #172d44;'>
                    </div>
                    <div class="col-12">
                        <table id="table_items" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                        <br>
                    </div>
                    <div class="col-12 col-md-4">

                        <label>Item</label>
                        <?= Select2::widget([   
                                                'name'=>'item_codigo',
                                                'data' => ArrayHelper::map($model_itemsCatalogo->getItems(), "Codigo","Descripcion"),
                                                'language' => 'es',
                                                'options' =>[  
                                                                'placeholder' => 'Seleccione ',
                                                                'id'=>'item_codigo'
                                                            ],
                                                'pluginOptions' =>  [
                                                                        'allowClear' => true,
                                                                    ]
                            ]) 
                        ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <?= $form->field($model, 'cantidad')->textInput() ?>
                    </div>

                    <div class="col-12 col-md-2">
                        <?=
                            $form->field($model, 'estado_item')->widget(SwitchInput::classname([
                                'name' => 'estado_item',
                                'pluginOptions' => [
                                    'onText' => 'Si',
                                    'offText' => 'No',
                                ]
                            ]))->label('Estado');
                           
                        ?>
                    </div>

                    <div class="col-12 col-md-2">
                        <br>
                        <?= Html::button('Agregar', array('onclick' => 'js:agregarItems()','class' => 'btn btn-primary'));?>
                    </div>
                   
                </div>
            </div>
            <div id="programacion" class="tab-pane fade">
                <div class="row justify-content-center">

                    <div class="col-12 col-md-3">
                        <label>Fecha Inicial</label>
                        <?php
                            echo DatePicker::widget([
                                        'name'=>'dateini',
                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                        'removeButton' => false,
                                        'pluginOptions' => [
                                        'autoclose'=>true,
                                        'todayBtn' => true,
                                        'format' => 'dd/mm/yyyy',
                                        ],
                                        'options'=>['autocomplete'=>'off']

                                    ]);
                        ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <label>Hora Inicio</label>
                        <?php

                            echo TimePicker::widget([
                                'name' => 'timeini',
                                'addon'=>'<i class="far fa-clock"></i>',
                                'addonOptions' => [
                                    'asButton' => true,
                                ]
                            ]);
                        ?>                
                    </div>
                    <div class="col-12 col-md-3">
                        <label>Fecha Final</label>
                        <?php
                            echo DatePicker::widget([
                                        'name'=>'dateini',
                                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                        'removeButton' => false,
                                        'pluginOptions' => [
                                        'autoclose'=>true,
                                        'todayBtn' => true,
                                        'format' => 'dd/mm/yyyy',
                                        ],
                                        'options'=>['autocomplete'=>'off']

                                    ]);
                        ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <label>Hora Final</label>
                        <?php
                            echo TimePicker::widget([
                                'name' => 'timeini',
                                'bsVersion'=>'3.x',
                                'addon'=>'<i class="far fa-clock"></i>',
                                'addonOptions' => [
                                    'asButton' => true,
                                ]
                            ]);
                        ?>
                    </div>
                </div>
            </div>
            <div id="invitados" class="tab-pane fade">
              Staff
            </div>
            <div id="staff" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Some content in menu 2.</p>
            </div>
        </div>        
    </div>


               
<!--
    <?= $form->field($model, 'evento_codigo')->textInput() ?>

    <?= $form->field($model, 'organizacion_codigo')->textInput() ?>

    <?= $form->field($model, 'Estado_codigo')->textInput() ?>
   
    <?= $form->field($model, 'usuario_registro')->textInput() ?>

    <?= $form->field($model, 'usuario_modificacion')->textInput() ?>

    <?= $form->field($model, 'fecha_modificacion')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>
-->
    <br>
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

