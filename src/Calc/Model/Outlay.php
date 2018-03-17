<?php namespace Calc\Model;

use Calc\Model\Traits\Descriptionable;

abstract class Outlay extends BaseModel
{
    use Descriptionable;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [];

    protected $appends = ['date'];

    public $timestamps = false;

    /** EVENTS */

    public static function boot()
    {
        self::saving(function (self $model)
        {
            if (empty($model->date)) $model->date = null;
        });
    }

    /** RELATIONS */

    public function order()
    {
        return $this->belongsTo('Calc\Model\Order');
    }

    /** SETTERS */

    /**
     * Set outlay value
     *
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float) $value;
    }

    public function setOrderAttribute($value)
    {
        if (is_array($value) && isset($value['id']))
        {
            $value = $value['id'];
        }
        else if ($value instanceof Order)
        {
            $value = $value->id;
        }

        $this->attributes['order_id'] = (int) $value;
    }

    /* GETTERS */

    public function getValueAttribute()
    {
        if ( ! isset($this->attributes['value'])) return null;

        return (float) $this->attributes['value'];
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $this->createDate($value);
    }

    /**
     * @return null|string
     */
    public function getDateAttribute()
    {
        if ( ! $this->attributes['date']) return null;

        return $this->asDateTime($this->attributes['date'])->format(self::DATE_FORMAT);
    }
}
