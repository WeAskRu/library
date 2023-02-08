<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSubscription;
use app\services\AuthorSubscriptionService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AuthorSubscriptionController implements the CRUD actions for AuthorSubscription model.
 */
class AuthorSubscriptionController extends Controller
{
    public function actionCreate(int $author_id)
    {
        $authorSubscription = new AuthorSubscription();
        $authorSubscription->author_id = $author_id;

        if ($this->request->isPost) {
            if ($authorSubscription->load($this->request->post())) {
                AuthorSubscriptionService::create($authorSubscription);
                return $this->redirect(['success', 'author_id' => $authorSubscription->author_id]);
            }
        } else {
            $authorSubscription->loadDefaultValues();
        }

        return $this->render('create', [
            'authorSubscription' => $authorSubscription,
        ]);
    }

    public function actionSuccess(int $author_id)
    {
        $author = Author::findOne($author_id);
        return $this->render('success', [
            'author' => $author,
        ]);
    }

    protected function findModel(int $id): AuthorSubscription
    {
        if (($model = AuthorSubscription::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
