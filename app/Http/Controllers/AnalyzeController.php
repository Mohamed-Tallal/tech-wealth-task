<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalyzeRequest;
use Illuminate\Http\Request;

class AnalyzeController extends Controller
{

    //another solution
    public function analyze(AnalyzeRequest $request)
    {
        $data = $request->validated();
        $cleanedText = preg_replace("/[^A-Za-z0-9\s]/", '', $data['text']);
        $reversedText = strrev(preg_replace("/[^A-Za-z0-9\s]/", '', $cleanedText));
        $matchesPattern = strcasecmp(preg_replace("/\s+/", '', $cleanedText), preg_replace("/\s+/", '', $reversedText)) === 0;
        return response()->json([
            'matches_pattern' => (bool) $matchesPattern,
            'reversed_text' => (string) $reversedText,
        ]);
    }


    /*
    // php smagic function
    public function analyze(AnalyzeRequest $request)
    {
        $data = $request->validated();
        $cleanedText = preg_replace("/[^A-Za-z0-9\s]/", '', $data['text']);
        $reversedText = strrev($cleanedText);
        $matchesPattern = strcasecmp(preg_replace("/\s+/", '', $cleanedText), preg_replace("/\s+/", '', $reversedText)) === 0;

        return response()->json([
            'matches_pattern' => (bool) $matchesPattern,
            'reversed_text' => (string) $reversedText,
        ]);
    }*/
}
