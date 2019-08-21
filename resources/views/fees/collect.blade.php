<!DOCTYPE html>
<html>
<head>
	<title>Collect Student Fees</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="c_body">
	<div>
		<div style="width=50%">
			<table border="0">
				<form>
					<label>Academic Session</label><br>
					<select name="session" id="sess">
						@if($session)
						@foreach($session as $sess)
							<option value="{{$sess->id}}" @php echo explode('-',$sess->name)[0] == date('Y') ? 'selected' : ''; @endphp >{{$sess->name}}</option>
						@endforeach
						@endif
					</select>

					<br><label>Grade</label><br>
					<select name="grade" id="gred">
						<option value="">---------select grade----------</option>
						@if($grades)
						@foreach($grades as $g)
							<option value="{{ $g->id }}">{{$g->grade . $g->section }}</option>
						@endforeach
						@endif
					</select>

					<br><label>Select Studnet</label><br>
					<select name="grade" id="stu">
						<option value="">---------select student----------</option>
					</select>

					<br><label>Fee Type</label><br>
					<select name="fee_type" id="fee_t">
						<option value="">---------select Fee Type----------</option>
						@if($fee_type)
							@foreach($fee_type as $ft)
								<option value="{{ $ft->id}}"> {{ $ft->type }}</option>
							@endforeach
						@endif
					</select>

					<br><label>Fee Amount</label>
					<br><input type="number" id="f_amount" name="amount" value="">

					<div class="mont_section" style="display: none;">
						<label>Months</label>
						<span id="s0"><input type="checkbox" id="m0" name="months[]" multiple disabled="" value="1"> jan</span>
						<span id="s1"><input type="checkbox" id="m1"  name="months[]" multiple disabled="" value="2"> feb</span>
						<span id="s2"><input type="checkbox" id="m2" name="months[]" multiple disabled="" value="3"> mar</span>
						<span id="s3"><input type="checkbox" id="m3" name="months[]" multiple disabled="" value="4"> apr</span>
						<span id="s4"><input type="checkbox" id="m4" name="months[]" multiple disabled="" value="5"> may</span>
						<span id="s5"><input type="checkbox" id="m5" name="months[]" multiple disabled="" value="6"> jun</span>
						<span id="s6"><input type="checkbox" id="m6" name="months[]" multiple disabled="" value="7"> jul</span>
						<span id="s7"><input type="checkbox" id="m7" name="months[]" multiple disabled="" value="8"> aug</span>
						<span id="s8"><input type="checkbox" id="m8" name="months[]" multiple disabled="" value="9"> sept</span>
						<span id="s9"><input type="checkbox" id="m9" name="months[]" multiple disabled="" value="10"> oct</span>
						<span id="s10"><input type="checkbox" id="m10" name="months[]" multiple disabled="" value="11"> nov</span>
						<span id="s11"><input type="checkbox" id="m11 name="months[]" multiple disabled="" value="12"> dec</span>

						<br>
						<label>Payment Amount</label>
						<input disabled="" readonly="" id="payment" type="number" name="payment"> <label>Due</label><input type="text" disabled="" value="12000" id="due">

						<a id="print"  href="javascript:void(0)">Take Payment & print receipt</a>
					</div>




					
				</form>
			</table>
		</div>

		<div style="width: 50%">
			
		</div>
	</div>
