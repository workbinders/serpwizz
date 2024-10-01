<?php

namespace App\Traits;

use App\Services\HTML2Text;
use DOMDocument;
use Illuminate\Support\Facades\Http;

trait Tools
{
    protected function getHTML($url)
    {
        $document = Http::get($url);
        $dom = $this->htmlToDom($document);
        return $dom;
    }

    protected function htmlToDom($document)
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($document->body());
        libxml_clear_errors();
        return $dom;
    }

    protected function getAllHeaderTags($html)
    {
        $xpath = new \DOMXPath($html);
        $headerTags = [];

        $headerTagsArray = $xpath->query('//h1 | //h2 | //h3 | //h4 | //h5 | //h6');

        foreach ($headerTagsArray as $header) {
            $headerText = strip_tags($header->textContent);
            $headerTags[$header->nodeName][] =  trim($headerText);
        }
        return $headerTags;
    }

    protected function getKeywordDensity($content, $url, $maxKeywords = 15)
    {
        $HTML2Text = new HTML2Text($content);
        $html = $HTML2Text->getText();
        $html = html_entity_decode(strtolower($html));
        $html = preg_replace('/[^a-zA-Z0-9\s]/', '', $html);
        $words = explode(" ", $html);

        $stopWords = array('and', 'is', 'was', 'to', 'the', 'are', 'its', 'our', 'all', 'more', 'into', 'new', 'for', 'with', 'will', 'without', 'than', 'they', 'then', 'that', 'these', 'this', 'their', 'them', 'from', 'your', 'able', 'which', 'when', 'what', 'who');
        $words = array_diff($words, $stopWords);

        // Get the total number of words
        $totalWords = count($words);

        // Create an associative array to store word frequencies
        $wordFrequency = array();

        // Count occurrences of each word
        foreach ($words as $word) {
            if (strlen($word) > 3) {  // Only count words with more than 2 characters
                if (isset($wordFrequency[$word])) {
                    $wordFrequency[$word]++;
                } else {
                    $wordFrequency[$word] = 1;
                }
            }
        }

        // Sort by frequency, highest first
        arsort($wordFrequency);

        // Limit to maxKeywords (e.g., top 15)
        $topKeywords = array_slice($wordFrequency, 0, $maxKeywords, true);


        $dom = $this->htmlToDom($content);

        // Get all heagin tags from DOM
        $headerTags = $this->getAllHeaderTags($dom);
        $headerTags = array_merge(...array_values($headerTags));
        $headerTags = implode(' ', $headerTags);
        $headerTags = strtolower($headerTags);
        $headerTags = preg_split('/\s+/', $headerTags);

        // Get title of the from the URL
        $docuemntTitle = $dom->getElementsByTagName('title')->item(0)->textContent;
        $docuemntTitle = strtolower($docuemntTitle);
        $docuemntTitle = preg_split('/\s+/', $docuemntTitle);

        // Get Meta description of the from the URL
        $xpath = new \DOMXPath($dom);
        $metaDescription = $xpath->query('//meta[@name="description"]/@content');
        $metaDescription = $metaDescription->length > 0 ? $metaDescription->item(0)->nodeValue : '';
        $metaDescription = strtolower($metaDescription);
        $metaDescription = preg_split('/\s+/', $metaDescription);

        // Calculate keyword density
        $keywordDensity = array();
        foreach ($topKeywords as $keyword => $count) {
            $density = ($count / $totalWords) * 100;
            $keywordDensity[$keyword] = array(
                'count' => $count,
                'density' => round($density, 2) . '%',
                'in_document_title' => in_array($keyword, $docuemntTitle),
                'in_meta_description' => in_array($keyword, $metaDescription),
                'in_heading_tags' => in_array($keyword, $headerTags),
            );
        }

        return $keywordDensity;
    }

    protected function checkIpCanonicalization($domain)
    {
        $domainIP = gethostbyname($domain);
        $ipUrl = "http://$domainIP";

        $curlExecution = $this->curlExecution($ipUrl, [
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_NOBODY => true,
        ]);

        // Check for redirection (3xx status codes)
        if (in_array($curlExecution['httpCode'], [301, 302, 307, 308])) {
            // Get the "Location" header to see where it redirects to
            preg_match('/Location:\s*(.*)/i', $curlExecution['response'], $matches);
            $redirectLocation = !empty($matches[1]) ? trim($matches[1]) : '';

            if (strpos($redirectLocation, $domain) !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

        curl_close($curl);
    }

    protected function checkSitemapExistence($domain)
    {
        $sitemapURL = "http://$domain/sitemap.xml";

        $curlExecution = $this->curlExecution($sitemapURL, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_NOBODY => true,
        ]);

        if (in_array($curlExecution['httpCode'], [200, 301, 302])) {
            return true;
        } else {
            $sitemapURL = "http://$domain/sitemap_index.xml";
            $curlExecution = $this->curlExecution($sitemapURL, [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_NOBODY => true,
            ]);
            if (in_array($curlExecution['httpCode'], [200, 301, 302])) {
                return true;
            }
            return false;
        }
    }

    protected function checkRoboteTxt($domain)
    {
        $sitemapURL = "http://$domain/robots.txt";

        $curlExecution = $this->curlExecution($sitemapURL, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_NOBODY => true,
        ]);

        if ($curlExecution['httpCode'] == 200) {
            return true;
        }
        return false;
    }

    protected function checkFavicon($html)
    {
        $xpath = new \DOMXPath($html);

        $faviconTags = $xpath->query('//link[@rel="shortcut icon" or @rel="icon"]');

        if ($faviconTags->length > 0) {
            // Favicon found
            foreach ($faviconTags as $faviconTag) {
                if ($faviconTag instanceof \DOMElement) {
                    $faviconUrl = $faviconTag->getAttribute('href');
                    return $faviconUrl;
                }
            }
        }
        return false;
    }

    protected function errorPage($html)
    {
        $pageSize = strlen($html);
        if ($pageSize < 1500) {
            return false;
        }
        return true;
    }

    function isURLRewrite($html, $host)
    {
        $webFormats = config('serpwizz.web_formats');
        $xpath = new \DOMXPath($html);
        $hrefs = $xpath->query("//a[@href]");
        $uniqueHrefs = [];
        if ($hrefs->length > 0) {
            foreach ($hrefs as $hrefNode) {
                if ($hrefNode instanceof \DOMElement) {
                    $href = $hrefNode->getAttribute('href');
                    if ($this->isInternalLink($href, $host)) {
                        if (!in_array($href, $uniqueHrefs)) {
                            $uniqueHrefs[] = $href;
                            $parsedUrl = parse_url($href);
                            $path = $parsedUrl['path'] ?? '';
                            $extension = pathinfo($path, PATHINFO_EXTENSION);
                            if ($extension && in_array($extension, $webFormats)) {
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    function URLHasUnderscore($html, $host)
    {
        $xpath = new \DOMXPath($html);
        $hrefs = $xpath->query("//a[@href]");
        if ($hrefs->length > 0) {
            foreach ($hrefs as $hrefNode) {
                if ($hrefNode instanceof \DOMElement) {
                    $href = $hrefNode->getAttribute('href');
                    if ($this->isInternalLink($href, $host)) {
                        if (mb_strpos($href, "_") !== false) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    function linkAnalysis($html, $host, $website)
    {
        $xpath = new \DOMXPath($html);
        $hrefs = $xpath->query("//a[@href]");
        $linkData = [];
        if ($hrefs->length > 0) {
            foreach ($hrefs as $hrefNode) {
                if ($hrefNode instanceof \DOMElement) {
                    $href = $hrefNode->getAttribute('href');

                    if (stripos($href, 'javascript:') === 0 || stripos($href, '#') === 0) {
                        continue;
                    }

                    if (!preg_match('/^(https?:\/\/|\/\/|mailto:|tel:)/i', $href)) {
                        // Prepend the base URL to the relative link
                        $href = rtrim($website, '/') . '/' . ltrim($href, '/');
                    }

                    $linkText = trim($hrefNode->textContent);
                    $rel = $hrefNode->getAttribute('rel') ?: 'Dofollow';
                    $isInternal = $this->isInternalLink($href, $host);
                    $linkType = $isInternal ? 'Internal Link' : 'External Link';

                    $linkData[] = [
                        'href' => $href,
                        'text' => $linkText,
                        'type' => $linkType,
                        'follow_type' => $rel,
                    ];
                }
            }
        }
        return $linkData;
    }

    protected function hasIFrame($html)
    {
        $xpath = new \DOMXPath($html);
        $iframeTags = $xpath->query('//iframe');

        if ($iframeTags->length > 0) {
            return true;
        }
        return false;
    }

    protected function getGoogleIndexedPagesCount($host, $query)
    {
        $encodedQuery = urlencode("$query:$host");

        $googleDomains = [
            'google.com',
            'google.ad',
            'google.ae',
            'google.com.af',
            'google.com.ag',
            'google.com.ai',
            'google.al',
            'google.am',
            'google.co.ao',
            'google.com.ar',
            'google.as',
            'google.at',
            'google.com.au',
            'google.az',
            'google.ba',
            'google.com.bd',
            'google.be',
            'google.bf',
            'google.bg',
            'google.com.bh',
            'google.bi',
            'google.bj',
            'google.com.bn',
            'google.com.bo',
            'google.com.br',
            'google.bs',
            'google.bt',
            'google.co.bw',
            'google.by',
            'google.com.bz',
            'google.ca',
            'google.cd',
            'google.cf',
            'google.cg',
            'google.ch',
            'google.ci',
            'google.co.ck',
            'google.cl',
            'google.cm',
            'google.cn',
            'google.com.co',
            'google.co.cr',
            'google.com.cu',
            'google.cv',
            'google.com.cy',
            'google.cz',
            'google.de',
            'google.dj',
            'google.dk',
            'google.dm',
            'google.com.do',
            'google.dz',
            'google.com.ec',
            'google.ee',
            'google.com.eg',
            'google.es',
            'google.com.et',
            'google.fi',
            'google.com.fj',
            'google.fm',
            'google.fr',
            'google.ga',
            'google.ge',
            'google.gg',
            'google.com.gh',
            'google.com.gi',
            'google.gl',
            'google.gm',
            'google.gp',
            'google.gr',
            'google.com.gt',
            'google.gy',
            'google.com.hk',
            'google.hn',
            'google.hr',
            'google.ht',
            'google.hu',
            'google.co.id',
            'google.ie',
            'google.co.il',
            'google.im',
            'google.co.in',
            'google.iq',
            'google.is',
            'google.it',
            'google.je',
            'google.com.jm',
            'google.jo',
            'google.co.jp',
            'google.co.ke',
            'google.com.kh',
            'google.ki',
            'google.kg',
            'google.co.kr',
            'google.com.kw',
            'google.kz',
            'google.la',
            'google.com.lb',
            'google.li',
            'google.lk',
            'google.co.ls',
            'google.lt',
            'google.lu',
            'google.lv',
            'google.com.ly',
            'google.co.ma',
            'google.md',
            'google.me',
            'google.mg',
            'google.mk',
            'google.ml',
            'google.com.mm',
            'google.mn',
            'google.ms',
            'google.com.mt',
            'google.mu',
            'google.mv',
            'google.mw',
            'google.com.mx',
            'google.com.my',
            'google.co.mz',
            'google.com.na',
            'google.com.nf',
            'google.com.ng',
            'google.com.ni',
            'google.ne',
            'google.nl',
            'google.no',
            'google.com.np',
            'google.nr',
            'google.nu',
            'google.co.nz',
            'google.com.om',
            'google.com.pa',
            'google.com.pe',
            'google.com.pg',
            'google.com.ph',
            'google.com.pk',
            'google.pl',
            'google.pn',
            'google.com.pr',
            'google.ps',
            'google.pt',
            'google.com.py',
            'google.com.qa',
            'google.ro',
            'google.ru',
            'google.rw',
            'google.com.sa',
            'google.com.sb',
            'google.sc',
            'google.se',
            'google.com.sg',
            'google.sh',
            'google.si',
            'google.sk',
            'google.com.sl',
            'google.sn',
            'google.so',
            'google.sm',
            'google.sr',
            'google.st',
            'google.com.sv',
            'google.td',
            'google.tg',
            'google.co.th',
            'google.com.tj',
            'google.tk',
            'google.tl',
            'google.tm',
            'google.tn',
            'google.to',
            'google.com.tr',
            'google.tt',
            'google.com.tw',
            'google.co.tz',
            'google.com.ua',
            'google.co.ug',
            'google.co.uk',
            'google.com.uy',
            'google.co.uz',
            'google.com.vc',
            'google.co.ve',
            'google.vg',
            'google.co.vi',
            'google.com.vn',
            'google.vu',
            'google.ws',
            'google.rs',
            'google.co.za',
            'google.co.zm',
            'google.co.zw',
            'google.cat'
        ];

        $randomGoogleDomain = $googleDomains[array_rand($googleDomains)];
        $googleSearchUrl = 'https://www.' . $randomGoogleDomain . '/search?hl=en&q=' . $encodedQuery;
        $pageContent = $this->curlExecution($googleSearchUrl);

        $regexPattern = '/About\s([\d,]+)\sresults/';
        preg_match($regexPattern, $pageContent['response'], $matches);

        if (!empty($matches) && isset($matches[1])) {
            $count = filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $count = 0;
        }

        return number_format($count ?: 0);
    }


    // Helpr functions
    function curlExecution($url, $curlOptions = [], $ref_url = "http://www.google.com/", $agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.4951.54 Safari/537.36")
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_REFERER, $ref_url);
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        if (count($curlOptions) > 0) {
            foreach ($curlOptions as $key => $value) {
                curl_setopt($curl, $key, $value);
            }
        }
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            dd($error_msg);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return ['httpCode' => $httpCode, 'response' => $response];
    }

    protected function getTextRatio($html)
    {
        $orglen = strlen($html);
        $html = preg_replace('/(<script.*?>.*?<\/script>|<style.*?>.*?<\/style>|<.*?>|\r|\n|\t)/ms', '', $html);
        $html = preg_replace('/ +/ms', ' ', $html);
        $textlen = strlen($html);
        $per = (($textlen * 100) / $orglen);
        return array($orglen, $textlen, $per);
    }

    protected function bytesToKB($bytes)
    {
        $size_kb = round($bytes / 1024);
        return $size_kb;
    }

    protected function strContains($data, $searchString, $ignoreCase = false)
    {
        if ($ignoreCase) {
            $data = strtolower($data);
            $searchString = strtolower($searchString);
        }
        $needlePos = strpos($data, $searchString);
        return ($needlePos === false ? false : ($needlePos + 1));
    }

    private function isInternalLink($href, $host)
    {
        $host = str_replace("www", "", $host);

        $parsedUrl = str_replace("www", "", parse_url($href));
        if (!isset($parsedUrl['host'])) {
            return true;
        }
        return strtolower($parsedUrl['host']) === strtolower($host);
    }
}
