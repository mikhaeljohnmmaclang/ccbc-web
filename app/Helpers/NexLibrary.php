<?php 
use App\Models\{
    Module, 
	User
};

function myReturn($status, $message){
    echo json_encode(array(
     'stat'   	=> $status,
     'msg'  	=> $message
     ));
}

function myReturn_data($status, $message, $data){
    echo json_encode(array(
     'stat'   	=> $status,
     'msg'  	=> $message,
     'data'		=> $data
     ));
}


function getAge($date){
   	$from = new DateTime($date); //'1970-02-01'
   	$to   = new DateTime('today');
   	return $from->diff($to)->y;
}

function genOTP($cnt = 6) {
	$characters = '0123456789';
	$string     = substr(str_shuffle($characters), 0, $cnt);
	$uniq_id    = $string;
	return $uniq_id;
}

function genUniqCode($number){

    //$format  = 'N'.date('ynj').'-';
    $format = '';
    
    if($number <= 9){
      $format .= '000'.$number;

    } else if($number <= 99){
      $format .= '00'.$number;

    } else if($number <= 999){
      $format .= '0'.$number;

    } else {
      $format .= $number;
    }
    return $format;
}

function clean_str($str) {
      
    // Using str_replace() function 
    // to replace the word 
    $res = str_replace( array( '\'', '"',
    ',' , ';', '<', '>','_' ), ' ', $str);
      
    // Returning the result 
    return $res;
}

function date_now(){
	date_default_timezone_set('Asia/Manila');
	return date('Y-m-d');
}

function datetime_now(){
	date_default_timezone_set('Asia/Manila');
	return date('Y-m-d H:i:s');
}


function generate_no_format($number){
	
	$format = '';
    
    if($number <= 9){
      $format .= '000'.$number;

    } else if($number <= 99){
      $format .= '00'.$number;

    } else if($number <= 999){
      $format .= '0'.$number;

    } else {
      $format .= $number;
    }
    return $format;
}

function validateDateTime($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}


/**
* PARAMETERS
*
* if (! function_exists('func_name')) {} - check if function is already defined 
*
* In $condition parameter (where), use an array 
* Example: 
*
* 	$where = array(
			array (column_name, conditional_operator, value),
			array ('id', '=', 1)
		);

	$selected = array(column_name); //separated by comma

	$whereIn = array('id', [1, 2, 3])
**/


function getTable($tablename) {
	return DB::table($tablename)->get();
}

function insertData($tablename, $data){
	DB::table($tablename)->insert($data);
}

function updateData($tablename, $id, $data){
	return DB::table($tablename)
      	->where('id', $id)
      	->update($data);
}

function deleteData($tablename, $condition){
	DB::table($tablename)->where($condition)->delete();
}

function getDataById($tablename, $id){
	return DB::table($tablename)->find($id);
}

function tableWhere($tablename, $condition) {
	return DB::table($tablename)
            ->where($condition)
            ->get();
}

function tableWhereIn($tablename, $condition){
	return DB::table($tablename)
	        ->whereIn($condition)
	        ->get();
}

function tableWhereRaw($tablename, $condition){
	return DB::table($tablename)
             ->where($condition)
             ->get();
}

function selectedWhere($tablename, $selected, $condition){
	return DB::table($tablename)->select($selected)->where($condition)->get();
}

function paginate($tablename, $condition, $data, $count){
	return DB::table($tablename)
		    ->select(['*'])
		    ->whereRaw($condition, $data)
		    ->paginate($count);
}


function check_uniqueproject(Request $request, $projectName) {
    $project_name = $request->input('project_name');
    $count        = Projects::where('project_name', $project_name)->count();
    return ($count == 0) ? 'true' : 'false';
}

function tableSelect($tablename, $selected) {
	return DB::table($tablename)->selectRaw($selected)->get();
}

function tableSelectWhereRaw($tablename, $selected, $where){
	return DB::table($tablename)->selectRaw($selected)->where($where)->get();
}

function tableSelectWhererawGroup($tablename, $selected, $where, $group){
  return DB::table($tablename)->selectRaw($selected)->where($where)->groupBy($group)->get();
}

function form($table, $form, $data = null) {
	$columns = DB::getSchemaBuilder()->getColumnListing($table);
	$formData = array();
	foreach ($columns as $column) {
		if (array_key_exists($column, $form)) {
			$formData[$column] = $form[$column];
		}
	}

	return is_null($data) ? $formData : array_merge($formData, $data);
}

