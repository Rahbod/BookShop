<?php

/**
 * This is the model class for table "ym_user_transactions".
 *
 * The followings are the available columns in table 'ym_user_transactions':
 * @property string $id
 * @property string $user_id
 * @property string $amount
 * @property string $date
 * @property string $status
 * @property string $token
 * @property string $authority
 * @property string $description
 * @property string $gateway_name
 * @property string $type
 * @property string $user_name
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UserTransactions extends CActiveRecord
{
	const TRANSACTION_TYPE_CREDIT = 'credit';
	const TRANSACTION_TYPE_BOOK = 'book';
	const TRANSACTION_TYPE_SHOP = 'shop';

	const TRANSACTION_STATUS_PAID = 'paid';
	const TRANSACTION_STATUS_UNPAID = 'unpaid';

	public $statusLabels = array(
		'paid' => 'پرداخت کامل',
		'unpaid' => 'پرداخت ناقص',
	);

	public $typeLabels = array(
		self::TRANSACTION_TYPE_CREDIT => 'خرید اعتبار',
		self::TRANSACTION_TYPE_BOOK => 'خرید کتاب',
		self::TRANSACTION_TYPE_SHOP => 'فروش نسخه چاپی کتاب',
	);

	public $user_name;
	public $methodLabels = [
		'credit' => 'اعتبار',
		'gateway' => 'درگاه'
	];
	public $year_altField;
	public $month_altField;
	public $from_date_altField;
	public $to_date_altField;
	public $report_type;

	public $totalAmount;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_user_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('authority', 'required', 'on' => 'set-authority'),
			array('user_id, amount', 'length', 'max' => 10),
			array('date, type', 'length', 'max' => 20),
			array('status', 'length', 'max' => 6),
			array('token, gateway_name', 'length', 'max' => 50),
			array('description', 'length', 'max' => 200),
			array('authority', 'length', 'max' => 255),
			array('report_type', 'filter', 'filter' => 'strip_tags'),
			array('report_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, amount, date, status, token, authority, description, gateway_name, type, user_name, year_altField, month_altField, to_date_altField, from_date_altField, report_type', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'user_id' => 'کاربر',
			'amount' => 'مقدار',
			'date' => 'تاریخ',
			'status' => 'وضعیت',
			'token' => 'کد رهگیری',
			'description' => 'توضیحات',
			'gateway_name' => 'نام درگاه',
			'type' => 'نوع تراکنش',
			'authority' => 'رشته احراز هویت بانک',
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

		$criteria = new CDbCriteria;
		$this->reportConditions($criteria);
		$criteria->order = 't.date DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => isset($_GET['pageSize'])?$_GET['pageSize']:20)
		));
	}

	/**
	 * @param $criteria
	 */
	public function reportConditions(&$criteria)
	{
		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('amount', $this->amount, true);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('token', $this->token, true);
		$criteria->compare('authority', $this->authority, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('gateway_name', $this->gateway_name, true);
		$criteria->compare('type', $this->type, true);
		if($this->user_name){
			$criteria->with = array('user', 'user.userDetails');
			$criteria->addSearchCondition('userDetails.fa_name', $this->user_name);
			$criteria->addSearchCondition('user.email', $this->user_name, true, 'OR');
		}
		if($this->report_type){
			switch($this->report_type){
				case 'yearly':
					$startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $this->year_altField, false), 1, 1);
					$startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
					$endTime = $startTime + (60 * 60 * 24 * 365);
					$criteria->addCondition('date >= :start_date');
					$criteria->addCondition('date <= :end_date');
					$criteria->params[':start_date'] = $startTime;
					$criteria->params[':end_date'] = $endTime;
					break;
				case 'monthly':
					$startDate = JalaliDate::toGregorian(JalaliDate::date('Y', $this->month_altField, false), JalaliDate::date('m', $this->month_altField, false), 1);
					$startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
					if(JalaliDate::date('m', $this->month_altField, false) <= 6)
						$endTime = $startTime + (60 * 60 * 24 * 31);
					else
						$endTime = $startTime + (60 * 60 * 24 * 30);
					$criteria->addCondition('date >= :start_date');
					$criteria->addCondition('date <= :end_date');
					$criteria->params[':start_date'] = $startTime;
					$criteria->params[':end_date'] = $endTime;
					break;
				case 'by-date':
					$criteria->addCondition('date >= :start_date');
					$criteria->addCondition('date <= :end_date');
					$criteria->params[':start_date'] = $this->from_date_altField;
					$criteria->params[':end_date'] = $this->to_date_altField;
					break;
			}
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserTransactions the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function getTotalAmount()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(amount) as totalAmount';
		$this->reportConditions($criteria);
		$record = $this->find($criteria);
		return $record?$record->totalAmount:0;
	}
}