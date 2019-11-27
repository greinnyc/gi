<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items_evento".
 *
 * @property int $item_evento_codigo
 * @property int $evento_codigo
 * @property int $item_codigo
 * @property int $cantidad
 * @property int $stock
 * @property int $activo
 * @property int $usuario_registro
 * @property int $usuario_modificacion
 * @property string $fecha_registro
 * @property string $fecha_modificacion
 *
 * @property Eventos $eventoCodigo
 * @property ItemsInvitado[] $itemsInvitados
 */
class ItemsEvento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_evento';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_invitado');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_evento_codigo', 'evento_codigo', 'item_codigo', 'cantidad', 'stock', 'activo', 'usuario_registro', 'usuario_modificacion', 'fecha_registro', 'fecha_modificacion'], 'required'],
            [['item_evento_codigo', 'evento_codigo', 'item_codigo', 'cantidad', 'stock', 'activo', 'usuario_registro', 'usuario_modificacion'], 'integer'],
            [['fecha_registro', 'fecha_modificacion'], 'safe'],
            [['item_evento_codigo'], 'unique'],
            [['evento_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Eventos::className(), 'targetAttribute' => ['evento_codigo' => 'evento_codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_evento_codigo' => 'Item Evento Codigo',
            'evento_codigo' => 'Evento Codigo',
            'item_codigo' => 'Item Codigo',
            'cantidad' => 'Cantidad',
            'stock' => 'Stock',
            'activo' => 'Activo',
            'usuario_registro' => 'Usuario Registro',
            'usuario_modificacion' => 'Usuario Modificacion',
            'fecha_registro' => 'Fecha Registro',
            'fecha_modificacion' => 'Fecha Modificacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoCodigo()
    {
        return $this->hasOne(Eventos::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsInvitados()
    {
        return $this->hasMany(ItemsInvitado::className(), ['items_evento_codigo' => 'item_evento_codigo']);
    }

    public function getItemsEvento($id){
            $query = Yii::$app->db_invitado->createCommand("SELECT itev.item_evento_codigo,ic.item_codigo,ic.nombre+'|'+ic.marca+'|'+ic.modelo as nombre,ic.estado,itev.cantidad,itev.stock
            FROM DB_Invitado.dbo.items_evento itev
            left join DB_Invitado.dbo.eventos ev on ev.evento_codigo=itev.evento_codigo
            left join DB_Invitado.dbo.items_catalogo ic on ic.item_codigo = itev.item_codigo  
            where ev.evento_codigo =".$id)->queryAll();
       return $query;
        
    }
}
