<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventos".
 *
 * @property int $evento_codigo
 * @property int $organizacion_codigo
 * @property string $nombre
 * @property int $Estado_codigo
 * @property int $usuario_registro
 * @property int $usuario_modificacion
 * @property string $fecha_modificacion
 * @property string $fecha_registro
 *
 * @property Estados $estadoCodigo
 * @property Organizacion $organizacionCodigo
 * @property IngresoEvento[] $ingresoEventos
 * @property Invitados[] $invitados
 * @property ItemsEvento[] $itemsEventos
 * @property LogAccionesEvento[] $logAccionesEventos
 * @property ProgramacionEvento[] $programacionEventos
 * @property StaffEvento[] $staffEventos
 */


class Eventos extends \yii\db\ActiveRecord
{
    public $cantidad;
    public $estado_item;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eventos';
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
            [['evento_codigo', 'organizacion_codigo', 'nombre', 'Estado_codigo', 'usuario_registro', 'usuario_modificacion', 'fecha_modificacion', 'fecha_registro'], 'required'],
            [['evento_codigo', 'organizacion_codigo', 'Estado_codigo', 'usuario_registro', 'usuario_modificacion'], 'integer'],
            [['fecha_modificacion', 'fecha_registro'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['evento_codigo'], 'unique'],
            /*[['Estado_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['Estado_codigo' => 'estado_codigo']],
            [['organizacion_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Organizacion::className(), 'targetAttribute' => ['organizacion_codigo' => 'organizacion_codigo']],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'evento_codigo' => 'Evento Codigo',
            'organizacion_codigo' => 'Organizacion Codigo',
            'nombre' => 'Nombre',
            'Estado_codigo' => 'Estado Codigo',
            'usuario_registro' => 'Usuario Registro',
            'usuario_modificacion' => 'Usuario Modificacion',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoCodigo()
    {
        return $this->hasOne(Estados::className(), ['estado_codigo' => 'Estado_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizacionCodigo()
    {
        return $this->hasOne(Organizacion::className(), ['organizacion_codigo' => 'organizacion_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngresoEventos()
    {
        return $this->hasMany(IngresoEvento::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitados()
    {
        return $this->hasMany(Invitados::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsEventos()
    {
        return $this->hasMany(ItemsEvento::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogAccionesEventos()
    {
        return $this->hasMany(LogAccionesEvento::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionEventos()
    {
        return $this->hasMany(ProgramacionEvento::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffEventos()
    {
        return $this->hasMany(StaffEvento::className(), ['evento_codigo' => 'evento_codigo']);
    }
    
}
