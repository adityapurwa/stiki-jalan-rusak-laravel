<?php

namespace App\Http\Controllers;

use App\Report;
use App\ReportVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function listReports(Request $request)
    {
        $search = '%' . $request->get('search') . '%';
        $userId = Auth::user() ? Auth::user()->getAuthIdentifier() : null;

        $reports = Report::getVisibleReports($search);

        $reportIds = array_map(function (Report $report) {
            return $report->id;
        }, $reports->items());

        if (!$userId) {
            return $reports;
        }

        $myVotes = ReportVote::query()
            ->whereIn('report_id', $reportIds)
            ->where('user_id', '=', $userId)
            ->get();

        foreach ($reports->items() as $report) {
            $myVote = array_filter(
                $myVotes->all(),
                function ($vote) use ($report) {
                    return $vote->report_id == $report->id;
                }
            );
            if (count($myVote) === 1) {
                $report->my_vote = array_shift($myVote)->type;
            }
        }

        return $reports;

    }

    public function createReport(Request $request)
    {

        $address = $request->get('address');
        $district = $request->get('district');
        $photo = $request->file('photo');
        $userId = Auth::user()->getAuthIdentifier();

        $this->validate(
            $request,
            [
                'address' => 'required',
                'photo' => 'required|file'
            ]
        );

        $photoName = $photo->storePublicly('public/reports');

        $report = Report::query()->create([
            'address' => $address,
            'district' => $district,
            'photo' => $photoName,
            'user_id' => $userId
        ]);

        return $report;

    }

    public function voteReport(Request $request)
    {

        $reportId = $request->get('report_id');
        $type = $request->get('type');
        $userId = Auth::user()->getAuthIdentifier();

        $this->validate(
            $request,
            [
                'report_id' => 'required',
                'type' => 'in:positive,negative,clear'
            ]
        );


        $vote = ReportVote::query()
            ->where('user_id', '=', $userId)
            ->where('report_id', '=', $reportId)
            ->first();
        if ($vote) {
            if ($type === 'clear') {
                $vote->delete();
                return [
                    'status' => 'Deleted'
                ];
            } else {
                $vote->type = $type;
                $vote->save();
                return $vote;
            }
        } else {
            if ($type !== 'clear') {
                $vote = ReportVote::query()->create([
                    'user_id' => $userId,
                    'report_id' => $reportId,
                    'type' => $type
                ]);
                return $vote;
            }
        }

    }
}