</body>
</html>
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

 <script src="{{ asset('js/printThis.js') }}"></script>
 <script>

 	$('#gred').on('change',function(){
 		$('#stu').html("<option>loading............</option>");
 		var grade = $(this).val();
 		var session = $('#sess').val();

 		$.ajax({

 			headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   		 },
 			url : "{{ url('studentbyclass')}}",
 			data : {'grade' : grade, 'session' : session},
 			method : "get",
 			success : function(resp){
 				$('#stu').html('').append(resp);

 			}
 		});

 	});


 	$('#fee_t').on('change',function(){
 		$('f_amount').val('loading...');
 		var session = $('#sess').val();
 		var grade = $('#gred').val() ;
 		var fee_type = $(this).val() ;
 		var student_id = $('#stu').val() ;


 		if(fee_type == 2)
 		{
 			// $("type[radio]").prop('disabled',false);
 			$('input[type="checkbox"]').prop('disabled',false);
 			$('#payment').prop('disabled',false);
 			$('.mont_section').show();

 			getHistory(session,grade,fee_type,student_id);

 		}else{

 			// $("type[radio]").prop('disabled',false);
 			$('input[type="checkbox"]').prop('disabled',true);
 			$('#payment').prop('disabled',true);
 			$('.mont_section').hide();
 		}


 		$.ajax({

 			headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   		 },
 			url : "{{ url('feebyclass')}}",
 			data : {'session' : session, 'grade' : grade, 'fee_type' : fee_type},
 			method : "get",
 			success : function(resp){
 				$('#f_amount').val(resp);
 			}
 		});

 		function getHistory(session, grade, fee_type, stu_id)
 		{
 			$.ajax({

 				headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	   		 	},

	   		 	url : "{{ url('feepayhistory')}}",
	   		 	data : {'session' : session, 'grade' : grade, 'fee_type' : fee_type, 'student_id' : stu_id},
	   		 	method : "get",
	   		 	success : function(resp) {

	   		 		var ar = resp.months;
	   		 		ar = parseInt(ar);
	   		 		
	   		 		var i =0;
	   		 		for(i;i<ar;i++)
	   		 		{
	   		 			$("#m" + i).attr('disabled',true);
	   		 			$("#s" + i).hide();
	   		 		}
	   		 		

 					// var ar = resp.months.split(',');
 					// $.each(ar, function(index, value){
 					// 	$("#m" + index).attr('checked',true);
 					// });
 					

 					// $('#payment').val(resp.tamount);
 					// $('#due').val(12000 - resp.tamount);

 				}







 			})
 		}
 	});

 	//automatic fee calculation and receipt printing

 	$("input[type=checkbox]").on('click',function(){
 		var month = $(this).val();
 		var amount = $('#f_amount').val();

 		var first = ($("input[type=checkbox]:enabled:first").val() - 1) * amount;
 		
 		var total_fee = ((amount * month) - first);

 		$('#payment').attr('value', total_fee);

 		var end = $("input[type=checkbox]:enabled:checked:last").val();
 		var start = $("input[type=checkbox]:enabled:checked:first").val();

 		$('#due').attr('value',(12*amount - total_fee - first));

 		// alert(start);
 	});


 	$('#print').on('click',function(){

 		var session = $('#sess').val();
 		var grade = $('#gred').val();
 		var student_id = $('#stu').val();
 		var fee_type = $('#fee_t').val();
 		var fee_amount = $('#payment').val();
 		var end = $("input[type=checkbox]:enabled:checked:last").val();
 		var start = $("input[type=checkbox]:enabled:checked:first").val();

 		$.ajax({


 						 				headers: {
 							        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 							   		 	},

 							   		 	url : "{{ url('receipt_print')}}",
 							   		 	data : {'session' : session, 'grade' : grade, 'fee_type' : fee_type, 'student_id' : student_id, 'month_from' : start, 'month_upto' : end, 'total_amount' : fee_amount},
 							   		 	method : "get",
 							   		 	success : function(resp) {

 							   		 		console.log(resp);
 							   		 		// var ar = resp.months;
 							   		 		// ar = parseInt(ar);
 							   		 		
 							   		 		// var i =0;
 							   		 		// for(i;i<ar;i++)
 							   		 		// {
 							   		 		// 	$("#m" + i).attr('disabled',true);
 							   		 		// 	$("#s" + i).hide();
 							   		 		// }
 							   		 		

 						 					// var ar = resp.months.split(',');
 						 					// $.each(ar, function(index, value){
 						 					// 	$("#m" + index).attr('checked',true);
 						 					// });
 						 					

 						 					// $('#payment').val(resp.tamount);
 						 					// $('#due').val(12000 - resp.tamount);

 						 				}

 		})

 		alert(months);
 		// $('#c_body').printThis();
 	});

 	
 	



 </script>
