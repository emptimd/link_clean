<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\TopicalTrustTarget;
use App\Repositories\CampaignRepository;

class RefController extends Controller
{

    public function showRefs($id, CampaignRepository $campaignRepo)
    {
        /** @var Campaign $campaign */
        $campaign = $campaignRepo->findWithAuthor($id);

        if(!$campaign->is_finished()) return back();

        return view('ref.campaign_refs', [
            'campaign'  => $campaign,
            'totals'	=> $campaign->totals(),
        ]);
    }

    public function showRefSingle($id, $domain, CampaignRepository $campaignRepo)
    {
        /** @var Campaign $campaign*/
        $campaign = $campaignRepo->findWithAuthor($id);

        $topics = TopicalTrustTarget::where('campaign_id', $id)->where('target_backlink_url', $domain)->limit(3)->get();

        return view('ref.campaign_ref_single', [
            'campaign'  => $campaign,
            'totals'	=> $campaign->refsingle_totals($domain),
            'domain'    => $domain,
            'topics' => $topics
        ]);
    }

}