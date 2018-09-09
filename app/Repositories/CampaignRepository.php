<?php

namespace App\Repositories;

use App\Models\Campaign;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CampaignRepository
 * @package App\Repositories
 * @version August 28, 2018, 3:09 am EEST
 *
 * @method Campaign findWithoutFail($id, $columns = ['*'])
 * @method Campaign find($id, $columns = ['*'])
 * @method Campaign first($columns = ['*'])
*/
class CampaignRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Campaign::class;
    }

    public function findWithAuthor($id)
    {
        return Campaign::campaignAuthor()->findOrFail($id);
    }
}
