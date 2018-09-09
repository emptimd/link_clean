<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ExampleTest extends DuskTestCase
{
//    use DatabaseTransactions;

    public $url = 'stasva.com';

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        /** @var User $user */
        $user = User::where('email', 'taylor@laravel.com')->first();
        \App\Models\Campaign::where('user_id', $user->id)->delete();
        \App\Models\Subscriptions::where('user_id', $user->id)->delete();
        $user->delete();
        $user = factory(User::class)->create([
            'email' => 'taylor@laravel.com',
        ]);

        $user->backlinks=1000;
        $user->referrer();

        \App\Models\Subscriptions::insert([
            'id' => 'asdas',
            'user_id' => $user->id,
            'plan' => 'starter',
            'rebills' => 0,
            'is_active' => 1
        ]);


        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                /*->click('.introjs-skipbutton')*/
                ->clickLink('+ New Campaign')
//                ->click('.introjs-nextbutton')
//                ->pause(500)
                ->whenAvailable('#new-campaign', function ($modal) {
                    $modal->type('#new-campaign-url', $this->url)
//                        ->pause(3000)
                        ->click('#create_campaign');
                })
                ->waitFor('.start_campaign')
                ->click('.introjs-skipbutton')
                ->pause(500)
                ->click('.start_campaign')
                ->whenAvailable('#confirm-ga', function ($modal) use ($browser) {
                    $modal->click('.btn-ok');
                })
                ->waitForText('Campaign successfully started')
                ->assertSee('Campaign successfully started, you will be notified on completion!');
//                ->assertSee('Campaign successfully created!');
//                ->assertSee('Campaign successfully started, you will be notified on completion!');
        });
//        $user->delete();
    }
}
