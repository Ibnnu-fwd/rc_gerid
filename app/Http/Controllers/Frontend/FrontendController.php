<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\FrontendInterface;
use App\Interfaces\VirusInterface;
use App\Models\HivCases;
use App\Models\Province;
use App\Models\Virus;
use App\Properties\Years;
use App\Repositories\HivCaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    private $frontend;
    private $hivCases;


    public function __construct(FrontendInterface $frontend, HivCaseRepository $hivCases)
    {
        $this->frontend = $frontend;
        $this->hivCases = $hivCases;
    }

    public function home()
    {
        return view('frontend.home', [
            'viruses' => Virus::all()
        ]);
    }

    public function detail($id)
    {
        // return Years::getYears();
        return view('frontend.marker', [
            'virus' => $this->frontend->getVirus($id),
            'provinces' => Province::all(),
            'years'     => Years::getYears(),
            'request' => NULL,
            'years' => HivCases::select('year')->distinct()->groupBy('year')->orderBy('year')->get(),
            'individualCases' => $this->frontend->hivCases(),
        ]);
    }

    public function listCitations(Request $request)
    {
        // return $this->frontend->listCitations($request);
        return view('frontend.citation.listCitation', [
            'request' => $request,
            'virus' => $this->frontend->getVirus($request['virus_id']),
            'listCitations' => $this->frontend->listCitations($request)
        ]);
    }

    public function detailCitation($id)
    {
        // version 1
        // $virus_id = $this->frontend->detailCitation($id)->sample[0]->viruses_id;
        // return view('frontend.citation.detail', [
        //     'request' => NULL,
        //     'virus' => $this->frontend->getVirus($virus_id),
        //     'citation' => $this->frontend->detailCitation($id)
        // ]);
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        // return $this->frontend->detailCitation($id);
        return view('frontend.citation.detail', [
            'request' => NULL,
            'virus' => $virus,
            'citation' => $this->frontend->detailCitation($id)
        ]);
    }

    public function detailFasta($id)
    {
        // $virus_id = $this->frontend->detailFasta($id)->sample[0]->viruses_id;
        // return $id;
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        // return $this->frontend->detailFasta($id);
        return view('frontend.citation.fasta', [
            'request' => NULL,
            'virus' => $virus,
            'citation' => $this->frontend->detailFasta($id)
        ]);
    }
}
