<?php

namespace App\Repositories\MySQL\ProfileRepository;

use App\Models\Address;
use App\Models\User;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class ProfileRepository extends BaseRepository implements InterfaceProfileRepository
{
    /***********************
     * @var User $model
     ***********************/
    protected User $model;

    /*************************
     * @param User $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function find($id)
    {
        $this->model->withIndex()->find($id);
    }

    public function step_value($id, $values)
    {
        $item = $this->model->find($id);
        return $item->update($values);
    }

    public function updateProfileByUser($id, $data, $address)
    {
        $item = $this->model->find($id);
        if (@$address) {
            $details = get_reverse_geo_to_address($address['lat'], $address['lon']);
            $addressData = Address::create([
                'lat' => $address['lat'],
                'lon' => $address['lon'],
                'details' => $details->original->address
            ]);
            $data['address_id'] = $addressData->id;
        }
//        $item->familiar = @$data['mobile'] ?? $item->mobile;
        $item->mobile = @$data['mobile'] ?? $item->mobile;
        $item->name = @$data['name'] ?? $item->name;
        $item->avatar = @$data['avatar'] ?? $item->avatar;
        $item->is_student = @$data['is_student'] ?? $item->is_student;
        $item->school_id = @$data['school_id'] ?? $item->school_id;
        $item->field_id = @$data['field_id'] ?? $item->field_id;
        $item->grade_id = @$data['grade_id'] ?? $item->grade_id;
        $item->access_type = @$data['access_type'] ?? $item->access_type;
        $item->sex = @$data['sex'] ?? $item->sex;
        return $item->save();
    }

    public function deleteUser($user)
    {
        $user->UserOTPs()->detach();
        return $user->delete();
    }

}
