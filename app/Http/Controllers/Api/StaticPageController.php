<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Get SEO data for a specific static page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSeoData(Request $request)
    {
        $slug = $request->route('slug');

        $page = StaticPage::where('slug', $slug)->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
                'og_title' => $page->og_title,
                'og_description' => $page->og_description,
                'og_image' => $page->og_image ? url($page->og_image) : null,
                'canonical_url' => $page->canonical_url,
                'no_index' => !(bool)$page->index_page,
                'no_follow' => !(bool)$page->follow_links,
                'structured_data' => $page->structured_data,
            ],
        ]);
    }
}
