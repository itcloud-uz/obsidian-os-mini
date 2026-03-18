<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['portfolioImages', 'services', 'links', 'testimonials', 'faqs'])
            ->where('user_id', Auth::id())
            ->get();
            
        $formatted = [];
        foreach($projects as $p) {
            $formatted[$p->slug] = [
                'companyName' => $p->company_name,
                'subtitle' => $p->subtitle,
                'logoUrl' => $p->logo_url,
                'theme' => $p->theme,
                'seoDesc' => $p->seo_desc,
                'seoKeywords' => $p->seo_keywords,
                'tgToken' => $p->tg_token,
                'tgChatId' => $p->tg_chat_id,
                'views' => $p->views,
                'clicks' => $p->clicks,
                'portfolio' => $p->portfolioImages->pluck('url')->toArray(),
                'services' => $p->services->toArray(),
                'links' => $p->links->toArray(),
                'testimonials' => $p->testimonials->toArray(),
                'faqs' => $p->faqs->toArray()
            ];
        }
            
        return response()->json($formatted);
    }

    public function store(Request $request, $slug)
    {
        DB::beginTransaction();
        try {
            $data = [
                'company_name' => $request->companyName,
                'subtitle' => $request->subtitle,
                'logo_url' => $request->logoUrl,
                'theme' => $request->theme,
                'seo_desc' => $request->seoDesc,
                'seo_keywords' => $request->seoKeywords,
                'tg_token' => $request->tgToken,
                'tg_chat_id' => $request->tgChatId,
            ];

            $project = Project::updateOrCreate(
                ['slug' => $slug, 'user_id' => Auth::id()],
                $data
            );
            
            $project->portfolioImages()->delete();
            if ($request->has('portfolio')) {
                foreach ($request->portfolio as $url) {
                    $project->portfolioImages()->create(['url' => $url]);
                }
            }
            
            $project->services()->delete();
            if ($request->has('services')) {
                foreach ($request->services as $service) {
                    $project->services()->create($service);
                }
            }
            
            $project->links()->delete();
            if ($request->has('links')) {
                foreach ($request->links as $link) {
                    $project->links()->create($link);
                }
            }
            
            $project->testimonials()->delete();
            if ($request->has('testimonials')) {
                foreach ($request->testimonials as $t) {
                    $project->testimonials()->create($t);
                }
            }
            
            $project->faqs()->delete();
            if ($request->has('faqs')) {
                foreach ($request->faqs as $f) {
                    $project->faqs()->create($f);
                }
            }
            
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($slug)
    {
        Project::where('slug', $slug)->where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);
        $path = $request->file('file')->store('public/uploads');
        $url = asset(str_replace('public', 'storage', $path));
        return response()->json(['url' => $url]);
    }
}
