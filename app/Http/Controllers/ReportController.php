<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Traits\Tools;

class ReportController extends Controller
{
    use ApiResponse, Tools;

    public function SEOData($lead_id)
    {
        $keys = [
            "title_tas" => "titleTagChecker", // 
            "all_header_tags" => "getAllHeaderTags",
            "keyword_density_consistency" => "getKeywordDensity",
            "ip_address_canonicalization" => "checkIpCanonicalization",
            "meta_keywords" => "metaDescriptionChecker", //
            "meta_description" => "",
            "text_html_ration" => "",
            "gzip_compression" => "",
            "xml_sitemap" => "checkSitemapExistence",
            "robots_txt" => "checkRoboteTxt",
            "underscores_in_urls" => "",
            "embedded_objects" => "",
            "www_resolve" => "",
            "url_rewrite" => "",
            "iframe" => "",
            "image_alt" => "",
            "domain_details" => "",
        ];
        try {
            $lead = Lead::where('user_id', request()->user()->id)->where('id', $lead_id)->first();
            if ($lead) {
                $this->titleTagChecker($lead->website);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    public function usability($lead_id) {}

    public function performance($lead_id) {}

    public function technology($lead_id) {}

    public function socialMedia($lead_id) {}

    public function linkAnalysis($lead_id) {}
}
