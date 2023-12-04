<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\Plant;

class PlantController extends AControllerBase
{
    /**
     * @inheritDoc
     */
    public function index(): Response
    {
    }

    public function add(): Response
    {
        return $this->html();
    }

    public function edit(): Response
    {
        $id = (int) $this->request()->getValue('id');
        $plant = Plant::getOne($id);

        if (is_null($plant)) {
            throw new HTTPException(404);
        }

        return $this->html(
            [
                'plant' => $plant
            ]
        );
    }

    public function save()
    {
        $id = (int)$this->request()->getValue('id');
        $oldFileName = "";

        if ($id > 0) {
            $plant = Plant::getOne($id);
            $oldFileName = $plant->getPicture();
        } else {
            $plant = new Plant();
        }
        $plant->setText($this->request()->getValue('text'));
        $plant->setPicture($this->request()->getFiles()['picture']['name']);

        $formErrors = $this->formErrors();
        if (count($formErrors) > 0) {
            return $this->html(
                [
                    'plant' => $plant,
                    'errors' => $formErrors
                ], 'add'
            );
        } else {
            if ($oldFileName != "") {
                FileStorage::deleteFile($oldFileName);
            }
            $newFileName = FileStorage::saveFile($this->request()->getFiles()['picture']);
            $plant->setPicture($newFileName);
            $plant->save();
            return new RedirectResponse($this->url("home.index"));
        }
    }

    public function delete()
    {
        $id = (int) $this->request()->getValue('id');
        $plant = Plant::getOne($id);

        if (is_null($plant)) {
            throw new HTTPException(404);
        } else {
            FileStorage::deleteFile($plant->getPicture());
            $plant->delete();
            return new RedirectResponse($this->url("home.index"));
        }
    }

    private function formErrors(): array
    {
        $errors = [];
        if ($this->request()->getFiles()['picture']['name'] == "") {
            $errors[] = "Pole Súbor obrázka musí byť vyplnené!";
        }
        if ($this->request()->getValue('text') == "") {
            $errors[] = "Pole Text príspevku musí byť vyplnené!";
        }
        if ($this->request()->getFiles()['picture']['name'] != "" && !in_array($this->request()->getFiles()['picture']['type'], ['image/jpeg', 'image/png'])) {
            $errors[] = "Obrázok musí byť typu JPG alebo PNG!";
        }
        if ($this->request()->getValue('text') != "" && strlen($this->request()->getValue('text') < 5)) {
            $errors[] = "Počet znakov v text príspevku musí byť viac ako 5!";
        }
        return $errors;
    }
}
