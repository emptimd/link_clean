<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsMigration_20170829153333 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $products = [
            [
                'name' => 'Press Release Package',
                'fastspring_name' => 'press-release-package',
                'is_extras' => 0,
                'price' => 49
            ],
            [
                'name' => '50 web 2.0 Properties, all unique domians, each with unique article, full manual work',
                'fastspring_name' => '50-web-2-0-properties',
                'is_extras' => 1,
                'price' => 75
            ],
            [
                'name' => '15 niche relevant posts',
                'fastspring_name' => '15-niche-relevant-posts',
                'is_extras' => 1,
                'price' => 200
            ],
            [
                'name' => '30 niche relevant posts',
                'fastspring_name' => '30-niche-relevant-posts',
                'is_extras' => 1,
                'price' => 350
            ],
            [
                'name' => '45 niche relevant posts',
                'fastspring_name' => '45-niche-relevant-posts',
                'is_extras' => 1,
                'price' => 500
            ],
            [
                'name' => '20 Tumblr Posts with your articles',
                'fastspring_name' => '20-tumblr-posts',
                'is_extras' => 0,
                'price' => 5
            ],
            [
                'name' => 'Write 20 articles and use it for posts',
                'fastspring_name' => '20-articles-for-tumblr',
                'is_extras' => 1,
                'price' => 35
            ],
            [ // @TODO ??? did not found
                'name' => 'Make manual LinkJuice for posts created - High Authority Profiles and Social Bookmarks',
                'fastspring_name' => 'manual-linkjuice-for-posts-created-high-authority-profiles-and-social-bookmarks',
                'is_extras' => 1,
                'price' => 10
            ],
            [
                'name' => 'Additional 50 Tumblr Posts including article writing for each post',
                'fastspring_name' => 'additional-50-tumblr-posts-extra',
                'is_extras' => 1,
                'price' => 89
            ],
            [
                'name' => 'Make 1000 retweets LinkJuice for posts created',
                'fastspring_name' => '1000-retweets-linkjuice-extra',
                'is_extras' => 1,
                'price' => 8
            ],
            // High DA Profiles

            [
                'name' => '10 High DA Profiles',
                'fastspring_name' => '10-high-da-profiles',
                'is_extras' => 0,
                'price' => 2
            ],
            [
                'name' => '20 High DA Profiles',
                'fastspring_name' => '20-high-da-profiles',
                'is_extras' => 0,
                'price' => 3
            ],
            [// ?
                'name' => '10 EDU Profiles',
                'fastspring_name' => '10-edu-profiles',
                'is_extras' => 0,
                'price' => 2
            ],
            [// ?
                'name' => '20 EDU Profiles',
                'fastspring_name' => '20-edu-profiles',
                'is_extras' => 0,
                'price' => 3
            ],
            [
                'name' => '500 Social Bookmarks LinkJuice',
                'fastspring_name' => '500-social-bookmarks-linkjuice-extra',
                'is_extras' => 1,
                'price' => 2
            ],
            [
                'name' => 'New unique 200 backlinks from top authority sites',
                'fastspring_name' => 'new-unique-200-backlinks-extra',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => '25 High DA Top Social Bookmarks',
                'fastspring_name' => '25-high-da-top-social-bookmarks-extra',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => 'Ping all links',
                'fastspring_name' => 'ping-all-links',
                'is_extras' => 1,
                'price' => 1
            ],

            //EDU blog Posts
            [
                'name' => '3 EDU blog posts',
                'fastspring_name' => '3-edu-blog-posts',
                'is_extras' => 0,
                'price' => 4
            ],

            [
                'name' => '1 unique article 400 words and use it for posts',
                'fastspring_name' => '1-unique-article-400-words-extra',
                'is_extras' => 1,
                'price' => 5
            ],
            [
                'name' => '3 different unique articles each 400 words, 1 article per post',
                'fastspring_name' => '3-different-unique-articles-extra',
                'is_extras' => 1,
                'price' => 10
            ],
            [
                'name' => '1 PBN post in relevant niche with unique article',
                'fastspring_name' => '1-pbn-post-in-relevant-niche-extra',
                'is_extras' => 1,
                'price' => 8
            ],
            [
                'name' => '20 Authority Press Releases with unique human written PR article',
                'fastspring_name' => '20-authority-press-releases-with-unique-human-written-pr-article',
                'is_extras' => 1,
                'price' => 10
            ],
            [
                'name' => '1 Approved Ezine Article',
                'fastspring_name' => '1-approved-ezine-article-extra',
                'is_extras' => 1,
                'price' => 8
            ],
            [// ?
                'name' => '20 High DA Top Social Bookmarks',
                'fastspring_name' => '20-high-da-top-social-bookmarks',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => '20 High DA Quality Profiles',
                'fastspring_name' => '20-high-da-quality-profiles-extra',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => '15 EDU Profiles',
                'fastspring_name' => '15-edu-profiles-extra',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => '600 Social Signals MIX',
                'fastspring_name' => '600-social-signals-mix-extra',
                'is_extras' => 1,
                'price' => 4
            ],

            //Reddit Posting
            [// ?
                'name' => 'Post on Reddit with 10 comments and 300 social signals',
                'fastspring_name' => 'post-on-reddit-with-10-comments-and-300-social-signals',
                'is_extras' => 0,
                'price' => 5
            ],
            [// ?
                'name' => '1000 Social Signals for your URL',
                'fastspring_name' => '1000-social-signals-for-your-url',
                'is_extras' => 1,
                'price' => 8
            ],
            [
                'name' => '1 EDU blog post with unique article',
                'fastspring_name' => '1-edu-blog-post-extra',
                'is_extras' => 1,
                'price' => 6
            ],

            //Wiki Backlinks
            [
                'name' => '100 Media Wiki Backlinks	',
                'fastspring_name' => '100-media-wiki-backlinks',
                'is_extras' => 0,
                'price' => 2
            ],
            [
                'name' => '200 Media Wiki Backlinks',
                'fastspring_name' => '200-media-wiki-backlinks',
                'is_extras' => 0,
                'price' => 4
            ],
            [
                'name' => 'Unique Article with Human Readable Spin',
                'fastspring_name' => 'unique-article-with-human-readable-spin',
                'is_extras' => 1,
                'price' => 8
            ],
            [// ?
                'name' => '1000 Social Bookmarks LinkJuice',
                'fastspring_name' => '1000-social-bookmarks-linkjuice',
                'is_extras' => 1,
                'price' => 3
            ],
            [
                'name' => '40 000 Blog Comments LinkJuice',
                'fastspring_name' => '40-000-blog-comments-linkjuice-extra',
                'is_extras' => 1,
                'price' => 3
            ],
            [// ?
                'name' => 'New unique 200 backlinks from top authority sites',
                'fastspring_name' => 'new-unique-200-backlinks-from-top-authority-sites',
                'is_extras' => 1,
                'price' => 4
            ],
            //Blog Comments Blast
//            [
//                'name' => '40 000 Blog Comments LinkJuice',
//                'fastspring_name' => '40-000-blog-comments-linkjuice-extra',
//                'is_extras' => 0,
//                'price' => 3
//            ],
//            [
//                'name' => '40 000 Blog Comments LinkJuice',
//                'fastspring_name' => '40-000-blog-comments-linkjuice-extra',
//                'is_extras' => 0,
//                'price' => 3
//            ],
//            [
//                'name' => '40 000 Blog Comments LinkJuice',
//                'fastspring_name' => '40-000-blog-comments-linkjuice-extra',
//                'is_extras' => 0,
//                'price' => 3
//            ],
//            [
//                'name' => '40 000 Blog Comments LinkJuice',
//                'fastspring_name' => '40-000-blog-comments-linkjuice-extra',
//                'is_extras' => 1,
//                'price' => 3
//            ],
            //Web 2.0 Properties
            [
                'name' => '20 Web 2.0 Properties',
                'fastspring_name' => '20-web-2-0-properties',
                'is_extras' => 0,
                'price' => 2
            ],
            [
                'name' => '40 Web 2.0 Properties',
                'fastspring_name' => '40-web-2-0-properties',
                'is_extras' => 0,
                'price' => 4
            ],
            [
                'name' => '3 EDU blog posts with 3 unique articles',
                'fastspring_name' => '3-edu-blog-posts-extra',
                'is_extras' => 1,
                'price' => 15
            ],
            [
                'name' => '2000 WikiMedia LinkJuice',
                'fastspring_name' => '2000-wikimedia-linkjuice-extra',
                'is_extras' => 1,
                'price' => 2
            ],
        ];


        \DB::table('products')->insert($products);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
