<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Classes\GA_Service;
use App\Models\GoogleAnalitycs;
use App\Models\GoogleAnalitycsStash;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_ReportRequest;
use Illuminate\Console\Command;

class GoogleAnalitycsCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google_analitycs {id : The ID of campaign} {access_token : Access token for GA} {view_id : The ID of the selected view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches Campaign backlinks malware check through Google API.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::find($this->argument('id'));

        if (!$campaign) {
            $this->error('Campaign not found.');
            return;
        }

        $ga = new GA_Service($this->argument('access_token'));
        $client = $ga->getCliet();

        // Create an authorized analytics service object.
        $analytics = new Google_Service_AnalyticsReporting($client);

        // Call the Analytics Reporting API V4.
        $response = $this->getReport($analytics, $this->argument('view_id'));
        // GET nr. users from ogranic traffic.
        $response_users = $this->getReportUsers($analytics, $this->argument('view_id'));
        $users_organic = $response_users[0]->getData()->getRows()[0]->getMetrics()[0]->values[0];

        $insert = [];

        $views = $social_views = 0;
        $rows = $response[0]->getData()->getRows();

        for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[$rowIndex];
            $dimensions = $row->getDimensions();
            $val = $row->getMetrics()[0]->values[0];
            $insert[] = [
                'campaign_id' => $campaign->id,
                'SourceUrl' => $dimensions[0],
                'TargetUrl' => $dimensions[1],
                'views' => $val // users.
            ];
            if($dimensions[2] === "Yes") $social_views += $val;
            $views += $val;
        }

        $analytic = [
            'campaign_id' => $campaign->id,
            'users_organic' => $users_organic,
            'users_referral' => $views,
            'users_social' => $social_views,
            'date' => /*date('j') > 10 ? date('Y-m-d') : */date('Y-m-d', strtotime('first day of last month'))
        ];

        // INSERT IN DB.
        foreach(array_chunk($insert, 1000) as $chunk) {
            GoogleAnalitycsStash::insert($chunk);
        }

        GoogleAnalitycs::insert($analytic); // or create

        $this->info('1');
    }

    public function getReport(Google_Service_AnalyticsReporting $analytics, $view_id)
    {
        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        // here we check if current date is > 10. else take info from last month.
        $dateRange->setStartDate(date('Y-m-d', strtotime('first day of last month')));
        $dateRange->setEndDate(date('Y-m-d', strtotime('last day of last month')));


        // Create the Metrics object.
        $session2 = new Google_Service_AnalyticsReporting_Metric();
        $session2->setExpression("ga:users");


        $dimension1 = new Google_Service_AnalyticsReporting_Dimension();
        $dimension1->setName("ga:fullReferrer");

        $dimension2 = new Google_Service_AnalyticsReporting_Dimension();
        $dimension2->setName("ga:landingPagePath");

        $dimension3 = new Google_Service_AnalyticsReporting_Dimension();
        $dimension3->setName("ga:hasSocialSourceReferral");


        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($view_id);
        $request->setDateRanges($dateRange);
        $request->setMetrics([$session2]);
        // here add dimensions,filters,sort
        $request->setDimensions([$dimension1, $dimension2, $dimension3]);
        $request->setFiltersExpression("ga:medium==referral");

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }

    public function getReportUsers(Google_Service_AnalyticsReporting $analytics, $view_id)
    {
        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate(date('Y-m-d', strtotime('first day of last month')));
        $dateRange->setEndDate(date('Y-m-d', strtotime('last day of last month')));
        // Create the Metrics object.
        $session = new Google_Service_AnalyticsReporting_Metric();
        $session->setExpression("ga:users");

        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($view_id);
        $request->setDateRanges($dateRange);
        $request->setMetrics([$session]);
        $request->setFiltersExpression("ga:medium==organic");

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }
}
