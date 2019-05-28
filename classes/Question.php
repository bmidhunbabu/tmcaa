<?php

class Question extends Model
{
    public static $table = 'questions';

    public static function create(array $data)
    {
        $question_id = null;
        $question = array(
            'question' => $data['question'],
            'description' => $data['description'],
            'exam_id' => $data['exam_id'],
        );
        if (isset($data['photo'])) {
            $question['photo'] = $data['photo'];
        }
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

    public static function update(array $fields, $id)
    {
        $question_id = null;
        $question = array(
            'question' => $fields['question'],
            'description' => $fields['description'],
        );
        if (isset($fields['photo'])) {
            $question['photo'] = $fields['photo'];
        }
        $question_id = parent::update($question, $id);
        if ($question_id) {
            $question = self::find($id);
            $answers = $question->answers();
            foreach ($answers as $answer) {
                parent::delete($answer->id);
            }
            $answers = $fields['answers'];
            foreach ($answers as $answer) {
                $arr = array(
                    'answer' => $answer,
                    'question_id' => $question_id,
                );
                if ($fields['correct_answer'] == $answer) {
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

    public function exam()
    {
        return $this->belongsTo('questions', 'exam_id', 'exams', 'id', 'Exam');
    }
}
