<?php

namespace App\Http\Controllers;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\Product;
use Mail;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		// get currency exchange rate
		$convRate = 3597846.35310000; // set 1 as default value
		// $apiURL = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=BTC&to_currency=INR&apikey=YZNKPWNW4IQYQTWC";
		// $guzzClient = new GuzzleClient();
		// $res = $guzzClient->request('GET', $apiURL);
		// if ($res->getStatusCode() == 200){
		// 	$body = $res->getBody();
		// 	$jsonData = json_decode($body, true);
		// 	if (array_key_exists("Realtime Currency Exchange Rate", $jsonData))
		// 		if (array_key_exists("5. Exchange Rate", $jsonData["Realtime Currency Exchange Rate"]))
		// 			$convRate = $jsonData["Realtime Currency Exchange Rate"]["5. Exchange Rate"];
		// }

		$products = Product::all();
		return view('index', compact("convRate", "products"));
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function scrap() {
		// get notify email
		$notifyEmail = env("NOTIFICATION_EMAIL");

		// fetch products from flipkart
		$client = new Client();
		$count = 0;
		$page = 1;
		while ($count < 100) {
			$crawler = $client->request('GET', 'https://www.flipkart.com/all/pr?sid=all&page='.$page);
			$crawler->filter('._13oc-S')->each(function ($node) use (&$count, $notifyEmail){
				$node->children()->each(function ($prod) use (&$count, $notifyEmail){

					// stop when count reaches 100
					if ($count >= 100)
						return;

					// id
					$product_id = $prod->attr("data-id");

					// image
					$imageElem = $prod->filter('div > a > div > div > div > img');
					$image = "";
					if (count($imageElem) > 0)
						$image = $imageElem->attr("src");

					// title
					$titleElem = $prod->filter('.s1Q9rs');
					$title = "";
					if (count($titleElem) > 0)
						$title = $titleElem->text();

					// variant
					$variantElem = $prod->filter('._3Djpdu');
					$variant = "";
					if (count($variantElem) > 0)
						$variant = $variantElem->text();

					// rating
					$ratingElem = $prod->filter('._3LWZlK');
					$rating = "";
					if (count($ratingElem) > 0)
						$rating = $ratingElem->text();

					// store price
					$storePriceElem = $prod->filter('._30jeq3');
					$storePrice = "";
					if (count($storePriceElem) > 0)
						$storePrice = str_replace(",","",trim($storePriceElem->text(), "₹"));

					// original price
					$origPriceElem = $prod->filter('._3I9_wc');
					$origPrice = "";
					if (count($origPriceElem) > 0)
						$origPrice =  str_replace(",","",trim($origPriceElem->text(), "₹"));

					$product = Product::where('product_id', $product_id)->first();
					if ($product) { // already exists
						if ($notifyEmail) { // check notify email is set
							if ($product->store_price != $storePrice) {
								// send mail
								Mail::send('emails.notify', compact("product", "storePrice"), function ($m) use ($notifyEmail) {
									$m->from('no-reply@app.com', 'Ecom Scrap');
									$m->to($notifyEmail)->subject('Price Update Notification!');
								});

								print ("send email ".$product_id);
							}
						}
					}
					else
						$product = new Product;
					$product->product_id = $product_id;
					$product->title = $title;
					$product->image = $image;
					$product->variant = $variant;
					if ($rating != "")
						$product->rating = $rating;
					if ($storePrice != "")
						$product->store_price = $storePrice;
					if ($origPrice != "")
						$product->original_price = $origPrice;
					else
						$product->original_price = $product->store_price;
					$product->save();

					$count++;
				});
			});
			$page++;
		}
		return redirect("/");
	}

}
