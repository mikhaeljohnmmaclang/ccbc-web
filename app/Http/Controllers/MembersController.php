<?php

namespace App\Http\Controllers;

use App\Models\Activity_Logs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Offerings;
use App\Models\Members;
use App\Models\Commitments;
use App\Models\Ministries;
use Illuminate\Support\Carbon;
use App\Models\Transactions;
use App\Models\Services;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivityLogsTrait;

class MembersController extends Controller
{

    use ActivityLogsTrait;

    //members
    public function members()
    {
        $ministries = DB::table('ministries')->where('status', '1')
            ->orderBy('id')
            ->get();

        $services = DB::table('services')->where('status', '1')
            ->get();

        return view('members.members')
            ->with('services', $services)
            ->with('ministries', $ministries);
    }

    // Get list of members
    public function getmembers()
    {
        $query = DB::table('members')
            ->selectRaw('
            commitments.id as commitment_id, 
            COALESCE(commitments.amount, 0) as ff_amount, 
            members.*, 
            CONCAT(members.last_name  , ", "  ,members.first_name  ) as full_name
            ')
            ->leftjoin('commitments', 'commitments.member_id', 'members.id')
            ->where('commitments.name', 'firstfruit')
            ->where('commitments.year', date('Y'))
            ->where('members.status', '1')
            ->get();
        return DataTables::of($query)->make(true);
    }

    public function viewMember($id)
    {
        //info
        $member_data = DB::table('members')
            ->where('id', $id)
            ->where('status', '1')
            ->first();

        //firstfruit
        $ff = DB::table('commitments')
            ->where('member_id', $id)
            ->where('name', 'firstfruit')
            ->where('year', date('Y'))
            ->first();

        //ff collection
        $ff_collection = DB::select("SELECT SUM(offerings.amount) AS amount, transactions.member_id FROM transactions
        LEFT JOIN offerings ON offerings.transaction_id= transactions.id
        LEFT JOIN ministries ON ministries.id = offerings.ministry_id
        WHERE transactions.member_id = " . $id . "
         AND ministries.name = 'Firstfruits'
        AND ministries.status = '1'
        AND DATE_FORMAT(transactions.date,'%Y') = YEAR(CURDATE())");


        //Check if she/he has firstfruit commitment
        if ($ff) {
            $ff_amount = number_format($ff->amount);
        } else {
            $ff_amount = 0;
        }

        // ff collection percentage
        if (
            $ff_collection[0]->amount == null ||
            $ff_collection[0]->amount == 0 ||
            $ff->amount == null ||
            $ff->amount == 0
        ) {
            $ff_percentage = 0;
        } else {
            $ff_percentage = ($ff_collection[0]->amount / $ff->amount) * 100;
        }


        //Check if she/he has firstfruit collection
        if ($ff_collection) {
            $ff_collected_amount = number_format($ff_collection[0]->amount);
        } else {
            $ff_collected_amount = 0;
        }

        return view('members.view_member')
            ->with('ff', $ff_amount)
            ->with('ff_collection', $ff_collected_amount)
            ->with('ff_percentage', $ff_percentage)
            ->with('member_data', $member_data);
    }

    public function viewMemberOfferingSummary($id)
    {

        $query = DB::select('SELECT o.ministry_name ,COALESCE(o.total_amount, 0) AS total_amount FROM ministries
         INNER JOIN (SELECT 
                 offerings.`ministry_id` AS ministry_id,
                     ministries.name AS ministry_name,
                     offerings.transaction_id,
                     SUM(amount) AS total_amount 
                   FROM
                     offerings 
                     LEFT JOIN 
                     ministries ON ministries.id = offerings.`ministry_id`
                     LEFT JOIN transactions ON transactions.`id` = offerings.`transaction_id`
                     WHERE transactions.`member_id` = ' . $id . '
                      AND YEAR(transactions.date) = ' . date('Y') . '
                   GROUP BY ministry_id
                   )
           AS o ON o.`ministry_id` = ministries.id');

        return DataTables::of($query)->make(true);
    }

    public function addTransaction(Request $request)
    {

        // try {
        DB::beginTransaction();

        $transactions = new Transactions;
        $transactions->member_id = $request->member_id;
        $transactions->service_id = $request->service;
        $transactions->remarks = $request->remarks;
        $transactions->date = $request->date;
        $transactions->status = '1';
        $transactions->save();

        $ministries = DB::table('ministries')->where('status', '1')->count();

        for ($x = 0; $x < $ministries; $x++) {
            if ($request->amount[$x] >= 0) {
                $o = new Offerings();
                $o->transaction_id = $transactions->id;
                $o->ministry_id = $request->m_id[$x];
                $o->amount = $request->amount[$x];
                $o->save();

                $ministry = Ministries::select('funds', 'name')->where('id', $request->m_id[$x])->first();

                $new_balance = $ministry->funds + $request->amount[$x];

                Ministries::where('id', $request->m_id[$x])
                    ->update([
                        'funds' => $new_balance,
                    ]);

                //Get Member Name
                $member = Members::select('first_name', 'last_name')->where("id", $request->member_id)->first();

                //Get Service
                $service = Services::select('name')->where("id", $request->service)->first();
                if ($request->amount[$x] > 0) {
                    //Add Logs 
                    // $logs = new Activity_Logs();
                    // $logs->user_id = Auth::user()->id;
                    // $logs->description =
                    //     "Added &#8369; " . number_format($request->amount[$x]) .
                    //     " to " . $ministry->name .
                    //     " for " . $member->first_name . " " . $member->last_name .
                    //     " at " . $service->name;
                    // $logs->save();

                    $this->saveLogs(
                        Auth::user()->id,
                        Auth::user()->name,
                        "Add Transaction",
                        $ministry->name,
                        $service->name,
                        $member->first_name . " " . $member->last_name,
                        $request->amount[$x],
                        "success"
                    );
                }
            }
        }



        DB::commit();

        return myReturn('success', 'Successfully Transacted!');
        // } catch (\Throwable $error) {
        //     return myReturn('error', $error);
        // }
    }


    public function addMember(Request $request)
    {

        try {
            DB::beginTransaction();

            //add member
            $members = new Members();
            $members->first_name = $request->first_name;
            $members->middle_name = $request->middle_name;
            $members->last_name = $request->last_name;
            $members->email = $request->email;
            $members->birthdate = $request->birthdate;
            $members->address = $request->address;
            $members->contact_number = $request->contact_number;
            $members->gender = $request->gender;
            $members->occupation = $request->occupation;
            $members->status = '1';
            $members->save();

            //save ff commitment
            $commitments = new Commitments();
            $commitments->member_id = $members->id;
            $commitments->name = 'firstfruit';
            $commitments->amount = 0;
            $commitments->year = date('Y');
            $commitments->save();


            DB::commit();

            return myReturn('success', 'Successfully Created.');
        } catch (\Throwable $error) {
            return myReturn('error', "Error in creating member");
        }
    }

    public function setMemberFirstfruit(Request $request)
    {
        try {
            Commitments::where('id', $request->commitment_id)
                ->update([
                    'amount' => $request->amount,
                    'updated_at' => Carbon::now()
                ]);

            $member = Commitments::selectRaw("commitments.id, commitments.member_id, CONCAT(members.first_name, ' ' ,members.last_name) as name")
                ->join('members', 'members.id', 'commitments.member_id')
                ->where('commitments.id', $request->commitment_id)
                ->first();

            //save logs
            $this->saveLogs(
                Auth::user()->id,
                Auth::user()->name,
                "Set Firstfruit",
                null,
                null,
                $member->name,
                $request->amount,
                "success"
            );

            return myReturn('success', 'Firstfruit Successfully Updated');
        } catch (\Exception $error) {
            //save logs
            $this->saveLogs(
                Auth::user()->id,
                Auth::user()->name,
                "Set Firstfruit",
                $error,
                null,
                null,
                $member->name,
                $request->amount,
                "success"
            );
            return myReturn('error', $error);

        }
    }

    // Check Unique Name
    public function checkUniqueMemberName(Request $request)
    {

        $count = DB::table('members')
            ->where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('status', '1')
            ->count();

        return ($count == 0) ? 'true' : 'false';
    }

    // Check Unique Name - Edit
    public function checkUniqueMemberNameEdit(Request $request)
    {
        $count = DB::table('members')
            ->where('id', '!=', $request->id)
            ->where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('status', '1')
            ->count();

        return ($count == 0) ? 'true' : 'false';
    }
}
