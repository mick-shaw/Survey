<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;
use App\Survey;
use App\QuestionResponse;
use App\ResponseTranscription;
use Twilio\Twiml;
use Cookie;
use DB;
use Excel;

class MaatwebsiteDemoController extends Controller

{

	public function importExport()

	{

		return view('importExport');

	}

	public function downloadExcel($type)

	{

		$data = QuestionResponse::get()->toArray();

		return Excel::create('Survey Dump', function($excel) use ($data) {

			$excel->sheet('mySheet', function($sheet) use ($data)

	        {

				$sheet->fromArray($data);

	        });

		})->download($type);

	}

	public function importExcel()

	{

		if(Input::hasFile('import_file')){

			$path = Input::file('import_file')->getRealPath();

			$data = Excel::load($path, function($reader) {

			})->get();

			if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {

					$insert[] = ['title' => $value->title, 'description' => $value->description];

				}

				if(!empty($insert)){

					DB::table('items')->insert($insert);

					dd('Insert Record successfully.');

				}

			}

		}

		return back();

	}

}