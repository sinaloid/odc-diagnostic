<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    
        return Question::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();
        foreach($datas as $element){
            $data = new Question();
            $data->question = $element['question'];
            $data->categorie_id = $element['categorie_id'];
            $data->user_id = auth()->user()->id;
            $data->slug = Str::slug(Str::random(10));
            $data->save();
        }

        return Question::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return Question::where("id", $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $data = Question::find($id);

        if(isset($data)){
            $data->question = $request->question;
            $data->categorie_id = $request->categorie_id;
            $data->user_id = auth()->user()->id;
            $data->slug = Str::slug(Str::random(10));
            $data->save();
        }
       
        

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = Question::find($id);
        if(isset($data)){
            $data->delete();
            return "supprimer avec success";
        }

        return "la question n'existe pas";
    }

    public function destroyAll(){
        $datas = Question::all();

        /*foreach($datas as $dd){
            $dd->delete();
        }*/

        return "Tout les donnees ont ete supprimer avec success";
    }
}
