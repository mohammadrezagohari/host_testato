<?php
namespace App\Repositories\MySQL\SuggestionRepository;
use App\Repositories\MySQL\SuggestionRepository\InterfaceSuggestionRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Suggestion;

class SuggestionRepository extends BaseRepository implements InterfaceSuggestionRepository
{
    /***********************
     * @var Suggestion $model
     ***********************/
    protected Suggestion $model;

    /*************************
     * @param Suggestion $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Suggestion $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
