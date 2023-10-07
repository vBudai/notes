<?php

namespace controllers;

use base\BaseController;
use controllers\validators\NoteValidator;
use models\ImageModel;
use models\NoteModel;
use routing\Request;

class NoteController extends BaseController
{

    private NoteValidator $validator;

    public function __construct(){
        $this->validator = new NoteValidator();
    }

    public function index(): bool|string
    {
        return $this->view('notes.php');
    }

    public function getNotes(): bool|string
    {
        $model = new NoteModel();

        $notes = $model->select('*');

        // Добавление изображений
        /*foreach ($notes as &$note)
            $note['images'] = $this->getNoteImages($note['id']);*/

        return $this->view('api.php', array_reverse($notes));
    }

    /*private function getNoteImages(string $noteId): array
    {
        $model = new ImageModel();
        return $model->select(['id', 'imageUrl'], ['noteId' => $noteId]);
    }*/

    public function createNote(Request $request): bool|string
    {
        // Ответ по умолчанию
        $response = [
            'status' => 400,
            'message' => 'Params error',
        ];

        $model = new NoteModel();
        $newNoteData = $request->getData();

        if($this->validator->validate($newNoteData)){
            $newNoteId = $model->insert($newNoteData);
            if($newNoteId)
                $response = [
                    'status' => 201,
                    'note' => $model->select('*', ['id' => $newNoteId]),
                ];
        }

        return $this->view('api.php', $response);
    }

    public function editNote(Request $request, array $params): bool|string
    {

        $response['status'] = '400';
        $newDataNote = $request->getData();

        if(!isset($params['noteId']))
            $response['message'] = 'Wrong id of note';
        else{
            $newDataNote['id'] = $params['noteId'];

            if($this->validator->validate($newDataNote)){
                $model = new NoteModel();

                // Вытаскивание id заметки
                $noteId = $newDataNote['id'];
                unset($newDataNote['id']);

                // Обновление времени создания
                $newDataNote['updatedAt'] = date('Y-m-d H:i:s');

                // Обновление и формирование ответа
                if($model->update($noteId, $newDataNote)){
                    $noteData = $model->select('*', ['id'=>$noteId]);
                    $response = [
                        'status' => 200,
                        'note' => $noteData
                    ];
                }
            }
            else
                $response['message'] = 'Wrong params';
        }



        return $this->view('api.php', $response);
    }

    public function deleteNote(Request $request, array $params): bool|string
    {
        $model = new NoteModel();

        $response = [
            'status' => 400,
            'message' => 'Wrong id'
        ];
        if(!isset($params['noteId']))
            $response['message'] = 'Empty id';
        elseif($this->validator->validate(['id' => $params['noteId']]) && $model->delete($params['noteId']))
            $response = [
                'status' => 204
            ];

        return $this->view('api.php', $response);
    }

    /*public function loadImage(): bool|string
    {
        //return $this->view('api.php', []);
    }*/

    /*public function deleteImage(): bool|string
    {
        //return $this->view('api.php', []);
    }*/

}