<?php

namespace dsa\Http\Controllers;

use dsa\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class FileController extends Controller {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
    }

    public function getAdd(Request $request){
      return $this->returnfileAdd($request);

    }
    public function postAdd(Request $request){
        $file = new \dsa\File();
        $file->event_id = $request->event_id;
        $file->Name = $request->FileName;
        $file->TotalRows = $request->TotalRows;
        if($request->CompletedRows == ""){
          $file->CompletedRows = '0';
        } else {
          $file->CompletedRows = $request->CompletedRows;
        }
        if($request->Completed == "true"){
          $file->Completed = 1;
        }else{
          $file->Completed = 0;
        }
        $file->save();
        return $this->returnfileAdd($request);
    }
    public function postComplete(Request $request){
      $file = \dsa\File::find($request->file_id);
      $file->CompletedRows = $file->TotalRows;
      $file->Completed = "1";
      $file->user_id = $request->user_id;
      $file->save();

      return $this->returnfileAdd($request);
    }
    public function postCompleteReg(Request $request){
      $file = \dsa\File::find($request->file_id);
      $file->CompletedRows = $file->TotalRows;
      $file->Completed = "1";
      $file->user_id = $request->user_id;
      $file->save();

      return view('home');
    }
    public function getEdit(Request $request){
      $file = \dsa\File::find($request->file_id);
      $event = \dsa\Event::with('files')->find($request->event_id);
      return view('file.edit')->with([
        'editfile' => $file,
        'event' => $event
      ]);
    }
    public function postEdit(Request $request){
      $file = \dsa\File::find($request->file_id);
      $file->Name = $request->FileName;
      $file->TotalRows = $request->TotalRows;
      if($request->CompletedRows == ""){
        $file->CompletedRows = '0';
      } else {
        $file->CompletedRows = $request->CompletedRows;
      }
      if($request->Completed == "true"){
        $file->Completed = 1;
        $file->user_id = $request->user_id;
      }else{
        $file->Completed = 0;
        $file->user_id = null;
      }
      $file->save();

      return $this->returnfileAdd($request);
    }

    public function getUpload(Request $request){
      return view('file.upload1');
    }

    private function returnfileAdd(Request $request){
      $event = \dsa\Event::with('files')->find($request->event_id);
      return view('file.add')->with([
        'event' => $event
      ]);
    }
}
