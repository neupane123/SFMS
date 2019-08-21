<?php

namespace App\Http\Controllers;

use App\Asession;
use App\FeeCollection;
use App\GradeSection;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //         select  fc.months, fc.tamount, g.grade, s.section , sess.name as acamdemic_session, stu.fname, stu.lname from fee_collections fc
        // join asessions sess on sess.id = fc.asess_id
        // join grade_section gs on gs.id = fc.grade_id
        // join grades g on g.id = gs.grade_id
        // join sections s on s.id = gs.section_id
        // join students stu on stu.id = fc.student_id
        // WHERE fc.asess_id = '1' AND fc.grade_id = '2'

        $data = DB::table('fee_collections')
            ->join('asessions', 'asessions.id', '=' , 'fee_collections.asess_id')
            ->join('grade_section', 'fee_collections.grade_id', '=' , 'grade_section.id')
            ->join('grades', 'grade_section.grade_id', '=' , 'grades.id')
            ->join('sections', 'grade_section.section_id', '=' , 'sections.id')
            ->join('students', 'fee_collections.student_id', '=' , 'students.id')
            ->join('fee_types', 'fee_collections.fee_type', '=' , 'fee_types.id')
            ->select('asessions.name', 'students.fname', 'students.lname', 'grades.grade','sections.section','fee_types.type','fee_collections.months', 'fee_collections.tamount')->where([['fee_collections.asess_id','=','1'], ['fee_collections.grade_id' , '=' , '2'], ['fee_collections.fee_type' , '=' , '2']])->get();

            // $data = DB::table('fee_collections')->get();
            // dd($data);
            if($data)
            {
                echo "<center><h1> Session : ". $data->first()->name . "</h1></center>";
                echo "<center><h1> Grade : ". $data->first()->grade . " (" . $data->first()->section . ")  </h1></center>";
                echo "<table border=1 width=\"100%\">";
                echo "<tr>";
                echo "<th>SN</th>";
                echo "<th>Name</th>";
                echo "<th>Paid For</th>";
                echo "<th>Total Amount</th>";
                echo "</tr>";
                $i=1;
                foreach($data as $d) {
                    echo "<tr>";
                    echo "<td>". $i++ . "</td>";
                    echo "<td>". $d->fname . " " . $d->lname . "</td>";
                    echo "<td>". $d->months . "</td>";
                    echo "<td>". $d->tamount ."</td>";
                    echo "</tr>";
                }
            }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session = Asession::all();
        
        $grades = DB::table('grade_section')
                    ->join('grades', 'grades.id', '=', 'grade_section.grade_id')
                    ->join('sections', 'sections.id', '=', 'grade_section.section_id')
                    ->select('grade_section.id', 'grades.grade', 'sections.section')
                    ->get();

        $fee_type = \App\FeeType::all();

        // dd($session);

        return view('fees.collect',compact('session','grades','fee_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function show(FeeCollection $feeCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeCollection $feeCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeCollection $feeCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeCollection $feeCollection)
    {
        //
    }


    public function ajaxGetStudentByClass()
    {
        if(request()->ajax())
        {
            $students = [];
            $data = request()->all();

            if($data)
            {
                $students = \App\Student::where([['grade_id','=', $data['grade'] ], ['asession_id', '=', $data['session'] ] ])->get() ;
                if($students)
                {
                    $abc = "<option value=''>-------select student----------</option>";
                    foreach($students as $stu)
                    {   
                        $abc .= "<option value = '". $stu->id . "'> " . $stu->fname . " " . $stu->lname . " </option>";
                    }

                    return $abc;
                }
            }

        }
    }

    public function ajaxGetFeeByClass()
    {
        if(request()->ajax())
        {
        
            $data = request()->all();
            // dd($data);
            if($data)
            {
                $fee_amount = \App\Fees::where([ 
                                                    ['grade_id','=', $data['grade'] ], 
                                                    ['asession_id', '=', $data['session'] ], 
                                                    ['fee_type', '=', $data['fee_type'] ] 

                                                ])->get() ;

                if($fee_amount)
                {
                    return $fee_amount->first()->amount;

                }
                // if($students)
                // {
                //     $abc = "<option value=''>-------select student----------</option>";
                //     foreach($students as $stu)
                //     {   
                //         $abc .= "<option value = '". $stu->id . "'> " . $stu->fname . " " . $stu->lname . " </option>";
                //     }

                //     return $abc;
                // }
            }

        }
    }

    public function ajaxCheckStuFeePaymentHistory()
    {
        if(request()->ajax())
        {
            $data = request()->all();

            if($data)
            {
                $history = \App\FeeCollection::where([ ['asess_id', '=', $data['session']] , ['grade_id', '=', $data['grade']], ['student_id', '=', $data['student_id']], ['fee_type' , '=' , $data['fee_type']] ])->first();
                if($history)
                {
                    return $history;
                }
            }
        }
    }

    public function ajaxTakePaymentPrintReceipt()
    {
        if(request()->ajax())
        {
            dd(request()->all());
        }
    }


}
