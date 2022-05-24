<?php namespace Err404\User\Behaviors;

use Db;
use RainLab\Location\Models\Country;
use RainLab\Location\Models\State;
use System\Classes\ModelBehavior;
use ApplicationException;
use Exception;

class LocationModel extends ModelBehavior
{
    /**
     * Constructor
     */
    public function __construct($model)
    {
        parent::__construct($model);

        $guarded = $model->getGuarded();

        if (count($guarded) === 1 && $guarded[0] === '*') {
            $model->addFillable([
                'ship_country',
                'ship_country_id',
            ]);
        }

        $model->belongsTo['ship_country'] = ['RainLab\Location\Models\Country'];
    }


    /**
     * Ensure an integer value is set, otherwise nullable.
     */
    public function setShipCountryIdAttribute($value)
    {
        $this->model->attributes['ship_country_id'] = $value ?: null;
    }

    public function getShipCountryOptions()
    {
        return Country::getNameList();
    }

    public function getShippingStateOptions()
    {
        return State::getNameList($this->model->country_id);
    }


}
