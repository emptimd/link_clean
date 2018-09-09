<?php $i=10;?>
    <div class="left-shadow"></div>
    <h1>High DA Profiles</h1>

    <div class="desc"><p>Using our special Gooogle-friendly seo technique, we will MANUALLY create 20 High Trusted Backlinks in Using Some of the MOST TRUSTED (PR 9 Old) Websites in the World There will be a mix of no &amp; do-follow, anchored &amp; non-anchored links</p><br>
        <p>- Some with about me text, some without<br>- It is the most NATURAL, search engine friendly technique to use as it does not look spammy &amp; GOOGLE always RANK HIGHER after<br>- Flickr, Vimeo, Mozilla, Disqus, Opera, Liveinternet etc. <br>- 20 Top Quality and Trust Web 2.0s with HUGE PAGE RANK and Authority!</p></div>

    <form class="form form-vertical" id="product-to-cart" action="/site/products/pr9-profiles" method="post">
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
                    <td><label for="product-f-61" value="61">10 High DA Profiles</label></td>
                    <td>~3 Days</td>
                    <td>$2.00</td>
                    <td>
                        <div class="cart-actions">
                            <a class="to-cart select" data-id="{{ $products[$i]['id'] }}" data-product="{{ $products[$i++]['fastspring_name'] }}">Select</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="product-f-62" value="62">20 High DA Profiles</label></td>
                    <td>~3 Days</td>
                    <td>$3.00</td>
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
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">10 EDU Profiles</label></td>
                    <td>-</td>
                    <td>$2.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">20 EDU Profiles</label></td>
                    <td>-</td>
                    <td>$3.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">500 Social Bookmarks LinkJuice</label></td>
                    <td>+1 Day</td>
                    <td>$2.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">New unique 200 backlinks from top authority sites</label></td>
                    <td>-</td>
                    <td>$3.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">25 High DA Top Social Bookmarks</label></td>
                    <td>-</td>
                    <td>$3.00</td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="norounded" name="extra[{{ $products[$i]['id'] }}]" id="extra-{{ $products[$i]['id'] }}" value="{{ $products[$i]['id'] }}" data-product="{{ $products[$i]['fastspring_name'] }}"> <label for="extra-{{ $products[$i++]['id'] }}">Ping all links</label></td>
                    <td>-</td>
                    <td>$1.00</td>
                </tr>
                </tbody>
            </table>


        </div>

        <div id="order-details">

            <h1>Add to cart</h1>

            <p></p><ul>
                <li><strong>Complete the following information below:</strong></li>
            </ul><p></p>

            <p class="input"><label for="data-44" class="required">URL <span class="required">*</span></label>
                <textarea class="required" name="data[44]" id="data-44" cols="30" rows="10"></textarea>                            </p>
            <p class="input"><label for="data-45" class="required">Keywords (up to 5, separated by comma) <span class="required">*</span></label>
                <textarea class="required" name="data[45]" id="data-45" cols="30" rows="10"></textarea>                            </p>
            <p class="input"><label for="data-46">Any Special Instructions For Us </label>
                <textarea name="data[46]" id="data-46" cols="30" rows="10"></textarea>                            </p>

            <div class="submit-buttons">
                <div class="cart-actions">
                    <button type="submit" class="to-cart add-to-cart">Buy</button>
                    <a class="to-cart cancel" href="#">Cancel</a>

                    <span class="errorMessage right"></span>
                </div>
            </div>

        </div>

    </form>