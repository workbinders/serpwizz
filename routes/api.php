<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReportTemplateController;
use App\Http\Controllers\ReportTemplateCustomSectionController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\WhiteLabelSettingsController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('account-active', [AuthController::class, 'accountActive']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::get('plans', [PlanController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logOut']);
        Route::post('profile-update', [AuthController::class, 'profileUpdate']);

        Route::apiResources([
            'auth-user' => AuthUserController::class,
            'white-label-settings' => WhiteLabelSettingsController::class,
            'report-templates'      => ReportTemplateController::class,
            'custom-sections' => ReportTemplateCustomSectionController::class,
        ]);

        // Tools API
        Route::prefix('tools')->group(function () {
            Route::post('title-tag-checker', [ToolsController::class, 'titleTeg']);
            Route::post('meta-description-checker', [ToolsController::class, 'metaDescription']);
            Route::post('meta-keyword-checker', [ToolsController::class, 'metaKeyword']);
            Route::post('all-header-tags-checker', [ToolsController::class, 'allHeaderTeg']);
            Route::post('image-alt-tags-checker', [ToolsController::class, 'allImageAltTag']);
            Route::post('keyword-density-consistency-checker', [ToolsController::class, 'keywordConsistency']);
            Route::post('html-text-ratio-checker', [ToolsController::class, 'textRatioChecker']);
            Route::post('gzip-compression-checker', [ToolsController::class, 'GZipChecker']);
            Route::post('ip-address-canonicalization-checker', [ToolsController::class, 'ipChecker']);
            Route::post('xml-sitemap-checker', [ToolsController::class, 'XMLsiteMap']);
            Route::post('robots-txt-checker', [ToolsController::class, 'robotsTxt']);
            Route::post('embedded-object-checker', [ToolsController::class, 'embeddedObjectChecker']);
            Route::post('domain-age-checker', [ToolsController::class, 'domainAgeChecker']);
            Route::post('favicon-checker', [ToolsController::class, 'faviconChecker']);
            Route::post('error-page-checker', [ToolsController::class, 'errorPageChecker']);
            Route::post('htaccess-redirect-checker', [ToolsController::class, 'htaccessChecker']);
            Route::post('page-size-checker', [ToolsController::class, 'pageSizeChecker']);
            Route::post('email-privacy-checker', [ToolsController::class, 'emailPrivacy']);
            Route::post('url-rewrite-checker', [ToolsController::class, 'urlRewriteChecker']);
            Route::post('underscore-url-checker', [ToolsController::class, 'urlUnderscoreChecker']);
            Route::post('link-analysis-checker', [ToolsController::class, 'linkAnalysisChecker']);
            Route::post('iframe-checker', [ToolsController::class, 'iframeChecker']);
            Route::post('whois-data-checker', [ToolsController::class, 'whoisDataChecker']);
            Route::post('indexed-page-checker', [ToolsController::class, 'indexedPageChecker']);
            Route::post('backlinks-counter', [ToolsController::class, 'backlinksCounter']);
        });
    });
});
