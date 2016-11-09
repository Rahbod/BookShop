<?php

/**
 * This is the model class for table "ym_book_buys".
 *
 * The followings are the available columns in table 'ym_book_buys':
 * @property string $id
 * @property string $book_id
 * @property string $user_id
 * @property string $date
 * @property string $method
 * @property string $package_id
 *
 * The followings are the available model relations:
 * @property BookPackages $package
 * @property Books $book
 * @property Users $user
 */
class BookBuys extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_book_buys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, user_id', 'required'),
			array('date', 'default', 'value'=>time()),
			array('book_id, user_id, method, package_id', 'length', 'max'=>10),
			array('date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, book_id, user_id, date, method, package_id', 'safe', 'on'=>'search'),
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
            'package' => array(self::BELONGS_TO, 'BookPackages', 'package_id'),
			'book' => array(self::BELONGS_TO, 'Books', 'book_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'book_id' => 'Book',
			'user_id' => 'User',
			'date' => 'تاریخ',
            'method' => 'روش خرید',
            'package_id' => 'نسخه',
		);
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
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('date',$this->date,true);
        $criteria->compare('method',$this->method,true);
        $criteria->compare('package_id',$this->package_id,true);

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookBuys the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
