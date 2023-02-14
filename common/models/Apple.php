<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

class Apple extends ActiveRecord
{
	public const 
		STATE_ON_TREE		=	'onTree',
		STATE_ON_GROUND		=	'onGround',
		STATE_CORRUPTED		=	'corrupted',
		STATE_EATED			=	'eated',
		CORRUPT_TIME		=	18000;
		
	const AVAILABLE_COLORS=
	[
		'green',
		'purple',
		'orange',
		'blue',
		'red',
		'white',
		'black',
		'magenta',
		'cyan',
		'brown',
		'silver',
		'gold',
		'cream',
		'yellow',
		'fuchsia',
		'aqua',
		'navy',
		'chocolate',
		'crimson',
		'coral'
	];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['color'], 'string', 'max' => 255],
			[['color'], 'in', 'range' => self::AVAILABLE_COLORS],
			[['created_at','fall_at','updated_at'], 'integer'],
			[['weight_left'], 'integer', 'min' => 0,'max'=>100],
			[['color','created_at','weight_left'], 'required']
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
            ],
        ];
    }
	
	public function generate()
	{		
		$this->color			=	self::AVAILABLE_COLORS[array_rand(self::AVAILABLE_COLORS)];
		$this->weight_left		=	100;
		$curTime				=	time();
		$this->created_at		=	rand($curTime,$curTime+604800);
	}
	
	public function getState()
	{
		if ($this->fall_at)
		{
			if ($this->weight_left==0)
			{
				return self::STATE_EATED;
			}
			
			if (time()>($this->fall_at+self::CORRUPT_TIME))
			{
				return self::STATE_CORRUPTED;
			}
			return self::STATE_ON_GROUND;
		}
		
		return self::STATE_ON_TREE;
	}
	
	public function fall():bool
	{
		if ($this->state==self::STATE_ON_TREE)
		{
			$this->updateAttributes(['fall_at'=>time()]);
			return true;
		}
		$this->addError('state','Apple Not On Tree');
		return false;
	}
	
	public function eat($percent):bool
	{
		if ($this->state==self::STATE_ON_GROUND)
		{
			if ($this->weight_left>=$percent)
			{
				$this->updateAttributes(['weight_left'=>$this->weight_left-$percent]);
				return true;
			}
			else
			{
				$this->addError('weight_left',$this->weight_left);
				return false;
			}
		}
		$this->addError('state',$this->state);
		return false;
	}
	
	public function getPrintErrors()
	{
		$s='';
		foreach ($this->errors as $field=>$errors)
		{
			$s.=$field.' => '.$errors[0];
		}
		return $s;
	}
	
	public function getSize()
	{
		return round($this->weight_left/100,2);
	}

    public function fields()
    {
        return ArrayHelper::merge(
            parent::fields(),
            [
                'state',
				'size'
            ]
        );
    }
}
