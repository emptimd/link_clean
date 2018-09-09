<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\TargetSocial;
use App\Models\TopicalTrustTarget;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class DestinationController extends Controller
{

    public function showDestinations($id, CampaignRepository $campaignRepo)
    {
        /** @var Campaign $campaign*/
        $campaign = $campaignRepo->findWithAuthor($id);

        $totals = $campaign->totals_new();

        JavaScriptFacade::put([
            'super' 	=> 50,
            'medium' 	=> 100,
            'bad'		=> 10,
            'critical'	=> 5,
            'pie'       => [
                ['High', $totals->super],
                ['Medium', $totals->medium],
                ['Low', $totals->bad],
                ['Critical', $totals->critical],
            ]
        ]);

        return view('destination.campaign_destination', [
            'campaign'      => $campaign,
            'totals'        => $totals,
            'destination'   => $campaign->getDestination()
        ]);
    }

    public function showDestinationTarget($id, Request $request, CampaignRepository $campaignRepo)
    {
        /** @var Campaign $campaign*/
        $campaign = $campaignRepo->findWithAuthor($id);

        $is_target = $campaign->isDestinationTarget($request->target);
        if(!$is_target) dd('error - no such target');

        $totals = $campaign->totals_target($request->target);

        $domain_social = TargetSocial::where('domain', $request->target)->first();
        $destination_topic = TopicalTrustTarget::where('target_backlink_url', $request->target)->limit(4)->get()->toArray();

        JavaScriptFacade::put([
            'super' 	=> 50,
            'medium' 	=> 100,
            'bad'		=> 10,
            'critical'	=> 5,
            'pie'       => [
                ['High', $totals->super],
                ['Medium', $totals->medium],
                ['Low', $totals->bad],
                ['Critical', $totals->critical],
            ]
        ]);

        return view('destination.campaign_destination_target', [
            'campaign'      => $campaign,
            'totals'        => $totals,
            'target'        => $request->target,
            'domain_social' => $domain_social,
            'destination_topic' => $destination_topic
        ]);
    }
}