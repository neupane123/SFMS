<?php

namespace App\Http\Controllers;

use App\Fees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // SELECT f.amount, sess.name as session, g.grade, s.section FROM fees f
        // join asessions sess on f.asession_id = sess.id
        // join grade_section gs on f.grade_id = gs.id
        // join grades g on g.id = gs.grade_id
        // join sections s on s.id = gs.section_id
        // join fee_types ft on ft.id = f.fee_type
        // WHERE f.asession_id = '1' AND f.grade_id = '1' AND f.fee_type = '2' GROUP BY g.grade

        $data = DB::table('fees')
                ->join('asessions', 'asessions.id', '=' , 'fees.asession_id')
                ->join('grade_section', 'grade_section.id', '=' , 'fees.grade_id')
                ->join('grades', 'grade_section.grade_id', '=' , 'grades.id')
                ->select('asessions.name as session', 'grades.grade', 'fees.amount')
                ->where([['fees.asession_id', '=' , '1'], ['fees.fee_type', '=', '2']])->get();
        // dd($data);

        echo "<table border='1' width='100%'>";
        echo "<tr>";
        echo "<th>SN</th>";
        echo "<th>Grade</th>";
        echo "<th>Fees/month (RS.)</th>";
        echo "</tr>";

        $i=1;
        if($data)
        {
            foreach($data as $d){
                echo "<tr>";
                echo "<td>".$i++."</td>";
                echo "<td>".$d->grade."</td>";
                echo "<td> Rs. ".$d->amount."</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function show(Fees $fees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function edit(Fees $fees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fees $fees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fees $fees)
    {
        //
    }
}
