<?php

/**
 * This is the model class for table "{{books}}".
 *
 * The followings are the available columns in table '{{books}}':
 * @property string $id
 * @property string $title
 * @property string $icon
 * @property string $description
 * @property integer $number_of_pages
 * @property string $change_log
 * @property string $language
 * @property string $status
 * @property string $category_id
 * @property string $publisher_name
 * @property string $publisher_id
 * @property string $confirm
 * @property string $confirm_date
 * @property integer $seen
 * @property string $download
 * @property integer $deleted
 * @property integer $size
 * @property integer $price
 * @property integer $printed_price
 * @property integer $off_printed_price
 * @property integer $offPrice
 * @property integer $rate
 *
 *
 * The followings are the available model relations:
 * @property BookPackages $lastPackage
 * @property BookBuys[] $bookBuys
 * @property BookImages[] $images
 * @property Users $publisher
 * @property BookCategories $category
 * @property Users[] $bookmarker
 * @property BookPackages[] $packages
 * @property BookDiscounts $discount
 * @property Advertises $bookAdvertises
 * @property BookPersons $persons
 * @property Comment[] $comments
 * @property Tags[] $showTags
 * @property Tags[] $seoTags
 */
class Books extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{books}}';
	}

	private $_purifier;
	public $confirmLabels = array(
			'pending' => 'در حال بررسی',
			'refused' => 'رد شده',
			'accepted' => 'تایید شده',
			'change_required' => 'نیاز به تغییر',
	);
	public $statusLabels = array(
			'enable' => 'فعال',
			'disable' => 'غیر فعال'
	);

	/**
	 * @var string publisher name filter
	 */
	public $devFilter;

	public $formTags = [];
	public $formSeoTags = [];
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		$this->_purifier = new CHtmlPurifier();
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_id ,icon', 'required'),
			array('number_of_pages, seen, deleted, confirm_date', 'numerical', 'integerOnly' => true),
			array('description, change_log ,formTags ,formSeoTags', 'filter', 'filter' => array($this->_purifier, 'purify')),
			array('title, icon, publisher_name', 'length', 'max' => 50),
			array('number_of_pages', 'length', 'max' => 5),
			array('publisher_id, category_id', 'length', 'max' => 10),
			array('language, confirm_date', 'length' ,'max'=>20),
			array('language', 'filter' ,'filter'=>'strip_tags'),
			array('status', 'length', 'max' => 7),
			array('download', 'length', 'max' => 12),
			array('description, change_log ,publisher_name ,_purifier', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, confirm_date, icon, description, change_log, number_of_pages, language, status, category_id, publisher_name, publisher_id, confirm, seen, download, deleted ,devFilter', 'safe', 'on' => 'search'),
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
				'bookBuys' => array(self::HAS_MANY, 'BookBuys', 'book_id'),
				'images' => array(self::HAS_MANY, 'BookImages', 'book_id'),
				'publisher' => array(self::BELONGS_TO, 'Users', 'publisher_id'),
				'category' => array(self::BELONGS_TO, 'BookCategories', 'category_id'),
				'discount' => array(self::HAS_ONE, 'BookDiscounts', 'book_id',
                    'condition' => 'discount.start_date < :time AND discount.end_date > :time',
                    'params'=>array(':time' => time()),
                    'order'=>'id DESC'
                ),
				'bookmarker' => array(self::MANY_MANY, 'Users', 'ym_user_book_bookmark(book_id,user_id)'),
				'lastPackage' => array(self::HAS_ONE, 'BookPackages', 'book_id' ,'on' => 'status = "accepted"','order'=>'publish_date DESC'),
				'packages' => array(self::HAS_MANY, 'BookPackages', 'book_id'),
				'ratings' => array(self::HAS_MANY, 'BookRatings', 'book_id'),
				'advertise' => array(self::BELONGS_TO, 'Advertises', 'id'),
				'showTags' => array(self::MANY_MANY, 'Tags', '{{book_tag_rel}}(book_id,tag_id)', 'on' => 'for_seo = 0'),
				'seoTags' => array(self::MANY_MANY, 'Tags', '{{book_tag_rel}}(book_id,tag_id)', 'on' => 'for_seo = 1'),
				'persons' => array(self::MANY_MANY, 'BookPersons', '{{book_person_role_rel}}(book_id, person_id, role_id)'),
				'roles' => array(self::MANY_MANY, 'BookPersonRoles', '{{book_person_role_rel}}(book_id, person_id, role_id)'),
		);
	}

