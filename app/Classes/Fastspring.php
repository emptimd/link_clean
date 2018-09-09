<?php

namespace App\Classes;

if (!function_exists("curl_init")) {
    throw new \Exception("FastSpring API needs the CURL PHP extension.");
}

class Fastspring {

    private $company_id;
    private $store_id;
    private $api_username;
    private $api_password;

    public $test_mode;

    public function __construct($company_id, $store_id, $api_username, $api_password) {

        $this->company_id   = $company_id;
        $this->store_id     = $store_id;
        $this->api_username = $api_username;
        $this->api_password = $api_password;

        $this->test_mode = env('APP_ENV') === 'production'?false:true;


        if(\Auth::id() == 127) { // me
            $this->test_mode = true;
        }
    }


    /**
     * @return mixed
     */
    public function test()
    {
        $url = "https://api.fastspring.com/subscriptions?page=1&limit=15";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
//        dd($info);
        return $response;

    }

    public function getAccounts($id=null)
    {

        $url = "https://api.fastspring.com/accounts";
        if($id) $url .= "/$id";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
//        dd($info);
        return $response;
    }

    public function createAccountB($first, $last, $email)
    {
        $url = "https://api.fastspring.com/accounts";
        $data = [
            'contact' => [
                "first" => $first,
                "last" => $last,
                "email" => $email,
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = json_decode(curl_exec($ch));

        if(isset($response->error) && isset($response->error->email)) {
            return substr($response->error->email, -22);// get id from erorr string
        }
        return $response->account;

    }

    public function createSubscriptionB($plan)
    {
        $user = \Auth::user();
        $f_id = \App\Subscriptions::where('user_id', $user->id)->whereNotNull('f_id')->limit(1)->pluck('f_id')->first();
        if(!$f_id) $f_id = $this->createAccountB($user->name, $user->name, $user->email);
        $url = "https://api.fastspring.com/sessions";
        $data = [
            'account' => $f_id,
            'items' => [
                [
                    'product' => $plan,
                    'quantity' => 1
                ]
            ],
            'tags' => [
                'referrer' => $user->id
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = json_decode(curl_exec($ch));

        if(!isset($response->id)) return;

        if($this->test_mode)
            $url = "https://backlinkcontrol.test.onfastspring.com/session/".$response->id;
        else
            $url = "https://backlinkcontrol.onfastspring.com/session/".$response->id;
        header("Location: $url");
        return $url;
    }

    public function cancelSubscriptionB($id)
    {
        $url = "https://api.fastspring.com/subscriptions/$id?billingPeriod=0";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = json_decode(curl_exec($ch));
//        dd($response);

    }



    public function getUnprocessedEvents($days)
    {
        $url = "https://api.fastspring.com/events/unprocessed?days=".$days;//?days=".$days

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
//        dd($info);
        if(!isset($response->id)) return;
    }

    public function processEvent($id)
    {
        $url = "https://api.fastspring.com/events/".$id;//?days=".$days
        $data = ['processed' => true];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = json_decode(curl_exec($ch));
        $info = curl_getinfo($ch);
        if(!isset($response->id)) return;
    }



    /* LINKQUIDATOR*/
    public function createCoupon($prefix) {
        $url = "https://api.fastspring.com/company/".$this->company_id."/coupon/$prefix/generate/";

        $url = $this->addTestMode($url);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            set_error_handler("domDocumentErrorHandler");

            try {
                $doc = new \DOMDocument();
                $doc->loadXML($response);

                $sub = $doc->getElementsByTagName("code")->item(0)->nodeValue;

            } catch(\Exception $e) {
                $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service ".$info["http_code"], 0, $e);
                $fsprgEx->httpStatusCode = $info["http_code"];
            }

            restore_error_handler();
        } else {
            $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service");
            $fsprgEx->httpStatusCode = $info["http_code"];
        }

        curl_close($ch);

        if (isset($fsprgEx)) {
            throw $fsprgEx;
        }

        return $sub;
    }

    public function createSubscription($product_ref, $customer_ref) {
        $url = "http://sites.fastspring.com/".$this->store_id."/product/".$product_ref."?referrer=".$customer_ref;
        $url = $this->addTestMode($url);
        header("Location: $url");
        return $url;
    }

    public function getSubscription($subscription_ref) {
        $url = $this->getSubscriptionUrl($subscription_ref);

        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // turn ssl certificate verification off, i get http response 0 otherwise
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        if ($info["http_code"] == 200) {
            set_error_handler("domDocumentErrorHandler");

            try {
                $doc = new \DOMDocument();
                $doc->loadXML($response);

                $sub = $this->parseFsprgSubscription($doc);
            } catch(\Exception $e) {
                $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service", 0, $e);
                $fsprgEx->httpStatusCode = $info["http_code"];
            }

            restore_error_handler();
        } else {
            $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service");
            $fsprgEx->httpStatusCode = $info["http_code"];
        }

        if (isset($fsprgEx)) {
            throw $fsprgEx;
        }

        return $sub;
    }

    public function updateSubscription($subscriptionUpdate) {
        $url = $this->getSubscriptionUrl($subscriptionUpdate->reference);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $subscriptionUpdate->toXML());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        // turn ssl certificate verification off, i get http response 0 otherwise
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            set_error_handler("domDocumentErrorHandler");

            try {
                $doc = new \DOMDocument();
                $doc->loadXML($response);

                $sub = $this->parseFsprgSubscription($doc);
            } catch(\Exception $e) {
                $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service ".$info["http_code"], 0, $e);
                $fsprgEx->httpStatusCode = $info["http_code"];
            }

            restore_error_handler();
        } else {
            $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service " .$info["http_code"]);
            $fsprgEx->httpStatusCode = $info["http_code"];
        }

        curl_close($ch);

        if (isset($fsprgEx)) {
            throw $fsprgEx;
        }

        return $sub;
    }

    public function cancelSubscription($subscription_ref) {
        $url = $this->getSubscriptionUrl($subscription_ref);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        // turn ssl certificate verification off, i get http response 0 otherwise
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        dd($response);

        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            set_error_handler("domDocumentErrorHandler");

            try {
                $doc = new \DOMDocument();
                $doc->loadXML($response);

                $sub = $this->parseFsprgSubscription($doc);

                $subResp->subscription = $sub;
            } catch(\Exception $e) {
                $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service", 0, $e);
                $fsprgEx->httpStatusCode = $info["http_code"];
            }

            restore_error_handler();
        } else {
            $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service");
            $fsprgEx->httpStatusCode = $info["http_code"];
        }

        curl_close($ch);

        if (isset($fsprgEx)) {
            throw $fsprgEx;
        }

        return $subResp;
    }

