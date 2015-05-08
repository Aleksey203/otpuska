<?php

/**
 * This is the model class for table "{{orders}}".
 *
 * The followings are the available columns in table '{{orders}}':
 * @property string $id
 * @property integer $user_id
 * @property string $date
 * @property string $start
 * @property string $end
 * @property integer $confirmed
 */
class Orders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, start, end, duration', 'required'),
			array('user_id, confirmed, duration', 'numerical', 'integerOnly'=>true),
			array('date', 'safe'),
			array('start, end', 'date','message'=>'Неверный формат даты.','format'=>'dd.MM.yyyy'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, date, start, end, confirmed, duration', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'сотрудник',
			'date' => 'дата заявки',
			'start' => 'начало отпуска',
			'end' => 'окончание отпуска',
			'duration' => 'длительность отпуска',
			'confirmed' => 'статус заявки',
		);
	}

    protected function beforeValidate() {
        if(parent::beforeValidate()) {
            $this->user_id = Yii::app()->user->id;
            $this->confirmed = 0;
            $start = strtotime($this->start);
            $end = strtotime($this->end);
            $this->duration = ($end-$start)/24/60/60;
            if ($start<time())
                $this->addError('start','Начало не может быть в прошлом');
            if ($end<=$start)
                $this->addError('end','Начало должно быть меньше окончания');

            return true;
        } else {
            return false;
        }
    }


    protected function beforeSave() {
        if(parent::beforeSave()) {

            $this->date = date('Y-m-d H:i:s');
            $this->start = date('Y-m-d', strtotime($this->start));
            $this->end = date('Y-m-d', strtotime($this->end));

            return true;
        } else {
            return false;
        }
    }


    protected function afterFind() {
        $start = date('d.m.Y', strtotime($this->start));
        $this->start = $start;
        $end = date('d.m.Y', strtotime($this->end));
        $this->end = $end;
        $date = date('d.m.Y H:i:s', strtotime($this->date));
        $this->date = $date;
        switch ($this->confirmed) {
            case 0:
                $this->confirmed = "на рассмотрении";
                break;
            case 1:
                $this->confirmed = "одобрена";
                break;
            case -1:
                $this->confirmed = "отклонена";
                break;
        }

        parent::afterFind();
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('confirmed',$this->confirmed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