//	public function getSortPersons(){
//		$criteria = new CDbCriteria();
//		$criteria->order = 'roles.order';
//		var_dump($this->persons($criteria));exit;
//	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'شناسه',
            'title' => 'عنوان',
            'icon' => 'تصویر جلد',
            'description' => 'توضیحات',
            'number_of_pages' => 'تعداد صفحات',
            'language' => 'زبان کتاب',
            'publisher_id' => 'ناشر',
            'category_id' => 'دسته',
            'status' => 'وضعیت',
            'change_log' => 'لیست تغییرات',
            'confirm' => 'وضعیت انتشار',
            'confirm_date' => 'تاریخ انتشار',
            'publisher_name' => 'عنوان ناشر',
            'seen' => 'دیده شده',
            'download' => 'تعداد دریافت',
            'deleted' => 'حذف شده',
            'size' => 'حجم فایل',
            'formTags' => 'برچسب های نمایشی',
            'formSeoTags' => 'برچسب های سئو',
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

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.title', $this->title, true);
		$criteria->compare('category_id', $this->category_id);
		$criteria->compare('t.status', $this->status);
		$criteria->with = array('publisher', 'publisher.userDetails');
		$criteria->addCondition('publisher_name Like :dev_filter OR  userDetails.fa_name Like :dev_filter OR userDetails.en_name Like :dev_filter OR userDetails.publisher_id Like :dev_filter');
		$criteria->params[':dev_filter'] = '%'.$this->devFilter.'%';

		$criteria->addCondition('deleted=0');

		$criteria->addCondition('t.title != ""');
		$criteria->order = 't.id DESC';

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Books the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)) {
			if(!$this->IsNewRecord)
				BookTagRel::model()->deleteAll('for_seo = 0 AND book_id='.$this->id);
			foreach($this->formTags as $tag) {
				$tagModel = Tags::model()->findByAttributes(array('title' => $tag));
				if($tagModel) {
					$tag_rel = new BookTagRel('not_seo');
					$tag_rel->book_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save();
				} else {
					$tagModel = new Tags;
					$tagModel->title = $tag;
					if($tagModel->save()) {
						$tag_rel = new BookTagRel('not_seo');
						$tag_rel->book_id = $this->id;
						$tag_rel->tag_id = $tagModel->id;
						$tag_rel->save();
					}
				}
			}
		}
		if($this->formSeoTags && !empty($this->formSeoTags)) {
			if(!$this->IsNewRecord)
                BookTagRel::model()->deleteAll('for_seo = 1 AND book_id='.$this->id);
			foreach($this->formSeoTags as $tag) {
				$tagModel = Tags::model()->findByAttributes(array('title' => $tag));
				if($tagModel) {
					$tag_rel = new BookTagRel('for_seo');
					$tag_rel->book_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save();
				} else {
					$tagModel = new Tags;
					$tagModel->title = $tag;
					if($tagModel->save()) {
						$tag_rel = new BookTagRel('for_seo');
						$tag_rel->book_id = $this->id;
						$tag_rel->tag_id = $tagModel->id;
						$tag_rel->save();
					}
				}
			}
		}
		parent::afterSave();
	}

	/**
	 * Return url of book file
	 */
	public function getBookFileUrl()
	{
		if(!empty($this->packages))
			return Yii::app()->createUrl("/uploads/books/files/".$this->lastPackage->file_name);
		return '';
	}

	public function getPublisherName()
	{
		if($this->publisher_id)
			return $this->publisher->userDetails->nickname?$this->publisher->userDetails->nickname:$this->publisher->userDetails->fa_name;
		else
			return $this->publisher_name;
	}



	public function hasDiscount()
	{
		if($this->discount && $this->discount->percent && $this->discount->start_date < time() && $this->discount->end_date > time())
			return true;
		else
			return false;
	}

	public function calculateRating()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$result['totalCount'] = BookRatings::model()->count($criteria);
		$criteria->select = array('rate', 'avg(rate) as avgRate');
		$result['totalAvg'] = BookRatings::model()->find($criteria)->avgRate;

		$criteria->addCondition('rate = :rate');
		$criteria->params[':rate'] = 1;
		$result['oneCount'] = BookRatings::model()->count($criteria);
		$result['onePercent'] = $result['totalCount'] ? $result['oneCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 2;
		$result['twoCount'] = BookRatings::model()->count($criteria);
		$result['twoPercent'] = $result['totalCount'] ? $result['twoCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 3;
		$result['threeCount'] = BookRatings::model()->count($criteria);
		$result['threePercent'] = $result['totalCount'] ? $result['threeCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 4;
		$result['fourCount'] = BookRatings::model()->count($criteria);
		$result['fourPercent'] = $result['totalCount'] ? $result['fourCount'] / $result['totalCount'] * 100 : 0;
		$criteria->params[':rate'] = 5;
		$result['fiveCount'] = BookRatings::model()->count($criteria);
		$result['fivePercent'] = $result['totalCount'] ? $result['fiveCount'] / $result['totalCount'] * 100 : 0;
		return $result;
	}

	public function getRate()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$criteria->select = array('rate', 'avg(rate) as avgRate');
		return BookRatings::model()->find($criteria)->avgRate;
	}

	public function getCountRate()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		return BookRatings::model()->count($criteria);
	}

	public function userRated($user_id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('book_id', $this->id);
		$criteria->compare('user_id', $user_id);
		$result = BookRatings::model()->find($criteria);
		return $result ? $result->rate : false;
	}

    /**
     * Get criteria for valid books
     *
     * @param array $categoryIds
     * @param string $order
     * @param string $limit
     * @return CDbCriteria
     */
	public function getValidBooks($categoryIds = array(),$order = 'confirm_date DESC',$limit = null)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status=:status');
		$criteria->addCondition('confirm=:confirm');
		$criteria->addCondition('deleted=:deleted');
		$criteria->addCondition('(SELECT COUNT(book_packages.id) FROM ym_book_packages book_packages WHERE book_packages.book_id=t.id) != 0');
		$criteria->params[':status'] = 'enable';
		$criteria->params[':confirm'] = 'accepted';
		$criteria->params[':deleted'] = 0;
		if($categoryIds)
			$criteria->addInCondition('category_id', $categoryIds);
		$criteria->order = $order;
		if($limit)
			$criteria->limit = $limit;
		return $criteria;
	}

	public function getPrice(){
		return $this->lastPackage->price;
	}
	public function getPrinted_price(){
		return $this->lastPackage->printed_price;
	}
	public function getOffPrice()
	{
		if($this->discount)
			return $this->lastPackage->price - $this->lastPackage->price * $this->discount->percent / 100;
		else
			return $this->lastPackage->price ;
	}
	public function getOff_printed_price()
	{
		if($this->discount)
			return $this->lastPackage->printed_price - $this->lastPackage->printed_price * $this->discount->percent / 100;
		else
			return $this->lastPackage->printed_price;
	}

	public function getComments(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('owner_name = :model AND owner_id = :id');
		$criteria->params =array(':model' => get_class($this) ,':id'=>$this->id);
		return Comment::model()->findAll($criteria);
	}

	public function getCountComments(){
		Yii::app()->getModule('comments');
		$criteria = new CDbCriteria();
		$criteria->addCondition('owner_name = :model AND owner_id = :id');
		$criteria->params =array(':model' => get_class($this) ,':id'=>$this->id);
		return Comment::model()->count($criteria);
	}
}
