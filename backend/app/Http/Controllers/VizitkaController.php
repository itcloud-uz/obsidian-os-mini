<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class VizitkaController extends Controller
{
    public function show($slug)
    {
        $project = Project::with(['portfolioImages', 'services', 'links', 'testimonials', 'faqs'])
            ->where('slug', $slug)->first();
            
        if (!$project) return response()->json(null, 404);
        
        $projectArray = [
            'companyName' => $project->company_name,
            'subtitle' => $project->subtitle,
            'logoUrl' => $project->logo_url,
            'theme' => $project->theme,
            'seoDesc' => $project->seo_desc,
            'seoKeywords' => $project->seo_keywords,
            'tgToken' => $project->tg_token,
            'tgChatId' => $project->tg_chat_id,
            'views' => $project->views,
            'clicks' => $project->clicks,
            'portfolio' => $project->portfolioImages->pluck('url')->toArray(),
            'services' => $project->services->toArray(),
            'links' => $project->links->toArray(),
            'testimonials' => $project->testimonials->toArray(),
            'faqs' => $project->faqs->toArray()
        ];
        
        return response()->json($projectArray);
    }

    public function incrementViews($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if ($project) {
            $project->increment('views');
            return response()->json(['success' => true]);
        }
        return response()->json(null, 404);
    }
    
    public function incrementClicks($slug)
    {
        $project = Project::where('slug', $slug)->first();
        if ($project) {
            $project->increment('clicks');
            return response()->json(['success' => true]);
        }
        return response()->json(null, 404);
    }
}
