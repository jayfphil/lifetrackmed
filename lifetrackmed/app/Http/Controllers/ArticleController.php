<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\LifeTrack;
use Config;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function store(Request $request)
    {

        $lifetrack = new LifeTrack();
        $lifetrack->studyday = $request->studyday;
        $lifetrack->studygrowth = $request->studygrowth;
        $lifetrack->forecastmonths = $request->forecastmonths;

        $lifetrack->save();
        return response()->json(['success'=>'Data is successfully added','result'=>$request]);
    }

    public function calculate(Request $request)
    {

        $result = array();
        $result['month'] = array();

        for ($i = 1; $i <= $request->forecastmonths; $i++) {
            
            // Assigning variables
            $result['month'][$i] = array();

            $result['month'][$i]['name'] = date("M", mktime(0, 0, 0, $i))." ".date("Y");

            $result['month'][$i]['days'] = cal_days_in_month(CAL_GREGORIAN,$i,date("Y"));

            $result['month'][$i]['hours'] = ($result['month'][$i]['days'] * 24);

            $result['month'][$i]['studiesgrowth'] = ($request->studyday * ($request->studygrowth/100));

            $result['month'][$i]['studiesperday'] =($result['month'][$i]['days'] * $request->studyday);

            $result['month'][$i]['studperdaywithgrowth'] =($result['month'][$i]['days'] * ($request->studyday+$result['month'][$i]['studiesgrowth']));

            // computation of number of studies
            $result['eq_1k'] = ($result['month'][$i]['studiesperday']/(int)Config::get('constants.studiesperram.studies'));

            $result['eq_mbperstudy'] = ($result['month'][$i]['studiesperday']*(int)Config::get('constants.mbperstudy.mbram'));

            $result['eq_reqram'] = ($result['eq_1k']*(int)Config::get('constants.studiesperram.mbram'));

            // Equal of cost per hour
            $result['eq_gbperstudy'] = ($result['eq_reqram']/(int)Config::get('constants.gbperhour.gbram'));

            $result['eq_perhour'] = ($result['eq_gbperstudy']*(float)Config::get('constants.gbperhour.hourcost'));

            // Cost storage
            $result['eq_storam'] = ($result['eq_mbperstudy']/(int)Config::get('constants.storagecost.gbram'));

            $result['eq_coststo'] = ($result['eq_storam']*(float)Config::get('constants.storagecost.monthcost'));

            // total cost per hour
            $result['month'][$i]['costperhour'] = number_format(($result['month'][$i]['hours']*$result['eq_perhour']),2);

            $result['month'][$i]['costpermonth'] = number_format($result['eq_coststo'],2);
        }

        return response()->json(['success'=>'Data is successfully added','results'=>$result]);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}