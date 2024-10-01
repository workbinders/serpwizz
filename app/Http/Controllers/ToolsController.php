<?php

namespace App\Http\Controllers;


use DOMXPath;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ToolRequest;
use App\Traits\ApiResponse;
use App\Traits\Tools;
use App\Services\whois;
use DOMDocument;

class ToolsController extends Controller
{
    use ApiResponse, Tools;

    // Title tag checker
    public function titleTeg(ToolRequest $request)
    {
        try {
            $website = $request->input('website');

            $host = $this->getHost($website);
            $html = $this->getHTML($website);

            $title = $html->getElementsByTagName('title')->item(0)->textContent;

            $message = "We couldn't find a title tag! 🛠️";
            if ($title != '') {
                $titleLength = strlen($title);
                if ($titleLength > config('serpwizz.title_tag.max_length')) {
                    $message = "Your title tag looks like it's $titleLength characters - consider making it a little smaller!  🔍.";
                } else if ($titleLength >= config('serpwizz.title_tag.min_length') && $titleLength <= config('serpwizz.title_tag.max_length')) {
                    $message = "Your title tag looks like it's working, correct and in place - awesome stuff 😊.";
                } else if ($titleLength < config('serpwizz.title_tag.min_length')) {
                    $message = "Your title tag looks like it's only $titleLength characters - consider making it a little longer!  🔍.";
                }
            }

            return $this->sendResponse('', [
                'host' => $host,
                'title' => $title,
                'message' => $message,
                'min_length' => config('serpwizz.title_tag.min_length'),
                'max_length' => config('serpwizz.title_tag.max_length'),
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Meta Description checker
    public function metaDescription(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $xpath = new DOMXPath($html);
            $descriptionNode = $xpath->query('//meta[@name="description"]/@content');
            $description = $descriptionNode->length > 0 ? $descriptionNode->item(0)->nodeValue : '';

            $message = "We couldn't find a meta description! See our tool tip for advice on why this matters 🛠️.";
            if ($description != '') {
                $descriptionLength = strlen($description);
                if ($descriptionLength >= config('serpwizz.meta_description.min_length') && $descriptionLength <= config('serpwizz.meta_description.min_length')) {
                    $message = "You have a meta description, and its the perfect length! The search engines bots will be delighted 😊";
                } else if ($descriptionLength > 0) {
                    $message = "You've got a meta description, but it's not quite the right length for Google. See our tool tip for advice on why this matters 🔍.";
                }
            }

            return $this->sendResponse('', [
                'host' => $host,
                'description' => $description,
                'message' => $message,
                'min_length' => config('serpwizz.meta_description.min_length'),
                'max_length' => config('serpwizz.meta_description.max_length'),
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Meta Keywords checker
    public function metaKeyword(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $xpath = new DOMXPath($html);
            $keywordNode = $xpath->query('//meta[@name="keywords"]/@content');
            $keyword = $keywordNode && $keywordNode->length > 0 ? $keywordNode->item(0)->nodeValue : '';

            $message = 'You need relevant keywords in your metadata if you want to improve your SEO ranking! See our tool tip for advice about how to do this 🛠️.';
            if ($keyword != '') {
                $keywordLength = strlen($keyword);
                if ($keywordLength >= config('serpwizz.meta_keyword.min_length') && $keywordLength <= config('serpwizz.meta_keyword.min_length')) {
                    $message = "Your keywords are extensive, relevant and working hard to get you ranked 😊.</div>";
                } else if ($keywordLength < config('serpwizz.meta_keyword.min_length')) {
                    $message = "We've found some keywords, but the list could be bigger. Are you sure that's all you're targeting? See our tool tip for advice on why this matters 🔍.</div>";
                } else if ($keywordLength > config('serpwizz.meta_keyword.max_length')) {
                    $message = "We've found some keywords, but the list should be smaller 🔍.</div>";
                }
            }

            return $this->sendResponse('', [
                'host' => $host,
                'keyword' => $keyword,
                'message' => $message,
                'min_length' => config('serpwizz.meta_keyword.min_length'),
                'max_length' => config('serpwizz.meta_keyword.max_length'),
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Header tags checker
    public function allHeaderTeg(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $headerTags = $this->getAllHeaderTags($html);

            $message = 'You need headers to improve readability and prevent bounce rates! See our tool tip for advice on why this matters 🛠️.';
            if (count($headerTags) > 0) {
                $h1headerTags = isset($headerTags['h1']);
                if ($h1headerTags) {
                    $message = "Your headers are looking good 😊.</div>";
                }
            }

            return $this->sendResponse('', [
                'host' => $host,
                'headers' => $headerTags,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Image Alt attribute checker
    public function allImageAltTag(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $dom = $this->getHTML($website);
            $xpath = new \DOMXPath($dom);
            $allImages = $xpath->query('//img');
            $missingAltImages = $xpath->query('//img[not(@alt) or @alt=""]');
            $totalImagesCount = $allImages->length;
            $missingAltImagesCount = $missingAltImages->length;
            $message = "Fantastic - all your images have Alt Tags 😊";
            if ($missingAltImagesCount > 0) {
                $message = "Only some of your images have Alt Tags. Make sure they all have one, so that Google can display them in relevant image searches! See our tool tip for advice on why this matters 🔍.";
            }

            return $this->sendResponse('', [
                'host' => $host,
                'message' => $message,
                'total_images_count' => $totalImagesCount,
                'missing_alt_images_count' => $missingAltImagesCount,
            ]);
            return $this->sendError();
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Keyword Density and Consistency Checker Tool
    public function keywordConsistency(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = Http::get($website);

            $keywordDensity = $this->getKeywordDensity($html, $website);

            $message = "Density Keyword Not Found";
            if (count($keywordDensity) > 0) {
                $message = "You've got quite a comprehensive keyword set! We recommend checking this frequently and adding new key words or phrases to keep your list optimized 😊.";
            }
            return $this->sendResponse('', [
                'keyword_density' => $keywordDensity,
                'message' => $message,
                'host' => $host,
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Text Ratio Checker Checker Tool
    public function textRatioChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);

            $document = Http::get($website);
            $HTML = $document->body();
            $textRatioArray = $this->getTextRatio($HTML);
            $textRatio = round($textRatioArray[2], 2);
            $contentSize = $textRatioArray[1];
            $htmlSize = $textRatioArray[0];
            $message = "Your text-to-HTML ratio needs an overhaul. Web pages with higher text content to HTML tend to be more readable and understandable for people - and keeps them coming back for more! See our tool tip for advice on why this matters 🛠️.";
            if ($textRatio < 20) {
                $message = "Your text-to-HTML ratio is excellent 😊.";
            }

            return $this->sendResponse('', [
                'host' => $host,
                'message' => $message,
                'text_ratio' => $textRatio,
                'content_size' => $contentSize,
                'html_size' => $htmlSize,
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // GZip Checker Tool
    public function GZipChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $website);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $response = curl_exec($ch);
            $compresedContentSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
            $uncompresedContentSize = strlen($body);
            curl_close($ch);

            $isGzip = $this->strContains($header, "gzip");

            $message = "Oh No! GZIP is not enabled";
            if ($isGzip) {
                $percentage = round(((((int)$uncompresedContentSize - (int)$compresedContentSize) / (int)$uncompresedContentSize) * 100), 1);
                $message = "We have found your GZIP Compression. Excellent work 😊.\n";
                $message .= "Your webpage has been compressed from " . $this->bytesToKB($uncompresedContentSize) . "KB to " . $this->bytesToKB($compresedContentSize) . "KB ( " . $percentage . "% size savings)";
            }
            return $this->sendResponse('', [
                'message' => $message,
                'host' => $host,
                'is_gzip' => $isGzip
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // IP Canonicalization Tools
    public function ipChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);

            $checkIpCanonicalization = $this->checkIpCanonicalization($host);
            $message = "We couldn't find any IP Canonicalization! Without this, your IP address and domain name might experience some redirection issues. See our tool tip for advice on why this matters 🛠️.";
            if ($checkIpCanonicalization) {
                $message = "We've found your IP Canonicalization. Great job 😊.";
            }
            return $this->sendResponse('', [
                'host' => $host,
                'is_ip_canonicalization' => $checkIpCanonicalization,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // XMLsiteMap checker
    public function XMLsiteMap(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $checkSitemapExistence = $this->checkSitemapExistence($host);
            $message = "We couldn't find your XML Sitemap! Without this, the search bots won't be able to crawl your site correctly for a content overview. See our tool tip for advice on why this matters 🛠️.";
            if ($checkSitemapExistence) {
                $message = "We've found your XML Sitemap - which means search bots will, as well 😊.";
            }
            return $this->sendResponse('', [
                'host' => $host,
                'is_sitemap_exist' => $checkSitemapExistence,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // XMLsiteMap checker
    public function embeddedObjectChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $dom = $this->getHTML($website);
            $xpath = new \DOMXPath($dom);

            $allObject = $xpath->query('//object');
            $allEmbed = $xpath->query('//embed');
            $is_embedded_object_found = false;
            $message = "Perfect! We haven’t found any embedded objects on your website. This is good news for your page load times 😊.";
            if ($allObject->length > 0 || $allEmbed->length > 0) {
                $is_embedded_object_found = true;
                $message = "We’ve found (X) embedded objects on your website. See our tool tip about how this could impact your overall performance 🛠️.";
            }

            return $this->sendResponse('', [
                'host' => $host,
                'message' => $message,
                'is_embedded_object_found' => $is_embedded_object_found
            ]);
            return $this->sendError();
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Robots Txt checker
    public function robotsTxt(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $checkRoboteTxt = $this->checkRoboteTxt($host);

            $message = "We couldn't find your Robots.txt file! Without one, your site might get overrun with requests and struggle with response times. See our tool tip for advice on why this matters 🛠️.";
            if ($checkRoboteTxt) {
                $message = "Nice! We've found your Robots.txt file 😊.";
            }


            return $this->sendResponse('', [
                'host' => $host,
                'is_robots_txt_exist' => $checkRoboteTxt,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Domain Age Checker
    public function domainAgeChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $whois = new whois();
            $site = $whois->cleanUrl($website);  // domain
            $whois_data = $whois->whoislookup($site);
            // $whoisRaw = $whois_data[0];
            $domainAge = $whois_data[1];
            $createdDate = $whois_data[2];
            $updatedDate = $whois_data[3];
            $expiredDate = $whois_data[4];


            return $this->sendResponse('', [
                'host' => $host,
                'domain_age' => $domainAge,
                'created_date' => $createdDate,
                'updated_date' => $updatedDate,
                'expired_date' => $expiredDate,
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Favicon Checker
    public function faviconChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $favicon = $this->checkFavicon($html);
            $message = 'You need headers to specified a favicon. ';
            if ($favicon != false) {
                $message = 'Your page has specified a favicon.';
            }
            return $this->sendResponse('', [
                'host' => $host,
                'favicon' => $favicon,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Error Page Checker
    public function errorPageChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = Http::get($website . "/thispagedoesnotexist");
            $errorPage = $this->errorPage($html);

            $message = 'Your website has no custom 404 error page.';
            if ($errorPage == true) {
                $message = 'Great, your website has a custom 404 error page.';
            }
            return $this->sendResponse('', [
                'host' => $host,
                'errorPage' => $errorPage,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    //htaccess Checker
    public function htaccessChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $client = new Client();
            $host = $this->getHost($website);
            $getHttpCode = $client->request('GET', $website);
            if ($getHttpCode) {
                return $this->sendResponse('', [
                    'host'    => $host,
                    'httpCode' => $getHttpCode->getStatusCode(),
                ]);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    //Page Size Checker
    public function pageSizeChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $client = new Client();
            $response = $client->request('GET', $website);
            $body = $response->getBody()->getContents();
            $size = round(strlen($body) / 1024);
            $host = $this->getHost($website);

            return $this->sendResponse('', [
                'host' => $host,
                'size' =>  $size,
                'max_size' => 320,
                'message' => "<h5>$size KB (World Wide Web average is 320 KB)</h5>"
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Email Privacy Checker
    public function emailPrivacy(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $htmlContent = Http::get($website)->body();
            $host = $this->getHost($website);
            $emailPattern = '/[a-z0-9-_%+-]+@[a-z0-9.-]+\.[a-z]{2,4}\b/i';
            $emailFound = preg_match($emailPattern, $htmlContent);

            $message = "Good, no email address has been found in plain text.";
            if ($emailFound) {
                $message = "Email address has been found in plain text!";
            }
            return $this->sendResponse('', [
                'message' => $message,
                'host' => $host,
                'emailFound' => $emailFound
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    //URL Rewrite Checker
    public function urlRewriteChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $isURLRewrite = $this->isURLRewrite($html, $host);

            $message = "Warning! We have detected parameters in a massive number of URLs";
            if ($isURLRewrite == true) {
                $message = "Good, all URLs look clean and friendly";
            }
            return $this->sendResponse('', [
                'message' => $message,
                'host' => $host,
                'isURLRewrite' => $isURLRewrite
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile() . " Line #" . $th->getLine(), $th);
        }
    }

    //URL Underscore Checker
    public function urlUnderscoreChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $hasUnderscore = $this->URLHasUnderscore($html, $host);

            $message = "Great, you are not using underscores (these_are_underscores) in your URLs";
            if ($hasUnderscore == true) {
                $message = "Oh no, you are using underscores (these_are_underscores) in your URLs";
            }
            return $this->sendResponse('', [
                'message' => $message,
                'host' => $host,
                'hasUnderscore' => $hasUnderscore
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile() . " Line #" . $th->getLine(), $th);
        }
    }

    //Link Analysis
    public function linkAnalysisChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $links = $this->linkAnalysis($html, $host, $website);

            $message = "We found a total of " . count($links) . " links including both internal & external links of your site";

            return $this->sendResponse('', [
                'message' => $message,
                'host' => $host,
                'links' => $links
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile() . " Line #" . $th->getLine(), $th);
        }
    }

    //Iframe Checker
    public function iframeChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $html = $this->getHTML($website);
            $hasIFrame = $this->hasIFrame($html);
            $message = 'Oh no, iframe content has been detected on this page';
            if ($hasIFrame === false) {
                $message = 'Perfect, no Iframe content has been detected on this page';
            }
            return $this->sendResponse('', [
                'host' => $host,
                'hasIFrame' => $hasIFrame,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    // Domain Age Checker
    public function whoisDataChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $whois = new whois();
            $site = $whois->cleanUrl($website);  // domain
            $whois_data = $whois->whoislookup($site);
            $whoisRaw = $whois_data[0];
            $domainAge = $whois_data[1];
            $createdDate = $whois_data[2];
            $updatedDate = $whois_data[3];
            $expiredDate = $whois_data[4];

            $whoisLines = preg_split("/\r\n|\n|\r/", $whoisRaw);
            $filteredWhoisData = [];

            foreach ($whoisLines as $line) {
                $line = trim($line);

                if (!empty($line)) {
                    if (strpos($line, 'DNSSEC') !== false) {
                        break;
                    }
                    if (
                        strpos($line, 'Domain Status') !== false ||
                        strpos($line, 'Registrant Email') !== false ||
                        strpos($line, 'Admin Email') !== false ||
                        strpos($line, 'Tech Email') !== false
                    ) {
                        continue;
                    }

                    $filteredWhoisData[] = htmlspecialchars($line);
                }
            }

            return $this->sendResponse('', [
                'host' => $host,
                'whois_data' => $filteredWhoisData,
                'domain_age' => $domainAge,
                'created_date' => $createdDate,
                'updated_date' => $updatedDate,
                'expired_date' => $expiredDate,
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function indexedPageChecker(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $googleIndexedPagesCount = $this->getGoogleIndexedPagesCount($host, "site");
            return $this->sendResponse('', [
                'host' => $host,
                'google_indexed_pages_count' => $googleIndexedPagesCount,
                'message' => "$googleIndexedPagesCount Indexed pages in search engines",
                'google_backlink_count_status' => config('serpwizz.google_backlink_count_status')
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile() . " Line # " . $th->getLine(), $th);
        }
    }


    public function backlinksCounter(ToolRequest $request)
    {
        try {
            $website = $request->input('website');
            $host = $this->getHost($website);
            $googleBacklinkCount = $this->getGoogleIndexedPagesCount($host, "inurl");
            return $this->sendResponse('', [
                'host' => $host,
                'google_backlink_count' => $googleBacklinkCount,
                'message' => "Number of backlinks pointing to your website: $googleBacklinkCount",
                'google_backlink_count_status' => config('serpwizz.google_backlink_count_status')
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }


    // Helper function
    protected function fetchContent($website)
    {
        $response = Http::get($website);

        if ($response->successful()) {
            return $response->body();
        } else {
            return false;
        }
    }

    protected function getHost($url)
    {

        $parserUrl = parse_url($url);
        $host = $parserUrl['host'];
        return $host;
    }
}
