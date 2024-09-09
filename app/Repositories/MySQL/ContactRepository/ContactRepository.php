<?php
namespace App\Repositories\MySQL\ContactRepository;
use App\Repositories\MySQL\ContactRepository\InterfaceContactRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository extends BaseRepository implements InterfaceContactRepository
{
    /***********************
     * @var Contact $model
     ***********************/
    protected Contact $model;

    /*************************
     * @param Contact $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Contact $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function first()
    {
        return $this->model->first();
    }


}
