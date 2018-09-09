<?php $i=5;?>
<div class="left-shadow"></div>
    <h1>Tumblr Posts with High PA</h1>

    <div class="desc"><p><img src="http://i.imgur.com/umRLKvG.png" alt="Tumblr Blog Posting" width="682" height="459"></p><br>
        <p>Our team is all time looking for innovative SEO solutions! And after long research, we would like to present you an awesome and brand new gig from CrorkService.</p><br>
        <p>We have a large Tumblr blog network, in which all blogs have <strong>page authority from 27 to 38</strong>, isn't this amazing?</p><br>
        <p>In this service we will create 20 posts in our Tumblr blogs - so you will get backlinks from high authority resource!</p><br>
        <p>From your side You will have to provide 20 articles for this service.<br>If you don't have articles, you can buy them in our extrases.</p><br>
        <p>If you want to post more articles, just order Extras for 50 blog posts.</p><br>
        <p>All articles written by our team, will be SEO optimized considering your keywords and in each article will be 1 backlink to your website.<br>Articles will be 400-500 words long.</p><br>
        <p><strong>Features and advantages:</strong><br>- Full manual work<br>- Just unique content<br>- Report with live links<br>- Dofollow links<br>- Links with High PA</p><br>
        <p>Do not hesitate and Order Now to increase rankings if your website!</p></div>

    <form class="form form-vertical" id="product-to-cart" action="/site/products/tumblr-posts" method="post">
        <div id="product-details">

            <table class="service-table">
                <thead>
                <tr><th>Service</th>
                    <th>TAT</th>
                    <th>Price</th>
                    <th>Buy</th>
                </tr></thead>
                <tbody>
                <tr>
                    <td><label for="product-f-497" value="497">20 Tumblr Posts with your articles</label></td>
                    <td>~7 Days</td>
                    <td>$5.00</td>
                    <td>
                        <div class="cart-actions">
                            <a class="to-cart select" data-id="{{ $products[$i]['id'] }}" data-product="{{ $products[$i++]['fastspring_name'] }}">Select</a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <h1>Extras</h1>

            <table class="service-table">
                <thead>
                <tr><th>Service</th>
                    <th>TAT</th>
                    <th>Price</th>
                </tr></thead>
                <tbody>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">Write 20 articles and use it for posts</label></td>
                    <td>+10 Days</td>
                    <td>$35.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">Make manual LinkJuice for posts created - High Authority Profiles and Social Bookmarks</label></td>
                    <td>+3 Days</td>
                    <td>$12.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">Additional 50 Tumblr Posts including article writing for each post</label></td>
                    <td>+15 Days</td>
                    <td>$89.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">Make 1000 retweets LinkJuice for posts created</label></td>
                    <td>+3 Days</td>
                    <td>$8.00</td>
                </tr>
                </tbody>
            </table>

        </div>

        <div id="order-details">

            <h1>Add to cart</h1>

            <p></p><ul>
                <li><strong>Complete the following information below:</strong></li>
            </ul><p></p>

            <p class="input"><label for="data-212" class="required">1 URL <span class="required">*</span></label>
                <textarea class="required" name="data[212]" id="data-212" cols="30" rows="10"></textarea>                            </p>
            <p class="input"><label for="data-213" class="required">Up to 10 Keywords <span class="required">*</span></label>
                <textarea class="required" name="data[213]" id="data-213" cols="30" rows="10"></textarea>                            </p>
            <p class="input"><label for="data-214">Your 20 articles - please give us link to archive via dropbox. If you don't have, please order in extrases. </label>
                <textarea name="data[214]" id="data-214" cols="30" rows="10"></textarea>                            </p>

            <div class="submit-buttons">
                <div class="cart-actions">
                    <button type="submit" class="to-cart add-to-cart">Buy</button>
                    <a class="to-cart cancel" href="#">Cancel</a>

                    <span class="errorMessage right"></span>
                </div>
            </div>

        </div>

    </form>