    public function renewSubscription($subscription_ref) {
        $url = $this->getSubscriptionUrl($subscription_ref."/renew");

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, $this->api_username . ":" . $this->api_password);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // turn ssl certificate verification off, i get http response 0 otherwise
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] != 201) {
            $fsprgEx = new FsprgException("An error occurred calling the FastSpring subscription service");
            $fsprgEx->httpStatusCode = $info["http_code"];
            $fsprgEx->errorCode = $response;
        }

        curl_close($ch);

        if (isset($fsprgEx)) {
            throw $fsprgEx;
        }
    }

    private function getSubscriptionUrl($subscription_ref) {
        $url = "https://api.fastspring.com/company/".$this->company_id."/subscription/".$subscription_ref;

        $url = $this->addTestMode($url);

        return $url;
    }

    private function addTestMode($url) {
        if ($this->test_mode) {
            if (strpos($url, '?') != false) {
                $url = $url . "&mode=test";
            } else {
                $url = $url . "?mode=test";
            }
        }

        return $url;
    }

    private function parseFsprgSubscription($doc) {
        $sub = new FsprgSubscription();

        $sub->status = $doc->getElementsByTagName("status")->item(0)->nodeValue;
        $sub->statusChanged = strtotime($doc->getElementsByTagName("statusChanged")->item(0)->nodeValue);
        $sub->statusReason = $doc->getElementsByTagName("statusReason")->item(0)->nodeValue;
        $sub->cancelable = $doc->getElementsByTagName("cancelable")->item(0)->nodeValue;
        $sub->reference = $doc->getElementsByTagName("reference")->item(0)->nodeValue;
        $sub->test = $doc->getElementsByTagName("test")->item(0)->nodeValue;

        $customer = new FsprgCustomer();

        $customer->firstName = $doc->getElementsByTagName("firstName")->item(0)->nodeValue;
        $customer->lastName = $doc->getElementsByTagName("lastName")->item(0)->nodeValue;
        $customer->company = $doc->getElementsByTagName("company")->item(0)->nodeValue;
        $customer->email = $doc->getElementsByTagName("email")->item(0)->nodeValue;
        $customer->phoneNumber = $doc->getElementsByTagName("phoneNumber")->item(0)->nodeValue;

        $sub->customer = $customer;

        $sub->customerUrl = $doc->getElementsByTagName("customerUrl")->item(0)->nodeValue;
        $sub->productName = $doc->getElementsByTagName("productName")->item(0)->nodeValue;
        $sub->tags = $doc->getElementsByTagName("tags")->item(0)->nodeValue;
        $sub->quantity = $doc->getElementsByTagName("quantity")->item(0)->nodeValue;
        $sub->nextPeriodDate = strtotime($doc->getElementsByTagName("nextPeriodDate")->item(0)->nodeValue);
        $sub->end = strtotime($doc->getElementsByTagName("end")->item(0)->nodeValue);

        return $sub;
    }
}

class FsprgSubscription {
    public $status;
    public $statusChanged;
    public $statusReason;
    public $cancelable;
    public $reference;
    public $test;
    public $customer;
    public $customerUrl;
    public $productName;
    public $tags;
    public $quantity;
}

class FsprgCustomer {
    public $firstName;
    public $lastName;
    public $company;
    public $email;
    public $phoneNumber;
}

class FsprgSubscriptionUpdate {
    public $reference;
    public $productPath;
    public $quantity;
    public $tags;
    public $noEndDate;
    public $coupon;
    public $discountDuration;
    public $proration;

    public function __construct($subscription_ref) {
        $this->reference = $subscription_ref;
    }

    public function toXML() {
        $xmlResult = new \SimpleXMLElement("<subscription></subscription>");

        if ($this->productPath) {
            $xmlResult->productPath = $this->productPath;
        }
        if ($this->quantity) {
            $xmlResult->quantity = $this->quantity;
        }
        if ($this->tags) {
            $xmlResult->tags = $this->tags;
        }
        if (isset($this->noEndDate) && $this->noEndDate) {
            $xmlResult->addChild("no-end-date", null);
        }
        if ($this->coupon) {
            $xmlResult->coupon = $this->coupon;
        }
        if ($this->discountDuration) {
            $xmlResult->addChild("discount-duration", $this->discountDuration);
        }
        if (isset($this->proration)) {
            if ($this->proration) {
                $xmlResult->proration = "true";
            } else {
                $xmlResult->proration = "false";
            }
        }

        return $xmlResult->asXML();
    }
}

class FsprgException extends \Exception {
    public $httpStatusCode;
    public $errorCode;
}
