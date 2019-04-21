<?php

class Question extends Model
{
    public static $table = 'questions';

    public static function create(array $data)
    {
        $question = array(
            'question' => $data['question'],
            'photo' => $data['photo'],
            'exam_id' => $data['exam_id'],
            'description' => $data['description'],
        );
        $question_id = parent::create($question);
        if ($question_id) {
            $answers = $data['answers'];
            foreach ($answers as $answer) {
                $arr = array(
                    'answer' => $answer,
                    'question_id' => $question_id,
                );
                if ($data['correct_answer'] == $answer) {
                    $arr['is_correct'] = 1;
                }
                Answer::create($arr);
            }
        }
        return $question_id;
    }

    public function answers()
    {
        return $this->hasMany('questions', 'id', 'answers', 'question_id', 'Answer');
    }
}
