<?php
/**
     * Version 3
     *
     */
namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionResponse extends Model
{

    protected $fillable = ['type', 'response', 'session_sid', 'caller',  'agentid'];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function responseTranscription()
    {
        return $this->hasOne('App\ResponseTranscription');
    }

    public function scopeResponsesForSurveyByCall($query, $surveyId)
    {
        return $query
            //->join('questions', 'questions.id', '=', 'question_responses.question_id')
           // ->join('surveys', 'surveys.id', '=', 'questions.survey_id')
           // ->leftJoin('response_transcriptions', 'response_transcriptions.question_response_id', '=', 'question_responses.id')
           // ->where('surveys.id', '=', $surveyId)
            ->orderBy('question_responses.created_at')
            ->orderBy('question_responses.id');
    }
}