function insertForm($table, $form, $data = null) {
	$formData = form($table, $form, $data);
	insertData($table, $formData);

	return DB::getPdo()->lastInsertId();
}

function getData($table, $select = null, $where = null) {
	$query = DB::table($table);

	if (!is_null($select)) {
		if (!is_array($select[0])) {
			$selectRaw = implode(', ', $select);
			$query = $query->selectRaw($selectRaw);
		} else {
			$query = $query->where($select);
		}
		
	}

	if (!is_null($where)) {
		if (sizeof($where) > 0) {
			$query = $query->where($where);
		}
	}

	return $query->get();
}

function updateForm($table, $id, $form, $data = null) {
	$formData = form($table, $form, $data);
	updateData($table, $id, $formData);
}

function getFirst($table, $select = null, $where = null) {
	$query = DB::table($table);

	if (!is_null($select)) {
		if (!is_array($select[0])) {
			$selectRaw = implode(', ', $select);
			$query = $query->selectRaw($selectRaw);
		} else {
			$query = $query->where($select);
		}
		
	}

	if (!is_null($where)) {
		if (sizeof($where) > 0) {
			$query = $query->where($where);
		}
	}

	return $query->first();
}

 function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data 	= array();
    $text = '';

    if (($handle = fopen($filename, 'r')) !== false)
    {	
    	
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }

        fclose($handle);
    }

    return $data;
}

function get_access($module) {
	$mod_id = Module::where('module_name', $module)->first()->id;
	$user = User::where('id', auth()->user()->id)
            ->with('access', function ($query) use ($mod_id) {
				$query->where('module_id', $mod_id);
			})
            ->first();
	return $user->access[0];
}


function counter(){
	$physical_count = DB::table('physical_count')
					->where('status', '1')->count();

	$return_pullouts = DB::table('return_pullouts')
					->where('status', 'Pending')->count();

	$pr 			= DB::table('purchase')
					->where(['status' => '1', 'type' => 'pr'])->count();

	$receiving 		= DB::table('receiving')
					->where('status' , 'Pending')->count();



	$count = [$physical_count, $return_pullouts, $pr, $receiving]; 
	return $count;
}

function generate_case_no(){
	$cases = DB::table('cases')
			->selectRaw('case_type, COUNT(id) as cnt')
			->groupBy('case_type')
			->get();

	$data = [];
	$type = ['REM', 'HOA'];

	foreach($type as $t){

		$case_type  = $cases->where('case_type', $t)->first();
		$cnt 		= emptY($case_type->cnt) ? 1 : $case_type->cnt + 1;

		$case_no 	= 'RIII-'.$t.'-'.date('mdY').'-'.generate_no_format($cnt);
		array_push($data, ['case_type' => $t, 'case_no' => $case_no]);
	}

	return $data;
}

function get_active_sem(){
	$current_school_year = DB::table('school_years')
							->selectRaw('semester_id')
							->whereRaw('YEAR(NOW()) BETWEEN start_year AND end_year')
							->first();
	return $current_school_year->semester_id;
}

function active_sy(){
	$q = DB::table('school_years')
			->selectRaw('id')
			->whereRaw('YEAR(NOW()) BETWEEN start_year AND end_year')
			//->where('status', '1')
			->first();

	return $q->id;
}

function active_sy_sem(){
	$q = DB::table('school_years')
			->where('status', '1')
			->first();
	return $q;
}

function is_weekend($date) {
    return (date('N', strtotime($date)) >= 6);
}


function dateDiffInDays($date1, $date2) 
{
    $diff = strtotime($date2) - strtotime($date1);
    return abs(intval(round($diff / 86400)));
}

function daysLeft($date1, $date2) 
{
    $diff = strtotime($date2) - strtotime($date1);
    return intval(round($diff / 86400));
}

function toDate($date){
	return date('Y-m-d', strtotime($date));
}

function slide_weekend($date){
	$week_day = date("w", strtotime($date));
    //SATURDAY + 2 days
    if ($week_day == 6) {
        $date = date('Y-m-d', strtotime($date. '+ 2 days'));
    }
    //SUNDAY + 1 day
    if ($week_day == 0) {
        $date = date('Y-m-d', strtotime($date. '+ 1 day'));
    }

    return $date;
}



?>